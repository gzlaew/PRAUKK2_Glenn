<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Http\Request;

class DeleteUser
{
    public function __invoke(Request $request, User $user)
    {
        /**
         * Beri tahu Intelephense bahwa $request->user() mengembalikan \App\Models\User
         * sehingga kita bisa akses $authUser->roles dsb.
         *
         * @var \App\Models\User $authUser
         */
        $authUser = $request->user();

        if ($authUser->roles !== 'Admin') {
            abort(403, 'Unauthorized');
        }

        $user->delete();

        return redirect()->route('users')
            ->with('success', 'User deleted successfully.');
    }
}
