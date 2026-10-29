<?php

namespace App\Http\Controllers;

class ScholarshipController extends Controller
{
    /**
     * หน้าทุนการศึกษา
     * เนื้อหาทั้งหมด (TH/EN) เขียนไว้ตรงใน resources/views/scholarships/index.blade.php
     */
    public function index()
    {
        return view('scholarships.index');
    }
}
