<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Http\Request;

class ShowEditUserForm
{
    public function __invoke(Request $request, User $user)
    {
        /**
         * @var \App\Models\User $authUser
         */
        $authUser = $request->user();

        if ($authUser->roles !== 'Admin') {
            abort(403, 'Unauthorized');
        }

        return view('page.user.edit', compact('user'));
    }
}
