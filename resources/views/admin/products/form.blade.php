{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', $product->exists ? 'Edit product' : 'New product')
@section('heading', $product->exists ? 'Edit enclosure' : 'Add enclosure')

@section('content')
<form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" class="grid gap-6 xl:grid-cols-[1fr_360px]">
    @csrf
    @if ($product->exists) @method('PUT') @endif

    <div class="space-y-6">
        <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="font-bold text-slate-800">Basic details</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2"><label class="block text-sm font-medium">Product name</label><input type="text" name="name" value="{{ old('name', $product->name) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
                <div><label class="block text-sm font-medium">SKU</label><input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm" placeholder="Auto-generated if blank"></div>
                <div><label class="block text-sm font-medium">Category</label>
                    <select name="category_id" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                        <option value="">Uncategorised</option>
                        @foreach ($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>@endforeach
                    </select></div>
                <div><label class="block text-sm font-medium">Vendor</label>
                    <select name="vendor_id" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                        <option value="">Marketplace direct</option>
                        @foreach ($vendors as $vendor)<option value="{{ $vendor->id }}" @selected(old('vendor_id', $product->vendor_id) == $vendor->id)>{{ $vendor->name }}</option>@endforeach
                    </select></div>
                <div><label class="block text-sm font-medium">Status</label>
                    <select name="status" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                        @foreach (['active','draft','archived'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $product->status ?? 'active') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select></div>
            </div>
            <div><label class="block text-sm font-medium">Short description</label><textarea name="short_description" rows="2" class="mt-1 w-full rounded-lg border-slate-300 text-sm">{{ old('short_description', $product->short_description) }}</textarea></div>
            <div><label class="block text-sm font-medium">Full description</label><textarea name="description" rows="7" class="mt-1 w-full rounded-lg border-slate-300 text-sm">{{ old('description', $product->description) }}</textarea></div>
        </div>

        <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="font-bold text-slate-800">Enclosure specifications</h2>
            <div class="grid gap-4 sm:grid-cols-3">
                <div><label class="block text-sm font-medium">Case type</label>
                    <select name="case_type" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                        @foreach (['enclosure','din_rail','wall_mount','rack_mount','weatherproof','desktop','open_frame'] as $type)
                            <option value="{{ $type }}" @selected(old('case_type', $product->case_type) === $type)>{{ case_type_label($type) }}</option>
                        @endforeach
                    </select></div>
                <div><label class="block text-sm font-medium">Material</label><input type="text" name="material" value="{{ old('material', $product->material) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm" placeholder="ABS, aluminium, polycarbonate"></div>
                <div><label class="block text-sm font-medium">Colour</label><input type="text" name="color" value="{{ old('color', $product->color) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
                <div><label class="block text-sm font-medium">Outer dimensions</label><input type="text" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm" placeholder="120 x 65 x 28 mm"></div>
                <div><label class="block text-sm font-medium">Inner cavity</label><input type="text" name="inner_dimensions" value="{{ old('inner_dimensions', $product->inner_dimensions) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm" placeholder="108 x 54 x 22 mm"></div>
                <div><label class="block text-sm font-medium">Weight (g)</label><input type="number" step="0.01" name="weight_grams" value="{{ old('weight_grams', $product->weight_grams) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
                <div><label class="block text-sm font-medium">IP rating</label><input type="text" name="ip_rating" value="{{ old('ip_rating', $product->ip_rating) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm" placeholder="IP54"></div>
                <div><label class="block text-sm font-medium">Mounting type</label><input type="text" name="mounting_type" value="{{ old('mounting_type', $product->mounting_type) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm" placeholder="DIN rail 35 mm"></div>
                <div><label class="block text-sm font-medium">LED indicator window</label><input type="text" name="led_indicator_window" value="{{ old('led_indicator_window', $product->led_indicator_window) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm" placeholder="Smoked acrylic"></div>
                <div><label class="block text-sm font-medium">Warranty (months)</label><input type="number" name="warranty_months" value="{{ old('warranty_months', $product->warranty_months ?? 12) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
            </div>
            <div class="flex flex-wrap gap-6 pt-2 text-sm">
                <label class="flex items-center gap-2"><input type="checkbox" name="antenna_hole" value="1" @checked(old('antenna_hole', $product->antenna_hole)) class="rounded border-slate-300"> Antenna hole</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="ventilation_slots" value="1" @checked(old('ventilation_slots', $product->ventilation_slots)) class="rounded border-slate-300"> Ventilation slots</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="wall_mount" value="1" @checked(old('wall_mount', $product->wall_mount)) class="rounded border-slate-300"> Wall mount ready</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured)) class="rounded border-slate-300"> Featured listing</label>
            </div>
        </div>

        <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="font-bold text-slate-800">Compatible modem models</h2>
            <div class="grid gap-2 sm:grid-cols-3">
                @php $selectedModels = old('modem_models', $product->exists ? $product->modemModels->pluck('id')->all() : []); @endphp
                @foreach ($modemModels as $model)
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="modem_models[]" value="{{ $model->id }}" @checked(in_array($model->id, $selectedModels)) class="rounded border-slate-300">
                        {{ $model->full_name }}
                    </label>
                @endforeach
            </div>
        </div>
    </div>

    <aside class="space-y-5">
        <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="font-bold text-slate-800">Pricing &amp; stock</h2>
            <div><label class="block text-sm font-medium">Price</label><input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
            <div><label class="block text-sm font-medium">Compare-at price</label><input type="number" step="0.01" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
            <div><label class="block text-sm font-medium">Stock quantity</label><input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
        </div>

        <div class="space-y-3 rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="font-bold text-slate-800">Images</h2>
            <p class="text-xs text-slate-500">Enter media library paths (for example <code>products/case-front.jpg</code>). The first image is the primary photo.</p>
            @php $paths = old('image_paths', $product->exists ? $product->images->pluck('path')->all() : []); @endphp
            @for ($i = 0; $i < 4; $i++)
                <input type="text" name="image_paths[]" value="{{ $paths[$i] ?? '' }}" placeholder="Image path {{ $i + 1 }}" class="w-full rounded-lg border-slate-300 text-sm">
            @endfor
        </div>

        <div class="space-y-3 rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="font-bold text-slate-800">SEO</h2>
            <div><label class="block text-sm font-medium">Meta title</label><input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
            <div><label class="block text-sm font-medium">Meta description</label><textarea name="meta_description" rows="3" class="mt-1 w-full rounded-lg border-slate-300 text-sm">{{ old('meta_description', $product->meta_description) }}</textarea></div>
        </div>

        <button class="w-full rounded-lg bg-sky-600 px-6 py-3 text-sm font-semibold text-white">Save product</button>
        <a href="{{ route('admin.products.index') }}" class="block text-center text-sm font-medium text-slate-500">Cancel</a>
    </aside>
</form>
@endsection
