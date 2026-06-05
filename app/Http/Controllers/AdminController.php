<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function produtos()
    {
        $products = \App\Models\Product::latest()->get();
        return view('admin.produtos', compact('products'));
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
        return view('admin.configuracoes', compact('partners'));
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
            $cat = \App\Models\ProductCategory::firstOrCreate(['name' => 'Geral', 'slug' => 'geral']);
            \App\Models\Product::create([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $price,
                'product_category_id' => $cat->id,
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
            $user->assignRole($request->role);
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
        
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        
        $user->save();

        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            $user->syncRoles([$request->role]);
        }

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    public function cursos()
    {
        $courses = \App\Models\Course::with('category')->latest()->get();
        $categories = \App\Models\Category::all();
        if ($categories->isEmpty()) {
            $categories = collect([\App\Models\Category::create(['name' => 'Desenvolvimento', 'slug' => 'desenvolvimento'])]);
        }
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
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
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

    public function destroyPartner($id)
    {
        $partner = \App\Models\Partner::findOrFail($id);
        $partner->delete();
        return redirect()->back()->with('success', 'Parceiro removido com sucesso!');
    }
}
