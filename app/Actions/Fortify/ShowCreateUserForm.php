<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;

class ShowCreateUserForm
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

        return view('page.user.create');
    }
}
