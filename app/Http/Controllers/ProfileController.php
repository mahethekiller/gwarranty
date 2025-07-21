<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {

        $states = config('constants.states');

        $cities = []; // Initially empty

        if (Auth::user()->state) {
            $cities = $this->getCities(Auth::user()->state);
        }

        return view('profile.edit', [
            'user'            => $request->user(),
            'pageTitle'       => 'Profile',
            'pageDescription' => 'Profile',
            'pageScript'      => 'profile',
            'states'          => $states,
            'cities'          => $cities,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $request->validate([
            'city'    => ['required', 'string', 'max:50'],
            'state'   => ['required', 'string', 'max:50'],
            'pincode' => ['required', 'integer', 'digits:6'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $user->city = $request->post('city');
        $user->state = $request->post('state');
        $user->pincode = $request->post('pincode');
        $user->address = $request->post('address');
        $user->profile_updated = 1;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function getCitiesAjax($state)
    {
        $cities = $this->getCities($state);
        return response()->json($cities);
    }

    public function getCities($state)
    {

        $citiesList = config('constants.citiesList');

        return $citiesList[$state] ?? [];
    }

}
