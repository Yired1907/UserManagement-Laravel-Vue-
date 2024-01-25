<?php

namespace App\Http\Controllers\Amin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return $users;
    }
    public function store()
    {
        return User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password'),
        ]);
    }
}
