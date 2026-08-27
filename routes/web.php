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
    
    if ($user->hasAnyRole(['admin', 'tech'])) {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('lms.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/lms/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/lms/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/lms/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // General Admin & Tech Routes
    Route::middleware(['role:admin|tech|instrutor'])->group(function () {
        Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        Route::get('/admin/cursos', [\App\Http\Controllers\AdminController::class, 'cursos'])->name('admin.cursos');
        Route::post('/admin/cursos', [\App\Http\Controllers\AdminController::class, 'storeCurso'])->name('admin.cursos.store');
        Route::put('/admin/cursos/{id}', [\App\Http\Controllers\AdminController::class, 'updateCurso'])->name('admin.cursos.update');
        Route::delete('/admin/cursos/{id}', [\App\Http\Controllers\AdminController::class, 'destroyCurso'])->name('admin.cursos.destroy');
        
        Route::get('/admin/cursos/{id}/conteudos', [\App\Http\Controllers\AdminController::class, 'cursosConteudos'])->name('admin.cursos.conteudos');
        Route::post('/admin/cursos/{id}/modules', [\App\Http\Controllers\AdminController::class, 'storeModule'])->name('admin.modules.store');
        Route::put('/admin/modules/{id}', [\App\Http\Controllers\AdminController::class, 'updateModule'])->name('admin.modules.update');
        Route::delete('/admin/modules/{id}', [\App\Http\Controllers\AdminController::class, 'destroyModule'])->name('admin.modules.destroy');
        
        Route::post('/admin/modules/{id}/lessons', [\App\Http\Controllers\AdminController::class, 'storeLesson'])->name('admin.lessons.store');
        Route::put('/admin/lessons/{id}', [\App\Http\Controllers\AdminController::class, 'updateLesson'])->name('admin.lessons.update');
        Route::delete('/admin/lessons/{id}', [\App\Http\Controllers\AdminController::class, 'destroyLesson'])->name('admin.lessons.destroy');
    });

    Route::middleware(['role:admin|tech'])->group(function () {
        Route::get('/admin/produtos', [\App\Http\Controllers\AdminController::class, 'produtos'])->name('admin.produtos');
        Route::post('/admin/produtos', [\App\Http\Controllers\AdminController::class, 'storeItem'])->name('admin.produtos.store');
        Route::delete('/admin/produtos/{id}', [\App\Http\Controllers\AdminController::class, 'destroyProduct'])->name('admin.produtos.destroy');
        Route::put('/admin/produtos/{id}', [\App\Http\Controllers\AdminController::class, 'updateProduct'])->name('admin.produtos.update');
        Route::post('/admin/produtos/store', [\App\Http\Controllers\AdminController::class, 'storeItem'])->name('admin.store.item');
        
        Route::get('/admin/servicos', [\App\Http\Controllers\AdminController::class, 'servicos'])->name('admin.servicos');
        Route::delete('/admin/servicos/{id}', [\App\Http\Controllers\AdminController::class, 'destroyService'])->name('admin.servicos.destroy');
        Route::put('/admin/servicos/{id}', [\App\Http\Controllers\AdminController::class, 'updateService'])->name('admin.servicos.update');
        
        Route::get('/admin/leads', [\App\Http\Controllers\AdminController::class, 'leads'])->name('admin.leads');
        Route::post('/admin/leads/{id}/approve-courses', [\App\Http\Controllers\AdminController::class, 'approveLeadCourses'])->name('admin.leads.approve_courses');
    });

    // Admin Only Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/usuarios', [\App\Http\Controllers\AdminController::class, 'usuarios'])->name('admin.usuarios');
        Route::post('/admin/usuarios', [\App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.usuarios.store');
        Route::post('/admin/usuarios/store', [\App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.store.user');
        Route::post('/admin/usuarios/{id}/update', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.usuarios.update');
        
        Route::get('/admin/configuracoes', [\App\Http\Controllers\AdminController::class, 'configuracoes'])->name('admin.configuracoes');
        Route::post('/admin/configuracoes', [\App\Http\Controllers\AdminController::class, 'updateConfiguracoes'])->name('admin.configuracoes.update');
        Route::post('/admin/configuracoes/update', [\App\Http\Controllers\AdminController::class, 'updateConfiguracoes'])->name('admin.configuracoes.update');
        
        Route::post('/admin/parceiros/store', [\App\Http\Controllers\AdminController::class, 'storePartner'])->name('admin.parceiros.store');
        Route::put('/admin/parceiros/{id}', [\App\Http\Controllers\AdminController::class, 'updatePartner'])->name('admin.parceiros.update');
        Route::delete('/admin/parceiros/{id}', [\App\Http\Controllers\AdminController::class, 'destroyPartner'])->name('admin.parceiros.destroy');
    });
    
    // LMS Routes
    Route::get('/lms/dashboard', [\App\Http\Controllers\LmsController::class, 'dashboard'])->name('lms.dashboard');
    Route::get('/lms/certificados', [\App\Http\Controllers\LmsController::class, 'certificados'])->name('lms.certificados');
    Route::get('/lms/certificados/{code}', [\App\Http\Controllers\LmsController::class, 'showCertificado'])->name('lms.certificados.show');
    Route::get('/lms/historico', [\App\Http\Controllers\LmsController::class, 'historico'])->name('lms.historico');
    Route::get('/lms/curso/{course}/aula/{lesson}', [\App\Http\Controllers\LmsController::class, 'lesson'])->name('lms.lesson');
    Route::post('/lms/curso/{course}/aula/{lesson}/concluir', [\App\Http\Controllers\LmsController::class, 'completeLesson'])->name('lms.lesson.complete');
    Route::post('/lms/curso/{course}/comprar', [\App\Http\Controllers\LmsController::class, 'enroll'])->name('lms.enroll');
});

require __DIR__.'/auth.php';
