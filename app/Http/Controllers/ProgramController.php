<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = config('programs');

        // Build filter options from program data - keep original Thai values for data matching
        $optDegrees = [];
        $optDepartments = [];
        $optTitles = [];
        $optDays = [];

        foreach ($programs as $prog) {
            // Always use Thai version for data matching/filtering consistency
            $degree = $prog['degree'] ?? null;
            if ($degree && !in_array($degree, $optDegrees)) {
                $optDegrees[] = $degree;
            }

            $major = $prog['major'] ?? null;
            if ($major && !in_array($major, $optDepartments)) {
                $optDepartments[] = $major;
            }

            $title = $prog['title'] ?? null;
            if ($title && !in_array($title, $optTitles)) {
                $optTitles[] = $title;
            }

            foreach ($prog['plans'] ?? [] as $plan) {
                $dayStudy = $plan['date_study'] ?? null;
                if ($dayStudy && !in_array($dayStudy, $optDays)) {
                    $optDays[] = $dayStudy;
                }
            }
        }

        sort($optDegrees);
        sort($optDepartments);
        sort($optTitles);
        sort($optDays);

        return view('programs.index', [
            'programs' => $programs,
            'optDegrees' => $optDegrees,
            'optDepartments' => $optDepartments,
            'optTitles' => $optTitles,
            'optDays' => $optDays,
        ]);
    }

    public function show($code)
    {
        $programs = config('programs');
        $program = $programs[$code] ?? null;

        if (!$program) {
            return view('programs.not-found');
        }

        return view('programs.show', compact('program', 'code'));
    }
}
