<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;

class ProductUserController extends Controller
{
    /**
     * Retrieve all products attached to this user
     *
     * @param $uid User ID
     * @return \Illuminate\Http\Response
     */
    public function index($uid)
    {
        //Returns 404 if failed
        $userProducts = User::findOrFail($uid)->products;

        return response()->json($userProducts);
    }

    /**
     * Attach a product to a user
     *
     * @param $uid User ID
     * @param $pid Product ID
     * @return \Illuminate\Http\Response
     */
    public function store($uid, $pid)
    {
        //Returns 404 if failed
        $user = User::findOrFail($uid);

        return $user->attachProduct($pid);
    }

    /**
     * Detach a product to a user
     *
     * @param $uid
     * @param $pid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uid, $pid)
    {
        //Returns 404 if failed
        $user = User::findOrFail($uid);

        return $user->detachProduct($pid);
    }
}
