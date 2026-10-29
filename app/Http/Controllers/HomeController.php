<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $programs = config('programs');

        // Extract unique departments with sample program code, logo, and cover image
        $majorCovers = [
            'construction_engineering_meng' => 'images/programs/prog-civil.jpg',
            'civil_engineering_meng' => 'images/programs/prog-civil.jpg',
            'civil_engineering_phd' => 'images/programs/prog-civil.jpg',
            'data_science_meng' => 'images/programs/prog-datascience.jpg',
            'data_science_phd' => 'images/programs/prog-datascience.jpg',
            'geo_resource_engineering_meng' => 'images/programs/prog-mining.jpg',
            'electrical_engineering_meng' => 'images/programs/prog-electrical.jpg',
            'electrical_engineering_phd' => 'images/programs/prog-electrical.jpg',
            'industial_engineering_master' => 'images/programs/prog-industrial.jpg',
            'industial_engineering_phd' => 'images/programs/prog-industrial.jpg',
            'logging_engineering_meng' => 'images/programs/prog-industrial.jpg',
            'industial_management_master' => 'images/programs/prog-industrial.jpg',
            'me_master' => 'images/programs/prog-mechanical.jpg',
            'me_phd' => 'images/programs/prog-mechanical.jpg',
            'advanced_computational_engineering_master' => 'images/programs/prog-mechanical.jpg',
            'energy_master' => 'images/programs/prog-energy.jpg',
            'energy_phd' => 'images/programs/prog-energy.jpg',
            'agricultural_engineering_meng' => 'images/programs/prog-energy.jpg',
            'computer_engineering_meng' => 'images/programs/prog-computer.jpg',
            'plasma_microelectromechanical_systems_engineering_meng' => 'images/programs/prog-plasma.jpg',
            'plasma_microelectromechanical_systems_engineering_phd' => 'images/programs/prog-plasma.jpg',
            'env_ms' => 'images/programs/prog-environmental.jpg',
            'env_phd' => 'images/programs/prog-environmental.jpg',
        ];

        $departments = [];
        $departmentCards = [];
        foreach ($programs as $code => $prog) {
            $major = $prog['major'] ?? null;
            $major_en = $prog['major_en'] ?? null;

            if ($major && !isset($departments[$major])) {
                $departments[$major] = $major_en;
                $departmentCards[] = [
                    'code' => $code,
                    'major' => $major,
                    'major_en' => $major_en ?: $major,
                    'logo' => $prog['img'] ?? null,
                    'cover' => $majorCovers[$code] ?? 'images/banner-programs.png',
                    'count' => 1,
                ];
            } elseif ($major) {
                foreach ($departmentCards as &$card) {
                    if ($card['major'] === $major) {
                        $card['count']++;
                        break;
                    }
                }
                unset($card);
            }
        }

        // Load research categories summary from public/data/categories.json
        $categoriesPath = public_path('data/categories.json');
        $categories = [];
        $totalTheses = 2044;
        if (file_exists($categoriesPath)) {
            $categories = json_decode(file_get_contents($categoriesPath), true) ?? [];
        }
        $thesesPath = public_path('data/theses.json');
        if (file_exists($thesesPath)) {
            $thesesData = json_decode(file_get_contents($thesesPath), true);
            if (is_array($thesesData)) {
                $totalTheses = count($thesesData);
            }
        }

        // Mock news data for homepage announcements/updates
        $news = [
            [
                'category' => 'ประกาศ',
                'category_en' => 'Announcement',
                'title' => 'เปิดรับสมัครนักศึกษาระดับบัณฑิตศึกษา ประจำภาคการศึกษาที่ 1/2569',
                'title_en' => 'Now Accepting Graduate Applications for Semester 1/2026',
                'excerpt' => 'คณะวิศวกรรมศาสตร์เปิดรับสมัครผู้สนใจเข้าศึกษาต่อระดับปริญญาโทและปริญญาเอกในโปรแกรมต่าง ๆ หลากหลายสาขา',
                'excerpt_en' => 'The Faculty of Engineering is now accepting applicants for Master\'s and Doctoral programs in various engineering disciplines.',
                'date' => '28 ส.ค. 2569',
                'date_en' => 'Aug 28, 2026',
                'icon' => 'bi-megaphone-fill',
            ],
            [
                'category' => 'ทุนการศึกษา',
                'category_en' => 'Scholarship',
                'title' => 'ทุนการศึกษาและทุนวิจัยสำหรับนักศึกษาบัณฑิตศึกษา',
                'title_en' => 'Graduate Scholarships and Research Funding',
                'excerpt' => 'มีทุน TA/RA, ทุนคณะ และทุนอื่น ๆ พร้อมให้สำหรับนักศึกษาที่มีคุณสมบัติตรงตามเงื่อนไข',
                'excerpt_en' => 'Various scholarships available including TA/RA positions, faculty grants, and other funding opportunities for qualified students.',
                'date' => '15 ส.ค. 2569',
                'date_en' => 'Aug 15, 2026',
                'icon' => 'bi-award-fill',
            ],
            [
                'category' => 'กิจกรรม',
                'category_en' => 'Event',
                'title' => 'สัมมนาวิชาการและนำเสนองานวิจัย ประจำประจำภาคการศึกษาที่ 1',
                'title_en' => 'Academic Seminar and Research Presentation - Semester 1',
                'excerpt' => 'เชิญชวนนักศึกษาและอาจารย์เข้าร่วมสัมมนาวิชาการและการนำเสนอผลงานวิจัยที่ยอดเยี่ยม',
                'excerpt_en' => 'Join us for an academic seminar and presentation of outstanding research works by our faculty and students.',
                'date' => '5 ก.ย. 2569',
                'date_en' => 'Sep 5, 2026',
                'icon' => 'bi-calendar-event-fill',
            ],
            [
                'category' => 'ข่าวสาร',
                'category_en' => 'Update',
                'title' => 'ปฏิทินการศึกษา ประจำปีการศึกษา 2569',
                'title_en' => 'Academic Calendar for 2026',
                'excerpt' => 'ปฏิทินการศึกษา วันเรียน วันสอบ และวันหยุดพักการศึกษาสำหรับปีการศึกษา 2569',
                'excerpt_en' => 'Important dates for the 2026 academic year including class schedules, exams, and holidays.',
                'date' => '1 ส.ค. 2569',
                'date_en' => 'Aug 1, 2026',
                'icon' => 'bi-calendar2-week-fill',
            ],
        ];

        return view('home.index', [
            'programs' => $programs,
            'departments' => $departments,
            'departmentCards' => $departmentCards,
            'categories' => $categories,
            'totalTheses' => $totalTheses,
            'news' => $news,
        ]);
    }
}
