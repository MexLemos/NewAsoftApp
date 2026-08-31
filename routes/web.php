<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LmsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\HrController;
use App\Http\Controllers\Admin\CrmController;
use App\Http\Controllers\Admin\TurmaController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\AuditController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes & Subdomain Routing (ASoftMedia Ecosystem)
|--------------------------------------------------------------------------
|
| - Site Principal:  asoftmedia.test / asoftmedia.com
| - Loja Online:     loja.asoftmedia.test / loja.asoftmedia.com
| - Treinamento LMS: treinamento.asoftmedia.test / treinamento.asoftmedia.com
|
*/

$baseDomain = config('app.domain') ?: env('APP_DOMAIN', 'softmedia-ao.com');

// =========================================================================
// SUBDOMÍNIO: LOJA / SHOP / STORE (shop.softmedia-ao.com / loja.softmedia-ao.com)
// =========================================================================
foreach (['shop', 'store', 'loja'] as $sub) {
    Route::domain("{$sub}.{$baseDomain}")->group(function () use ($sub) {
        Route::get('/', [PageController::class, 'produtos'])->name("{$sub}.home");
        Route::get('/produtos', [PageController::class, 'produtos'])->name("{$sub}.produtos");
        Route::get('/carrinho', [CartController::class, 'index'])->name("{$sub}.carrinho.index");
        Route::post('/carrinho/add', [CartController::class, 'add'])->name("{$sub}.carrinho.add");
        Route::post('/carrinho/remove', [CartController::class, 'remove'])->name("{$sub}.carrinho.remove");
        Route::post('/carrinho/update', [CartController::class, 'update'])->name("{$sub}.carrinho.update");
        Route::get('/checkout', [CartController::class, 'checkout'])->name("{$sub}.checkout");
        Route::post('/checkout/process', [CartController::class, 'process'])->name("{$sub}.checkout.process");
    });
}

// =========================================================================
// SUBDOMÍNIO: TREINAMENTO LMS (treinamento.softmedia-ao.com)
// =========================================================================
Route::domain("treinamento.{$baseDomain}")->group(function () {
    Route::get('/', function () {
        if (auth()->check()) {
            return redirect()->route('lms.dashboard');
        }
        return redirect()->route('treinamento.cursos');
    })->name('treinamento.home');

    Route::get('/catalogo', [PageController::class, 'cursos'])->name('treinamento.cursos');
    Route::get('/treinamento', [PageController::class, 'cursos']);
    Route::get('/cursos', [PageController::class, 'cursos']);

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', [LmsController::class, 'dashboard'])->name('treinamento.dashboard');
        Route::get('/certificados', [LmsController::class, 'certificados'])->name('treinamento.certificados');
        Route::get('/certificados/{code}', [LmsController::class, 'showCertificado'])->name('treinamento.certificados.show');
        Route::get('/historico', [LmsController::class, 'historico'])->name('treinamento.historico');
        Route::get('/curso/{course}/aula/{lesson}', [LmsController::class, 'lesson'])->name('treinamento.lesson');
        Route::post('/curso/{course}/aula/{lesson}/concluir', [LmsController::class, 'completeLesson'])->name('treinamento.lesson.complete');
        Route::post('/curso/{course}/comprar', [LmsController::class, 'enroll'])->name('treinamento.enroll');
    });
});

// =========================================================================
// SUBDOMÍNIO: SYSADMIN (sysadmin.softmedia-ao.com)
// =========================================================================
Route::domain("sysadmin.{$baseDomain}")->group(function () {
    Route::get('/', function () {
        if (auth()->check()) {
            if (auth()->user()->hasAnyRole(['admin', 'tech', 'formador', 'instrutor'])) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('lms.dashboard');
        }
        return redirect()->route('login');
    })->name('sysadmin.home');
});

// =========================================================================
// SITE PRINCIPAL / ROTAS GLOBAIS (asoftmedia.test, softmedia-ao.com e fallback)
// =========================================================================

// Landing Page Principal
Route::get('/', [PageController::class, 'home'])->name('home');

// Páginas Públicas Globais
Route::get('/treinamento', [PageController::class, 'cursos'])->name('cursos');
Route::get('/cursos', [PageController::class, 'cursos']);
Route::get('/produtos', [PageController::class, 'produtos'])->name('produtos');

// Carrinho & Checkout Globais
Route::get('/carrinho', [CartController::class, 'index'])->name('carrinho.index');
Route::post('/carrinho/add', [CartController::class, 'add'])->name('carrinho.add');
Route::post('/carrinho/remove', [CartController::class, 'remove'])->name('carrinho.remove');
Route::post('/carrinho/update', [CartController::class, 'update'])->name('carrinho.update');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [CartController::class, 'process'])->name('checkout.process');

// Dashboard Central com Redirecionamento Inteligente por Papel
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->hasAnyRole(['admin', 'tech'])) {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('lms.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil de Utilizador
Route::middleware('auth')->group(function () {
    Route::get('/lms/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/lms/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/lms/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Área Administrativa & LMS
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Gestão de Conteúdos & Cursos (Admin, Tech, Instrutor)
    Route::middleware(['role:admin|tech|instrutor'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        Route::get('/admin/cursos', [AdminController::class, 'cursos'])->name('admin.cursos');
        Route::post('/admin/cursos', [AdminController::class, 'storeCurso'])->name('admin.cursos.store');
        Route::put('/admin/cursos/{id}', [AdminController::class, 'updateCurso'])->name('admin.cursos.update');
        Route::delete('/admin/cursos/{id}', [AdminController::class, 'destroyCurso'])->name('admin.cursos.destroy');
        
        Route::get('/admin/cursos/{id}/conteudos', [AdminController::class, 'cursosConteudos'])->name('admin.cursos.conteudos');
        Route::post('/admin/cursos/{id}/modules', [AdminController::class, 'storeModule'])->name('admin.modules.store');
        Route::put('/admin/modules/{id}', [AdminController::class, 'updateModule'])->name('admin.modules.update');
        Route::delete('/admin/modules/{id}', [AdminController::class, 'destroyModule'])->name('admin.modules.destroy');
        
        Route::post('/admin/modules/{id}/lessons', [AdminController::class, 'storeLesson'])->name('admin.lessons.store');
        Route::put('/admin/lessons/{id}', [AdminController::class, 'updateLesson'])->name('admin.lessons.update');
        Route::delete('/admin/lessons/{id}', [AdminController::class, 'destroyLesson'])->name('admin.lessons.destroy');
    });

    // Produtos, Serviços e Leads (Admin, Tech)
    Route::middleware(['role:admin|tech'])->group(function () {
        Route::get('/admin/produtos', [AdminController::class, 'produtos'])->name('admin.produtos');
        Route::post('/admin/produtos', [AdminController::class, 'storeItem'])->name('admin.produtos.store');
        Route::delete('/admin/produtos/{id}', [AdminController::class, 'destroyProduct'])->name('admin.produtos.destroy');
        Route::put('/admin/produtos/{id}', [AdminController::class, 'updateProduct'])->name('admin.produtos.update');
        Route::post('/admin/produtos/store', [AdminController::class, 'storeItem'])->name('admin.store.item');
        
        Route::get('/admin/servicos', [AdminController::class, 'servicos'])->name('admin.servicos');
        Route::delete('/admin/servicos/{id}', [AdminController::class, 'destroyService'])->name('admin.servicos.destroy');
        Route::put('/admin/servicos/{id}', [AdminController::class, 'updateService'])->name('admin.servicos.update');
        
        Route::get('/admin/leads', [AdminController::class, 'leads'])->name('admin.leads');
        Route::post('/admin/leads/{id}/approve-courses', [AdminController::class, 'approveLeadCourses'])->name('admin.leads.approve_courses');
    });

    // Recursos Humanos / Marcação de Ponto (Todos os funcionários)
    Route::middleware(['role:admin|tech|formador|instrutor'])->group(function () {
        Route::get('/admin/ponto', [HrController::class, 'ponto'])->name('admin.ponto');
        Route::post('/admin/ponto/registrar', [HrController::class, 'registrarPonto'])->name('admin.ponto.registrar');
    });

    // Gestão Administrativa & Financeira (Apenas Admin)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
        Route::post('/admin/usuarios', [AdminController::class, 'storeUser'])->name('admin.usuarios.store');
        Route::post('/admin/usuarios/store', [AdminController::class, 'storeUser'])->name('admin.store.user');
        Route::post('/admin/usuarios/{id}/update', [AdminController::class, 'updateUser'])->name('admin.usuarios.update');
        Route::get('/admin/usuarios/{id}/certificado', [AdminController::class, 'emitirCertificadoManual'])->name('admin.certificados.emitir');

        Route::get('/admin/funcionarios', [AdminController::class, 'funcionarios'])->name('admin.funcionarios');
        
        // CRM / Financeiro
        Route::get('/admin/pagamentos', [CrmController::class, 'pagamentos'])->name('admin.pagamentos');
        Route::post('/admin/pagamentos', [CrmController::class, 'registrarPagamento'])->name('admin.pagamentos.store');
        
        Route::get('/admin/propinas', [CrmController::class, 'propinas'])->name('admin.propinas');
        Route::post('/admin/propinas/gerar', [CrmController::class, 'gerarPropinas'])->name('admin.propinas.gerar');
        
        // Turmas
        Route::get('/admin/turmas', [TurmaController::class, 'index'])->name('admin.turmas');
        Route::post('/admin/turmas', [TurmaController::class, 'store'])->name('admin.turmas.store');
        Route::get('/admin/turmas/{id}', [TurmaController::class, 'show'])->name('admin.turmas.show');
        Route::post('/admin/turmas/{id}/alunos', [TurmaController::class, 'addStudent'])->name('admin.turmas.add_student');
        Route::delete('/admin/turmas/{id}/alunos/{user_id}', [TurmaController::class, 'removeStudent'])->name('admin.turmas.remove_student');
        
        Route::get('/admin/caixa', [CrmController::class, 'caixa'])->name('admin.caixa');
        Route::post('/admin/caixa', [CrmController::class, 'registrarMovimentoCaixa'])->name('admin.caixa.store');
        
        Route::get('/admin/relatorios', [CrmController::class, 'relatorios'])->name('admin.relatorios');
        
        Route::get('/admin/configuracoes', [AdminController::class, 'configuracoes'])->name('admin.configuracoes');
        Route::post('/admin/configuracoes', [AdminController::class, 'updateConfiguracoes'])->name('admin.configuracoes.update');
        
        Route::post('/admin/parceiros/store', [AdminController::class, 'storePartner'])->name('admin.parceiros.store');
        Route::put('/admin/parceiros/{id}', [AdminController::class, 'updatePartner'])->name('admin.parceiros.update');
        Route::delete('/admin/parceiros/{id}', [AdminController::class, 'destroyPartner'])->name('admin.parceiros.destroy');
    });

    // Exportação PDF & Excel (Admin e Tech)
    Route::middleware(['role:admin|tech'])->group(function () {
        Route::get('/admin/export/{list}/pdf',   [ExportController::class, 'exportPdf'])->name('admin.export.pdf');
        Route::get('/admin/export/{list}/excel', [ExportController::class, 'exportExcel'])->name('admin.export.excel');
    });

    // Auditoria e Segurança (Apenas Admin)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/auditoria',           [AuditController::class, 'index'])->name('admin.auditoria');
        Route::get('/admin/auditoria/seguranca', [AuditController::class, 'seguranca'])->name('admin.auditoria.seguranca');
    });
    
    // Rotas LMS
    Route::get('/lms/dashboard', [LmsController::class, 'dashboard'])->name('lms.dashboard');
    Route::get('/lms/certificados', [LmsController::class, 'certificados'])->name('lms.certificados');
    Route::get('/lms/certificados/{code}', [LmsController::class, 'showCertificado'])->name('lms.certificados.show');
    Route::get('/lms/historico', [LmsController::class, 'historico'])->name('lms.historico');
    Route::get('/lms/curso/{course}/aula/{lesson}', [LmsController::class, 'lesson'])->name('lms.lesson');
    Route::post('/lms/curso/{course}/aula/{lesson}/concluir', [LmsController::class, 'completeLesson'])->name('lms.lesson.complete');
    Route::post('/lms/curso/{course}/comprar', [LmsController::class, 'enroll'])->name('lms.enroll');
});

require __DIR__.'/auth.php';
