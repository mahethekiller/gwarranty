<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UserProduct;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarrantyManagement extends Controller
{
    public function index(Request $request)
    {
        // Code to list warranties
        $userId = Auth::id();
        if (Auth::user()->hasRole('admin')) {
            $warranties = Warranty::all();
        } else {
            // $productIds = UserProduct::where('user_id', $userId)->pluck('product_id')->toArray();
            $productIds = UserProduct::where('user_id', $userId)->value('product_id');
            $productIds = explode(',', $productIds); // convert to array
            $warranties = Warranty::whereIn('product_type', $productIds)->get();
            // dd($warranties);
        }
        $productNames = Product::pluck('name', 'id'); // returns [id => name]

        return view('admin.warranty.index',
            [
                "pageTitle"       => "Warranty Management",
                "pageDescription" => "Warranty Management",
                "pageScript"      => "warrantyadmin",
                "warranties"      => $warranties,
                "productNames"    => $productNames,
            ]);

    }

    public function create()
    {
        // Code to show the form for creating a new warranty
    }

    public function store(Request $request)
    {
        // Code to store a new warranty
    }

    public function show($id)
    {
        // Code to display a specific warranty
    }

    public function edit($id)
    {
        $warranty = Warranty::findOrFail($id);

        // return response()->json($warranty);

        return view('admin.warranty.editmodal', [
            'warranty' => $warranty,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Code to update a specific warranty

        // Validate request data
        $request->validate([
            'status'  => 'required|string|in:pending,modify,approved',
            'remarks' => 'required|string',
        ]);

        $warranty = Warranty::findOrFail($id);

        // Update the warranty status and remarks
        $warranty->status  = $request->input('status');
        $warranty->remarks = $request->input('remarks');
        $warranty->modified_by = Auth::id();
        $warranty->checked_by = Auth::id();
        $warranty->save();

        return response()->json(['message' => 'Warranty updated successfully']);

    }

    public function destroy($id)
    {
        // Code to delete a specific warranty
    }
}
