<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Support\Facades\Hash;
// use App\Models\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserManagement extends Controller
{

    public function index()
    {
        $users = User::role(['admin', 'editor'])->get();
        return view('admin.users.index',
            [
                "pageTitle"      => "User Management",
                "pageDescription" => "User Management",
                "pageScript"      => "adminUsers",
                "users"           => $users,
                "products"        => Product::all(),
            ]

        );
    }

    public function store(Request $request)
    {

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|digits:10|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'product_type' => 'required|array',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),

        ]);

        $product_ids = $request->product_type;
        UserProduct::create([
            'user_id' => $user->id,
            'product_id' => implode(',', $product_ids),
        ]);

        $user->assignRole('editor');

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }


     public function edit(User $user)
    {

        $user_products = UserProduct::where('user_id', $user->id)->first();
        $product_ids = explode(',', $user_products->product_id);
        // $user->product_type = Product::whereIn('id', $product_ids)->pluck('name')->toArray();



        $products = Product::all();
        return view('admin.users.usereditmodal', compact('user', 'product_ids', 'products'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'phone_number' => 'required|string|digits:10|unique:users,phone_number,' . $user->id,
            'product_type' => 'required|array',
            'status' => ['required', Rule::in(['active', 'inactive'])], // assuming 'active' and 'inactive' are the possible enum values
        ]);

        $updateData = [
            'name'     => $request->name,
            'email'    => $request->email,
            'phone_number' => $request->phone_number,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $user->update($updateData);


        $user_product = UserProduct::where('user_id', $user->id)->first();
        $product_ids = $request->product_type;
        $user_product->update([
            'product_id' => implode(',', $product_ids),
        ]);


        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.'.$request->status);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

}
