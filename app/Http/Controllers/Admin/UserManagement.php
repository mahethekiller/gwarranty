<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Support\Facades\Hash;
// use App\Models\UserProduct;
use Illuminate\Http\Request;

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
        foreach ($product_ids as $product_id) {
            UserProduct::create([
                'user_id' => $user->id,
                'product_id' => $product_id,
            ]);
        }

        $user->assignRole('editor');

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }


     public function edit(User $user)
    {
        return view('admin.users.usereditmodal', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

}
