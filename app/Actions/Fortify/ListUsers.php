<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Http\Request;

class ListUsers
{
    public function __invoke(Request $request)
    {
        /**
         * @var \App\Models\User $authUser
         */
        $authUser = $request->user();

        if ($authUser->roles !== 'Admin') {
            abort(403, 'Unauthorized');
        }

        // Ambil data user
        $users = User::all();

        // Tampilkan ke view
        return view('user.index', compact('users'));
    }
}
