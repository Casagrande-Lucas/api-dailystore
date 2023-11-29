<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('home/login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:255|min:10',
            'password' => 'required|string|max:255|min:8',
        ]);

        if(!Auth::attempt(request(['email','password'])))
        {
            return view('login/index')->withErrors(['errors' => 'E-Mail ou Senha incorretos!']);
        }

        if ($request->input('email') === 'admin@dailycstore.com.br') {
            $guardName = 'admin';
        } else {
            $guardName = 'user';
        }
        Auth::guard($guardName)->login(User::where('email', $request->input('email'))->first());
        return redirect('products');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
