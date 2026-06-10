<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BranchEmail;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Http\Request;
// use App\Models\UserProduct;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserManagement extends Controller
{

    public function index()
    {
        $users = User::with('roles')->orderByDesc('id')->paginate(10);
        // $users = User::role(['admin', 'branch_admin'])->with('roles')->get();
        $roles       = Role::whereNotIn('name', ['user'])->get();
        $branchNames = BranchEmail::select('branch_name')->distinct()->pluck('branch_name');
        return view('admin.users.index',
            [
                "pageTitle"       => "User Management",
                "pageDescription" => "User Management",
                "pageScript"      => "adminUsers",
                "users"           => $users,
                "products"        => Product::all(),
                "roles"           => $roles,
                "branchNames"     => $branchNames,
            ]

        );
    }

    public function store(Request $request)
    {

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|digits:10|unique:users',
            'role'         => ['required', Rule::in(Role::pluck('name')->toArray())],

            'password'     => 'required|string|min:8|confirmed',
            'product_type' => $request->role == 'country_admin' ? 'required' : 'nullable',

        ]);

        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'password'     => Hash::make($request->password),

        ]);
        $user->assignRole($request->role);

        if ($request->role == 'country_admin') {
            $product_ids = $request->product_type;
            UserProduct::create([
                'user_id'    => $user->id,
                // 'product_id' => implode(',', $product_ids),
                'product_id' => $product_ids,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {

        $user_products = UserProduct::where('user_id', $user->id)->first();
        $product_id    = $user_products ? $user_products->product_id : '';

        // $user_role = $user->roles->first()->name;
        $roles       = Role::whereNotIn('name', ['user'])->get();
        $branchNames = BranchEmail::select('branch_name')->distinct()->pluck('branch_name');

        // $user->product_type = Product::whereIn('id', $product_ids)->pluck('name')->toArray();

        $products = Product::all();
        return view('admin.users.usereditmodal', [
            'user'        => $user,
            'products'    => $products,
            'product_id'  => $product_id,
            'roles'       => $roles,
            'branchNames' => $branchNames,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|digits:10|unique:users,phone_number,' . $user->id,
            'role'         => ['required', Rule::in(Role::pluck('name')->toArray())],
            'password'     => 'nullable|string|min:8',
            'product_type' => $request->role == 'country_admin' ? 'required' : 'nullable',
            'status'       => ['required', Rule::in(['active', 'inactive'])], // assuming 'active' and 'inactive' are the possible enum values
        ]);

        $updateData = [
            'name'         => $request->name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'status'       => $request->status,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $user->update($updateData);



        if ($request->role == 'country_admin') {
            $user_product = UserProduct::where('user_id', $user->id)->first();
            $product_ids = $request->product_type;
            if ($user_product) {
                $user_product->update([
                    'product_id' => $product_ids,
                ]);
            } else {
                UserProduct::create([
                    'user_id'    => $user->id,
                    'product_id' => $product_ids,
                ]);
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.' . $request->status);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function getBranchEmail(Request $request)
    {
        $branchName = $request->branch_name;

        // Example: assuming you have a model Branch with name and email columns
        $branch = BranchEmail::where('branch_name', $branchName)->first();

        if (! $branch) {
            return response()->json([
                'email'  => null,
                'exists' => false,
            ]);
        }

        $email  = $branch->commercial_email;
        $exists = User::where('email', $email)->exists();

        return response()->json([
            'email'  => $email,
            'exists' => $exists,
        ]);
    }
    public function exportCsv()
    {
        $users = User::with('roles')->orderByDesc('id')->get();

        $filename = "users_export_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['S. No.', 'Name', 'Role', 'Email', 'Phone', 'Product Type', 'Status', 'Created At'];

        $callback = function() use($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $key => $user) {
                $roles = $user->roles->pluck('display_name')->implode(', ');
                
                $productIds = explode(',', \App\Models\UserProduct::where('user_id', $user->id)->value('product_id') ?? '');
                $productName = \App\Models\Product::whereIn('id', $productIds)->pluck('name')->implode(', ');

                $row = [
                    $key + 1,
                    $user->name,
                    $roles,
                    $user->email,
                    $user->phone_number,
                    $productName,
                    ucfirst($user->status),
                    $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '',
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
