<?php
namespace App\Http\Controllers;

use App\Models\WarrantyRegistrationNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('loginregisterhome',
            [
                'pageTitle'       => 'Greenlam Industries - Warranty Services Portal for Consumers',
                'pageDescription' => 'Greenlam Industries - Warranty Services Portal for Consumers',
                'pageScript'      => "login",
            ]
        );
    }

    /**
     * User dashboard with live warranty stats.
     */
    public function userDashboard()
    {
        $userId = Auth::id();

        // Status counts
        $total    = WarrantyRegistrationNew::where('user_id', $userId)->count();
        $pending  = WarrantyRegistrationNew::where('user_id', $userId)->where('status', 'pending')->count();
        $approved = WarrantyRegistrationNew::where('user_id', $userId)->where('status', 'approved')->count();
        $rejected = WarrantyRegistrationNew::where('user_id', $userId)->where('status', 'rejected')->count();
        $modify   = WarrantyRegistrationNew::where('user_id', $userId)->where('status', 'modify')->count();

        // Recent 5 warranties with products
        $recentWarranties = WarrantyRegistrationNew::with(['productDetails', 'productDetails.productType'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.user', compact(
            'total', 'pending', 'approved', 'rejected', 'modify', 'recentWarranties'
        ));
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}

