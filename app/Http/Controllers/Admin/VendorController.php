<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Admin vendor approval controller
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.vendors.index', [
            'vendors' => Vendor::withCount('products')
                ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
                ->latest()->paginate(15),
            'pendingCount' => Vendor::where('status', 'pending')->count(),
        ]);
    }

    public function create()
    {
        return view('admin.vendors.form', ['vendor' => new Vendor()]);
    }

    public function store(Request $request)
    {
        Vendor::create($this->validated($request));

        return redirect()->route('admin.vendors.index')->with('status', 'Vendor created.');
    }

    public function edit(Vendor $vendor)
    {
        return view('admin.vendors.form', ['vendor' => $vendor]);
    }

    public function update(Request $request, Vendor $vendor)
    {
        $vendor->update($this->validated($request));

        return redirect()->route('admin.vendors.index')->with('status', 'Vendor updated.');
    }

    public function approve(Vendor $vendor)
    {
        $vendor->update(['status' => 'approved']);

        return back()->with('status', $vendor->name . ' is now an approved seller.');
    }

    public function suspend(Vendor $vendor)
    {
        $vendor->update(['status' => 'suspended']);

        return back()->with('status', $vendor->name . ' was suspended.');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return back()->with('status', 'Vendor deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'email' => ['nullable', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'description' => ['nullable', 'string', 'max:2000'],
            'address' => ['nullable', 'string', 'max:200'],
            'city' => ['nullable', 'string', 'max:120'],
            'country' => ['nullable', 'string', 'max:80'],
            'status' => ['required', 'in:pending,approved,suspended'],
            'commission_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'is_featured' => ['nullable', 'boolean'],
        ]) + ['is_featured' => $request->boolean('is_featured')];
    }
}
