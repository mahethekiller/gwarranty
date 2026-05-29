<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use App\Models\ProductTypeVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index()
    {
        $variants = ProductTypeVariant::with('productType')->orderByDesc('id')->paginate(10);
        $productTypes = ProductType::where('is_active', true)->get();
        
        return view('admin.product-variants.index', [
            'pageTitle' => 'Product Variant Management',
            'pageDescription' => 'Manage variants for different product types',
            'pageScript' => 'productVariants',
            'variants' => $variants,
            'productTypes' => $productTypes,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_type_id' => 'required|exists:product_types,id',
            'variant_name' => 'required|string|max:255',
            'warranty_period' => 'required|string|max:255',
            'usage_type' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        ProductTypeVariant::create([
            'product_type_id' => $request->product_type_id,
            'variant_name' => $request->variant_name,
            'warranty_period' => $request->warranty_period,
            'usage_type' => $request->usage_type,
            'is_active' => $request->has('is_active') ? $request->is_active : true,
        ]);

        return redirect()->route('admin.product-variants.index')->with('success', 'Product Variant created successfully.');
    }

    public function edit(ProductTypeVariant $variant)
    {
        $productTypes = ProductType::where('is_active', true)->get();
        return view('admin.product-variants.edit_modal', [
            'variant' => $variant,
            'productTypes' => $productTypes,
        ]);
    }

    public function update(Request $request, ProductTypeVariant $variant)
    {
        $request->validate([
            'product_type_id' => 'required|exists:product_types,id',
            'variant_name' => 'required|string|max:255',
            'warranty_period' => 'required|string|max:255',
            'usage_type' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $variant->update([
            'product_type_id' => $request->product_type_id,
            'variant_name' => $request->variant_name,
            'warranty_period' => $request->warranty_period,
            'usage_type' => $request->usage_type,
            'is_active' => $request->has('is_active') ? $request->is_active : true,
        ]);

        return redirect()->route('admin.product-variants.index')->with('success', 'Product Variant updated successfully.');
    }

    public function destroy(ProductTypeVariant $variant)
    {
        $variant->delete();
        return redirect()->route('admin.product-variants.index')->with('success', 'Product Variant deleted successfully.');
    }
}
