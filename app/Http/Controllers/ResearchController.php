<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ResearchController extends Controller
{
    public function index()
    {
        // ข้อมูลหมวดหมู่ (หมวดหลัก/หมวดย่อย + จำนวน) โหลดจากไฟล์ static
        // รายการวิทยานิพนธ์ทั้งหมดโหลดฝั่ง client ผ่าน fetch('/data/theses.json')
        // เพื่อให้หน้าโหลดเร็วและ cache ได้ที่เบราว์เซอร์
        $categoriesPath = public_path('data/categories.json');
        $thesesPath = public_path('data/theses.json');

        $categories = [];
        if (file_exists($categoriesPath)) {
            $json = file_get_contents($categoriesPath);
            $categories = json_decode($json, true) ?? [];
        }

        $totalCount = 0;
        if (file_exists($thesesPath)) {
            $theses = json_decode(file_get_contents($thesesPath), true) ?? [];
            $totalCount = count($theses);
        } else {
            $totalCount = array_sum(array_column($categories, 'count'));
        }

        // สร้าง/รีเฟรชไฟล์ public/data/teachers.json (รหัสอาจารย์ -> ชื่อ-นามสกุล + สาขา)
        $this->ensureTeachersJson();

        return view('research.index', [
            'categories' => $categories,
            'totalCount' => $totalCount,
        ]);
    }

    /**
     * ดึงข้อมูลอาจารย์ (join กับสาขา) จากตาราง teacher + major แล้วสร้างไฟล์ public/data/teachers.json
     * โครงสร้างผลลัพธ์: { "<instru>": { "name": "ชื่อ นามสกุล", "major_id": "5", "major": "ชื่อสาขา (TH)", "major_en": "ชื่อสาขา (EN)" } }
     * ผลลัพธ์ถูก cache ไว้ 1 ชั่วโมงเพื่อลดการ query ฐานข้อมูลซ้ำ ๆ ทุก request
     */
    private function ensureTeachersJson(): void
    {
        $cacheKey = 'research.teachers_map';
        $teachersPath = public_path('data/teachers.json');

        $shouldRebuild = !Cache::has($cacheKey) || !file_exists($teachersPath);

        if (!$shouldRebuild) {
            return;
        }

        try {
            $teachers = DB::select("
                SELECT t.instru, t.f_name, t.l_name, t.m_maj, m.major, m.major_en
                FROM teacher t
                LEFT JOIN major m ON t.m_maj = m.major_id
            ");

            $map = [];
            foreach ($teachers as $t) {
                $instru = trim((string) ($t->instru ?? ''));
                if ($instru === '') {
                    continue;
                }
                $fname = trim((string) ($t->f_name ?? ''));
                $lname = trim((string) ($t->l_name ?? ''));
                $fullName = trim($fname . ' ' . $lname);
                if ($fullName === '') {
                    continue;
                }
                $map[$instru] = [
                    'name' => $fullName,
                    'major_id' => $t->m_maj !== null ? (string) $t->m_maj : null,
                    'major' => trim((string) ($t->major ?? '')) ?: null,
                    'major_en' => trim((string) ($t->major_en ?? '')) ?: null,
                ];
            }

            File::ensureDirectoryExists(public_path('data'));
            File::put($teachersPath, json_encode($map, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

            Cache::put($cacheKey, true, now()->addHour());
        } catch (\Throwable $e) {
            // ถ้าเชื่อมต่อฐานข้อมูลไม่ได้ (เช่น รันนอกเครือข่ายมหาวิทยาลัย)
            // ให้ใช้ไฟล์ teachers.json เดิมที่มีอยู่ต่อไป (ถ้ามี) และไม่ทำให้หน้าเว็บพัง
            Log::warning('ResearchController: ไม่สามารถดึงข้อมูลอาจารย์จากตาราง teacher/major ได้: ' . $e->getMessage());

            if (!file_exists($teachersPath)) {
                File::ensureDirectoryExists(public_path('data'));
                File::put($teachersPath, json_encode(new \stdClass()));
            }
        }
    }
}
