<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BranchEmail;
use App\Models\WarrantyRegistrationNew;
use App\Models\ProductDetail;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BranchWarrantyNewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get branch admin's cities and states
        $branchEmail = Auth::user()->email;
        $cities = BranchEmail::where('commercial_email', $branchEmail)->pluck('city')->toArray();
        $states = BranchEmail::where('commercial_email', $branchEmail)->pluck('state')->toArray();

        // Fetch warranties for these locations
        $warranties = WarrantyRegistrationNew::with(['user', 'productDetails'])
            ->where(function ($query) use ($cities, $states) {
                $query->whereIn('dealer_city', $cities)
                      ->orWhereIn('dealer_state', $states);
            })
            ->latest()
            ->paginate(10);

        return view('admin.branch.warranty.new.index', [
            'pageTitle' => 'Branch Warranty Management',
            'pageDescription' => 'Manage new warranties for your branch',
            'warranties' => $warranties
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         // Get branch admin's cities and states to verify access logic again if needed, or rely on middleware/query scope
        $branchEmail = Auth::user()->email;
        $cities = BranchEmail::where('commercial_email', $branchEmail)->pluck('city')->toArray();
        $states = BranchEmail::where('commercial_email', $branchEmail)->pluck('state')->toArray();

        $warranty = WarrantyRegistrationNew::with(['user', 'productDetails', 'productDetails.productType', 'productDetails.variant'])
            ->where('id', $id)
            ->where(function ($query) use ($cities, $states) {
                 $query->whereIn('dealer_city', $cities)
                      ->orWhereIn('dealer_state', $states);
            })
            ->firstOrFail();

        return view('admin.branch.warranty.new.edit', [
            'pageTitle' => 'Process Warranty',
            'pageDescription' => 'Update status and remarks',
            'warranty' => $warranty
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $warranty = WarrantyRegistrationNew::findOrFail($id);

        $request->validate([
             'products' => 'required|array',
             'products.*.id' => 'required|exists:product_details,id',
             'products.*.status' => 'required|in:pending,approved,modify,rejected',
             'products.*.admin_remarks' => 'nullable|string|max:1000',
        ]);

        foreach ($request->products as $productData) {
            $productDetail = ProductDetail::where('warranty_registration_id', $warranty->id)
                ->where('id', $productData['id'])
                ->first();

            if ($productDetail) {
                $productDetail->update([
                    'status' => $productData['status'],
                    'admin_remarks' => $productData['admin_remarks'] ?? null,
                ]);
            }
        }

        // Update main warranty status based on products
        // We can use the accessor logic or set it explicitly.
        // Typically, we might want to store it to avoid querying all products every time,
        // but the accessor `overall_status` is good for display.
        // However, if we need to filter by main status in DB, we should update the `status` column.

        $this->updateWarrantyStatus($warranty);

        return redirect()->route('branch.warranties.new.index')->with('success', 'Warranty updated successfully.');
    }

    private function updateWarrantyStatus($warranty) {
         $productStatuses = $warranty->productDetails()->pluck('status')->toArray();

         $status = 'pending';
         if (in_array('modify', $productStatuses)) {
             $status = 'modify';
         } elseif (in_array('pending', $productStatuses)) {
             $status = 'pending';
         } elseif (array_unique($productStatuses) === ['approved']) {
             $status = 'approved';
         } elseif (in_array('rejected', $productStatuses)) {
             $status = 'rejected';
         }

         $warranty->update(['status' => $status]);
    }
}
