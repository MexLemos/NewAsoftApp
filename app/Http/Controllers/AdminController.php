<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $metrics = [
            'cursos_vendidos' => \App\Models\Enrollment::where('status', 'active')->count(),
            'alunos_ativos' => \App\Models\User::count(),
            'produtos_catalogo' => \App\Models\Product::count(),
            'parceiros' => \App\Models\Partner::count(),
        ];
        
        // Orders (Leads with orders)
        $recentOrders = \App\Models\Lead::where('message', 'like', '%PEDIDO DE COMPRA%')->latest()->take(5)->get();
        // Just contact leads
        $recentLeads = \App\Models\Lead::where('message', 'not like', '%PEDIDO DE COMPRA%')->latest()->take(5)->get();

        return view('admin.dashboard', compact('metrics', 'recentOrders', 'recentLeads'));
    }

    public function produtos()
    {
        $defaultCategories = [
            'Computadores' => 'computadores',
            'Redes e Conectividade' => 'redes-e-conectividade',
            'Material de Escritório' => 'material-de-escritorio',
            'Outros' => 'outros'
        ];

        foreach ($defaultCategories as $name => $slug) {
            \App\Models\ProductCategory::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }

        $products = \App\Models\Product::with('category')->latest()->get();
        $categories = \App\Models\ProductCategory::all();
        return view('admin.produtos', compact('products', 'categories'));
    }

    public function servicos()
    {
        $services = \App\Models\Service::latest()->get();
        return view('admin.servicos', compact('services'));
    }

    public function usuarios()
    {
        $users = \App\Models\User::latest()->get();
        return view('admin.usuarios', compact('users'));
    }

    public function leads()
    {
        $leads = \App\Models\Lead::latest()->get();
        return view('admin.leads', compact('leads'));
    }

    public function approveLeadCourses($id)
    {
        $lead = \App\Models\Lead::findOrFail($id);
        
        $user = \App\Models\User::where('email', $lead->email)->first();
        if ($user) {
            \App\Models\Enrollment::where('user_id', $user->id)
                ->where('status', 'pending')
                ->update(['status' => 'active']);
        }
        
        $lead->update(['status' => 'qualified']);
        return redirect()->back()->with('success', 'Pagamento aprovado e cursos liberados com sucesso!');
    }

    public function configuracoes()
    {
        $partners = \App\Models\Partner::latest()->get();
        $settingsData = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('admin.configuracoes', compact('partners', 'settingsData'));
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'nullable|numeric',
            'description' => 'required|string',
        ]);

        $slug = \Illuminate\Support\Str::slug($request->name) . '-' . time();
        $price = $request->price ?? 0;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produtos', 'public');
        }

        if ($request->category === 'curso') {
            $cat = \App\Models\Category::firstOrCreate(['name' => 'Geral', 'slug' => 'geral']);
            \App\Models\Course::create([
                'title' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $price,
                'category_id' => $cat->id,
            ]);
        } elseif ($request->category === 'produto') {
            \App\Models\Product::create([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $price,
                'product_category_id' => $request->product_category_id,
                'image' => $imagePath,
                'is_featured' => $request->has('is_featured'),
            ]);
        } elseif ($request->category === 'servico') {
            \App\Models\Service::create([
                'title' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'icon' => $imagePath,
                'is_featured' => $request->has('is_featured'),
            ]);
        }

        return redirect()->back()->with('success', 'Item adicionado com sucesso!');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string'
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            $roleName = strtolower($request->role); // Normaliza para lowercase
            $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => $roleName]);
            $user->assignRole($role);
        }

        return redirect()->back()->with('success', 'Usuário criado com sucesso!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_active = $request->has('is_active');
        
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        
        $user->save();

        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            $roleName = strtolower($request->role);
            $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => $roleName]);
            $user->syncRoles([$role]);
        }

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    public function cursos()
    {
        $courses = \App\Models\Course::with('category')->latest()->get();
        
        $defaultCategories = [
            'Desenvolvimento' => 'desenvolvimento',
            'Redes' => 'redes',
            'Gestão e Administração' => 'gestao-e-administracao',
            'Geral' => 'geral'
        ];

        foreach ($defaultCategories as $name => $slug) {
            \App\Models\Category::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }

        $categories = \App\Models\Category::all();

        return view('admin.cursos', compact('courses', 'categories'));
    }

    public function storeCurso(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'level' => 'required|in:basic,intermediate,advanced',
            'thumbnail' => 'nullable|image',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($request->title) . '-' . time();
        $validated['is_published'] = $request->has('is_published');
        $validated['is_free'] = $request->has('is_free');

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        \App\Models\Course::create($validated);

        return back()->with('success', 'Item cadastrado com sucesso!');
    }

    public function updateCurso(Request $request, $id)
    {
        $course = \App\Models\Course::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'level' => 'required|in:basic,intermediate,advanced',
            'thumbnail' => 'nullable|image',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['is_free'] = $request->has('is_free');

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        $course->update($validated);

        return back()->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroyCurso($id)
    {
        $course = \App\Models\Course::findOrFail($id);
        $course->delete();
        return back()->with('success', 'Curso removido com sucesso!');
    }

    public function destroyProduct($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return back()->with('success', 'Produto removido com sucesso!');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'product_category_id' => 'required|exists:product_categories,id'
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->product_category_id = $request->product_category_id;
        $product->price = $request->price ? (float)$request->price : 0;
        $product->is_featured = $request->has('is_featured');
        
        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('produtos', 'public');
        }
        
        $product->save();
        return back()->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroyService($id)
    {
        $service = \App\Models\Service::findOrFail($id);
        $service->delete();
        return back()->with('success', 'Serviço removido com sucesso!');
    }

    public function updateService(Request $request, $id)
    {
        $service = \App\Models\Service::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $service->title = $request->name;
        $service->description = $request->description;
        $service->is_featured = $request->has('is_featured');
        
        if ($request->hasFile('image')) {
            $service->icon = $request->file('image')->store('produtos', 'public');
        }
        
        $service->save();
        return back()->with('success', 'Serviço atualizado com sucesso!');
    }

    public function updateConfiguracoes(Request $request)
    {
        $request->validate([
            'company_name' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'address' => 'nullable|string',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
        ]);

        $settings = [
            'company_name' => $request->company_name,
            'contact_email' => $request->contact_email,
            'address' => $request->address,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
        ];
        
        for ($i=1; $i<=3; $i++) {
            if ($request->has('banner_'.$i.'_title')) {
                $settings['banner_'.$i.'_title'] = $request->input('banner_'.$i.'_title');
            }
            if ($request->has('banner_'.$i.'_subtitle')) {
                $settings['banner_'.$i.'_subtitle'] = $request->input('banner_'.$i.'_subtitle');
            }
            if ($request->has('banner_'.$i.'_desc')) {
                $settings['banner_'.$i.'_desc'] = $request->input('banner_'.$i.'_desc');
            }
            if ($request->hasFile('banner_'.$i.'_img')) {
                $settings['banner_'.$i.'_img'] = $request->file('banner_'.$i.'_img')->store('banners', 'public');
            }
        }

        foreach ($settings as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Configurações atualizadas com sucesso!');
    }

    public function storePartner(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image',
            'website_url' => 'nullable|url',
        ]);

        \App\Models\Partner::create([
            'name' => $request->name,
            'logo_url' => $request->file('logo')->store('partners', 'public'),
            'website_url' => $request->website_url,
        ]);

        return redirect()->back()->with('success', 'Parceiro adicionado com sucesso!');
    }

    public function updatePartner(Request $request, $id)
    {
        $partner = \App\Models\Partner::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image',
            'website_url' => 'nullable|url',
        ]);

        $partner->name = $request->name;
        $partner->website_url = $request->website_url;

        if ($request->hasFile('logo')) {
            $partner->logo_url = $request->file('logo')->store('partners', 'public');
        }

        $partner->save();

        return redirect()->back()->with('success', 'Parceiro atualizado com sucesso!');
    }

    public function destroyPartner($id)
    {
        $partner = \App\Models\Partner::findOrFail($id);
        $partner->delete();
        return redirect()->back()->with('success', 'Parceiro removido com sucesso!');
    }

    public function cursosConteudos($id)
    {
        $course = \App\Models\Course::with(['modules.lessons' => function($q){ $q->orderBy('order_index'); }])->findOrFail($id);
        return view('admin.cursos_conteudos', compact('course'));
    }

    public function storeModule(Request $request, $id)
    {
        $request->validate(['title' => 'required|string|max:255', 'order_index' => 'nullable|integer']);
        $course = \App\Models\Course::findOrFail($id);
        $course->modules()->create([
            'title' => $request->title,
            'order_index' => $request->order_index ?? 0,
        ]);
        return redirect()->back()->with('success', 'Módulo adicionado com sucesso!');
    }

    public function updateModule(Request $request, $id)
    {
        $request->validate(['title' => 'required|string|max:255', 'order_index' => 'nullable|integer']);
        $module = \App\Models\Module::findOrFail($id);
        $module->update([
            'title' => $request->title,
            'order_index' => $request->order_index ?? 0,
        ]);
        return redirect()->back()->with('success', 'Módulo atualizado com sucesso!');
    }

    public function destroyModule($id)
    {
        $module = \App\Models\Module::findOrFail($id);
        $module->delete();
        return redirect()->back()->with('success', 'Módulo eliminado com sucesso!');
    }

    public function storeLesson(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255', 
            'type' => 'nullable|string|in:video,quiz,project',
            'description' => 'nullable|string', 
            'video_url' => 'nullable|string', 
            'attachment_url' => 'nullable|string', 
            'order_index' => 'nullable|integer',
            'duration_minutes' => 'nullable|integer'
        ]);
        $module = \App\Models\Module::findOrFail($id);
        
        $contentData = null;
        if ($request->type === 'project') {
            $contentData = [
                'require_github' => $request->has('require_github'),
                'linkedin_mention' => $request->has('linkedin_mention')
            ];
        } elseif ($request->type === 'quiz') {
            $contentData = [
                'quiz' => $request->quiz // Array com as perguntas e respostas
            ];
        }

        $module->lessons()->create([
            'title' => $request->title,
            'type' => $request->type ?? 'video',
            'description' => $request->description,
            'video_url' => $request->video_url,
            'attachment_url' => $request->attachment_url,
            'order_index' => $request->order_index ?? 0,
            'duration_minutes' => $request->duration_minutes ?? 0,
            'content_data' => $contentData
        ]);
        return redirect()->back()->with('success', 'Item adicionado com sucesso!');
    }

    public function updateLesson(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255', 
            'description' => 'nullable|string', 
            'video_url' => 'nullable|string', 
            'attachment_url' => 'nullable|string', 
            'order_index' => 'nullable|integer',
            'duration_minutes' => 'nullable|integer'
        ]);
        $lesson = \App\Models\Lesson::findOrFail($id);

        $contentData = $lesson->content_data;
        if ($lesson->type === 'project') {
            $contentData = [
                'require_github' => $request->has('require_github'),
                'linkedin_mention' => $request->has('linkedin_mention')
            ];
        } elseif ($lesson->type === 'quiz') {
            $contentData = [
                'quiz' => $request->quiz // Array com as perguntas e respostas
            ];
        }

        $lesson->update([
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $request->video_url,
            'attachment_url' => $request->attachment_url,
            'order_index' => $request->order_index ?? 0,
            'duration_minutes' => $request->duration_minutes ?? 0,
            'content_data' => $contentData
        ]);
        return redirect()->back()->with('success', 'Item atualizado com sucesso!');
    }

    public function destroyLesson($id)
    {
        $lesson = \App\Models\Lesson::findOrFail($id);
        $lesson->delete();
        return redirect()->back()->with('success', 'Aula eliminada com sucesso!');
    }
}
