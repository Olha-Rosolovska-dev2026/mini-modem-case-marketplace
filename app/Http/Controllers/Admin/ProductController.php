<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Admin product controller - mini modem case catalogue
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ModemModel;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.products.index', [
            'products' => Product::with(['category', 'vendor'])
                ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%' . $request->string('q') . '%'))
                ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
                ->latest()->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.products.form', $this->formData(new Product()));
    }

    public function store(Request $request)
    {
        $product = Product::create($this->validated($request));
        $this->syncImages($product, $request);
        $product->modemModels()->sync($request->input('modem_models', []));

        return redirect()->route('admin.products.index')->with('status', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', $this->formData($product));
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validated($request, $product));
        $this->syncImages($product, $request);
        $product->modemModels()->sync($request->input('modem_models', []));

        return redirect()->route('admin.products.index')->with('status', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('status', 'Product deleted.');
    }

    protected function formData(Product $product): array
    {
        return [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
            'vendors' => Vendor::orderBy('name')->get(),
            'modemModels' => ModemModel::orderBy('brand')->orderBy('name')->get(),
        ];
    }

    protected function validated(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'sku' => ['nullable', 'string', 'max:60'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'vendor_id' => ['nullable', 'exists:vendors,id'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'case_type' => ['required', 'string', 'max:40'],
            'material' => ['nullable', 'string', 'max:80'],
            'color' => ['nullable', 'string', 'max:60'],
            'dimensions' => ['nullable', 'string', 'max:80'],
            'inner_dimensions' => ['nullable', 'string', 'max:80'],
            'weight_grams' => ['nullable', 'numeric', 'min:0'],
            'ip_rating' => ['nullable', 'string', 'max:20'],
            'led_indicator_window' => ['nullable', 'string', 'max:80'],
            'mounting_type' => ['nullable', 'string', 'max:80'],
            'warranty_months' => ['required', 'integer', 'min:0', 'max:120'],
            'status' => ['required', 'in:active,draft,archived'],
            'meta_title' => ['nullable', 'string', 'max:180'],
            'meta_description' => ['nullable', 'string', 'max:300'],
        ]);

        $data['slug'] = $product?->slug ?: Str::slug($data['name'] . '-' . Str::random(4));
        $data['antenna_hole'] = $request->boolean('antenna_hole');
        $data['ventilation_slots'] = $request->boolean('ventilation_slots');
        $data['wall_mount'] = $request->boolean('wall_mount');
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }

    protected function syncImages(Product $product, Request $request): void
    {
        $paths = array_filter((array) $request->input('image_paths', []));
        $product->images()->delete();

        foreach (array_values($paths) as $index => $path) {
            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
                'alt' => $product->name,
                'sort_order' => $index,
                'is_primary' => $index === 0,
            ]);
        }
    }
}
