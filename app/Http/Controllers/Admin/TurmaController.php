<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Turma;
use App\Models\Course;
use App\Models\User;

class TurmaController extends Controller
{
    public function index()
    {
        $turmas = Turma::with('course')->withCount('users')->latest()->get();
        $courses = Course::latest()->get();
        $trainers = User::role('formador')->get();
        return view('admin.turmas.index', compact('turmas', 'courses', 'trainers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'monthly_fee' => 'required|numeric|min:0',
        ]);

        Turma::create([
            'course_id' => $request->course_id,
            'name' => $request->name,
            'monthly_fee' => $request->monthly_fee,
            'is_active' => true,
        ]);

        return back()->with('success', 'Turma criada com sucesso!');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'monthly_fee' => 'required|numeric|min:0',
            'trainer_id' => 'nullable|exists:users,id',
            'is_active' => 'sometimes|in:on',
        ]);

        $turma = Turma::findOrFail($id);
        $turma->update([
            'course_id' => $request->course_id,
            'name' => $request->name,
            'monthly_fee' => $request->monthly_fee,
            'trainer_id' => $request->trainer_id,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Turma actualizada com sucesso.');
    }

    public function show($id)
    {
        $turma = Turma::with(['course', 'users'])->findOrFail($id);
        
        $enrolledUserIds = $turma->users->pluck('id')->toArray();
        $availableUsers = User::whereHas('roles', function($q){
            $q->whereIn('name', ['aluno', 'cliente', 'empresa']);
        })->orWhereDoesntHave('roles')->whereNotIn('id', $enrolledUserIds)->get();

        return view('admin.turmas.show', compact('turma', 'availableUsers'));
    }

    public function addStudent(Request $request, $id)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        $turma = Turma::findOrFail($id);
        
        if (!$turma->users()->where('user_id', $request->user_id)->exists()) {
            $turma->users()->attach($request->user_id);
            return back()->with('success', 'Aluno adicionado à turma!');
        }
        
        return back()->with('error', 'O aluno já está nesta turma.');
    }

    public function removeStudent($id, $user_id)
    {
        $turma = Turma::findOrFail($id);
        $turma->users()->detach($user_id);
        return back()->with('success', 'Aluno removido da turma!');
    }
}
