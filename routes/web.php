<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\PageController::class, 'home'])->name('home');
Route::get('/treinamento', [\App\Http\Controllers\PageController::class, 'cursos'])->name('cursos');
Route::get('/produtos', [\App\Http\Controllers\PageController::class, 'produtos'])->name('produtos');

Route::get('/carrinho', [\App\Http\Controllers\CartController::class, 'index'])->name('carrinho.index');
Route::post('/carrinho/add', [\App\Http\Controllers\CartController::class, 'add'])->name('carrinho.add');
Route::post('/carrinho/remove', [\App\Http\Controllers\CartController::class, 'remove'])->name('carrinho.remove');
Route::post('/carrinho/update', [\App\Http\Controllers\CartController::class, 'update'])->name('carrinho.update');
Route::get('/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [\App\Http\Controllers\CartController::class, 'process'])->name('checkout.process');

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->hasAnyRole(['instrutor', 'formador', 'aluno'])) {
        return redirect()->route('lms.dashboard');
    }
    
    // Fallback padrão
    return redirect()->route('lms.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/produtos', [\App\Http\Controllers\AdminController::class, 'produtos'])->name('admin.produtos');
    Route::post('/admin/produtos', [\App\Http\Controllers\AdminController::class, 'storeItem'])->name('admin.produtos.store');
    Route::delete('/admin/produtos/{id}', [\App\Http\Controllers\AdminController::class, 'destroyProduct'])->name('admin.produtos.destroy');
    Route::put('/admin/produtos/{id}', [\App\Http\Controllers\AdminController::class, 'updateProduct'])->name('admin.produtos.update');
    
    Route::get('/admin/servicos', [\App\Http\Controllers\AdminController::class, 'servicos'])->name('admin.servicos');
    Route::delete('/admin/servicos/{id}', [\App\Http\Controllers\AdminController::class, 'destroyService'])->name('admin.servicos.destroy');
    Route::put('/admin/servicos/{id}', [\App\Http\Controllers\AdminController::class, 'updateService'])->name('admin.servicos.update');

    
    Route::get('/admin/cursos', [\App\Http\Controllers\AdminController::class, 'cursos'])->name('admin.cursos');
    Route::post('/admin/cursos', [\App\Http\Controllers\AdminController::class, 'storeCurso'])->name('admin.cursos.store');

    Route::get('/admin/usuarios', [\App\Http\Controllers\AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::post('/admin/usuarios', [\App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.usuarios.store');
    Route::get('/admin/leads', [\App\Http\Controllers\AdminController::class, 'leads'])->name('admin.leads');
    Route::get('/admin/configuracoes', [\App\Http\Controllers\AdminController::class, 'configuracoes'])->name('admin.configuracoes');
    Route::post('/admin/configuracoes', [\App\Http\Controllers\AdminController::class, 'updateConfiguracoes'])->name('admin.configuracoes.update');
    Route::post('/admin/produtos/store', [\App\Http\Controllers\AdminController::class, 'storeItem'])->name('admin.store.item');
    Route::post('/admin/usuarios/store', [\App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.store.user');
    Route::post('/admin/usuarios/{id}/update', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.usuarios.update');
    Route::post('/admin/configuracoes/update', [\App\Http\Controllers\AdminController::class, 'updateConfiguracoes'])->name('admin.configuracoes.update');
    Route::post('/admin/leads/{id}/approve-courses', [\App\Http\Controllers\AdminController::class, 'approveLeadCourses'])->name('admin.leads.approve_courses');
    
    // LMS Routes
    Route::get('/lms/dashboard', [\App\Http\Controllers\LmsController::class, 'dashboard'])->name('lms.dashboard');
    Route::get('/lms/curso/{course}/aula/{lesson}', [\App\Http\Controllers\LmsController::class, 'lesson'])->name('lms.lesson');
    Route::post('/lms/curso/{course}/comprar', [\App\Http\Controllers\LmsController::class, 'enroll'])->name('lms.enroll');
});

require __DIR__.'/auth.php';
