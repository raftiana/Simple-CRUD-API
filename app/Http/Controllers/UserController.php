<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformer\UserTransformer;
use Auth;

class UserController extends Controller
{
    public function users(User $user){
        $user = $user->all();

        return fractal()
            ->collection($user)
            ->transformWith(new UserTransformer())
            ->toArray();
    }

    public function profile(User $user){

        $user = $user->find(Auth::user()->id);

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->includePosts()
            ->toArray();
    }

    public function profileById(User $user, $id){

        $user = $user->find($id);

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->includePosts()
            ->toArray();
    }
}
