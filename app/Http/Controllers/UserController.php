<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BuyCookiesRequest;

class UserController extends Controller
{
    public function buyCookies(BuyCookiesRequest $request, $cookies)
    {
        $user = $request->user();

        /**
         * Throw error if user has insufficient wallet amount.
         */
        if($user->wallet < $cookies) {
            return response()->json([
                'error' => 'You do not have enough amount to buy this number of cookies.'
            ], 400);
        }

        /**
         * Update user wallet amount.
         */
        $user->wallet -= $cookies;
        $user->save();

        /**
         * Log the transaction.
         */
        Log:info('User ' . $user->email . ' have bought ' . $cookies . ' cookies');

        /**
         * Return success response.
         */
        return 'Success, you have bought ' . $cookies . ' cookies!';
    }
}
