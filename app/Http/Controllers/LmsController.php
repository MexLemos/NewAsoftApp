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

    public function lesson($course_id, $lesson_id)
    {
        $course = \App\Models\Course::with('modules.lessons')->findOrFail($course_id);
        
        if ($lesson_id == 1 && !\App\Models\Lesson::find($lesson_id)) {
            $lesson = $course->modules->first()?->lessons->first();
        } else {
            $lesson = clone $course->modules->first()->lessons->first(); // fallback if lesson fails
            $actual = \App\Models\Lesson::find($lesson_id);
            if($actual) {
                $lesson = $actual;
            }
        }
        
        if(!$lesson) {
            return redirect()->route('lms.dashboard')->with('error', 'Nenhuma aula disponível neste curso ainda.');
        }
        
        $enrollment = \Illuminate\Support\Facades\Auth::user()->enrollments()->where('course_id', $course_id)->first();
        $completedLessons = $enrollment->completed_lessons ?? [];
        
        return view('lms.lesson', compact('course', 'lesson', 'enrollment', 'completedLessons'));
    }

    public function completeLesson(Request $request, $course_id, $lesson_id)
    {
        $enrollment = \Illuminate\Support\Facades\Auth::user()->enrollments()->where('course_id', $course_id)->first();
        if ($enrollment) {
            $completed = $enrollment->completed_lessons ?? [];
            if (!in_array((int)$lesson_id, $completed)) {
                $completed[] = (int) $lesson_id;
                $enrollment->completed_lessons = $completed;
                
                $course = \App\Models\Course::with('modules.lessons')->findOrFail($course_id);
                $totalLessons = $course->modules->sum(function($module) { return $module->lessons->count(); });
                
                if ($totalLessons > 0) {
                    $enrollment->progress_percent = min(100, (int)round((count($completed) / $totalLessons) * 100));
                }
                $enrollment->save();
                
                // Emite certificado se concluiu 100%
                if ($enrollment->progress_percent == 100) {
                    \App\Models\Certificate::firstOrCreate(
                        ['user_id' => $enrollment->user_id, 'course_id' => $course_id],
                        ['certificate_code' => strtoupper(\Illuminate\Support\Str::random(12))]
                    );
                }
                // Registo de submissão de projeto no CRM
                if ($request->has('github_link') || $request->has('comments')) {
                    $lesson = \App\Models\Lesson::find($lesson_id);
                    $user = \Illuminate\Support\Facades\Auth::user();
                    $msg = "SUBMISSÃO DE PROJECTO\nCurso: " . $course->title . "\nAula: " . $lesson->title . "\n\n";
                    if ($request->github_link) {
                        $msg .= "GitHub Link: " . $request->github_link . "\n\n";
                    }
                    if ($request->comments) {
                        $msg .= "Comentários do Aluno:\n" . $request->comments;
                    }
                    
                    \App\Models\Lead::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => 'N/A (LMS)',
                        'message' => $msg,
                        'status' => 'new'
                    ]);
                }
            }
        }
        return redirect()->back()->with('success', 'Aula concluída com sucesso!');
    }

    public function certificados()
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // Geração retroativa para cursos já a 100% que não tenham certificado
        $completedEnrollments = $user->enrollments()->where('progress_percent', 100)->get();
        foreach ($completedEnrollments as $enrollment) {
            \App\Models\Certificate::firstOrCreate(
                ['user_id' => $user->id, 'course_id' => $enrollment->course_id],
                ['certificate_code' => strtoupper(\Illuminate\Support\Str::random(12))]
            );
        }

        $certificados = \App\Models\Certificate::where('user_id', $user->id)->with('course')->latest()->get();
        return view('lms.certificados', compact('certificados'));
    }

    public function showCertificado($code)
    {
        $certificado = \App\Models\Certificate::where('certificate_code', $code)->with(['user', 'course.modules.lessons'])->firstOrFail();
        
        $totalHours = 0;
        foreach($certificado->course->modules as $mod) {
            $totalHours += $mod->lessons->sum('duration_minutes');
        }
        $totalHours = max(1, round($totalHours / 60)); // mínimo 1 hora

        return view('lms.certificado_view', compact('certificado', 'totalHours'));
    }
}
