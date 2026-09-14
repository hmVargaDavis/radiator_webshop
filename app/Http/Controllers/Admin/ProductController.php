<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('sort_order')->orderBy('width_mm')->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', ['product' => new Product()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['size_label']).'-'.Str::random(4);
        $data['name'] = $data['name'] ?: ('22K lapradiátor '.$data['size_label']);
        $data = $this->handleImage($request, $data);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Termék létrehozva.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);
        $data['name'] = $data['name'] ?: ('22K lapradiátor '.$data['size_label']);
        $data = $this->handleImage($request, $data, $product);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Termék mentve.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Termék törölve.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'nullable|string|max:160',
            'size_label' => 'required|string|max:40',
            'height_mm' => 'required|integer|min:100|max:2000',
            'width_mm' => 'required|integer|min:100|max:3000',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'package_contents' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'in_stock' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:160',
            'meta_description' => 'nullable|string|max:320',
            'ai_description' => 'nullable|string',
            'keywords' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|max:4096',
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'in_stock' => $request->boolean('in_stock'),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }

    private function handleImage(Request $request, array $data, ?Product $product = null): array
    {
        unset($data['image_file']);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $data['image'] = $path;
        }

        return $data;
    }
}
