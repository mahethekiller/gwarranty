<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::orderBy('sort_order')->orderBy('id')->paginate(10);
        
        return view('admin.product-types.index', [
            'pageTitle' => 'Product Type Management',
            'pageDescription' => 'Manage product types and their configurations',
            'pageScript' => 'productTypes',
            'productTypes' => $productTypes,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_types,name',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        ProductType::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? $request->is_active : true,
            'fields' => [], // Default empty fields for now
        ]);

        return redirect()->route('admin.product-types.index')->with('success', 'Product Type created successfully.');
    }

    public function edit(ProductType $type)
    {
        return view('admin.product-types.edit_modal', [
            'productType' => $type,
        ]);
    }

    public function update(Request $request, ProductType $type)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_types,name,' . $type->id,
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $type->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? $request->is_active : true,
        ]);

        return redirect()->route('admin.product-types.index')->with('success', 'Product Type updated successfully.');
    }

    public function destroy(ProductType $type)
    {
        $type->delete();
        return redirect()->route('admin.product-types.index')->with('success', 'Product Type deleted successfully.');
    }
}
