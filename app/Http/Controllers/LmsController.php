<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LmsController extends Controller
{
    public function dashboard()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $enrolledCourses = $user->courses()->wherePivot('status', 'active')->withPivot('progress_percent')->get();
        return view('lms.dashboard', compact('enrolledCourses'));
    }

    public function historico()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $purchases = \App\Models\Lead::where('email', $user->email)->latest()->get();
        return view('lms.historico', compact('purchases'));
    }

    public function enroll(Request $request, $course_id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        if (!$user->enrollments()->where('course_id', $course_id)->exists()) {
            $course = \App\Models\Course::findOrFail($course_id);
            
            \App\Models\Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $course_id,
                'progress_percent' => 0,
                'status' => $course->is_free ? 'active' : 'pending',
            ]);
        }

        return redirect()->route('lms.dashboard')->with('success', 'Curso adicionado! Clique abaixo para abrir e explorar os conteúdos.');
    }

    public function lesson($course, $lesson)
    {
        // Mocking the lesson logic for now
        return view('lms.lesson');
    }
}
