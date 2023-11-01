<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255|min:10',
            'password' => 'required|string|max:255|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Verifique os campos informados!', 'data' => $validator->errors()], status: 400, options: JSON_UNESCAPED_UNICODE);
        }

        if(!Auth::attempt(request(['email','password'])))
        {
            return response()->json(['success' => false, 'message' => 'Unauthorized', 'data' => []],401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('procedure', ['procedure-exec'], Carbon::now()->addHours(24));
        $token = $tokenResult->plainTextToken;

        return response()->json(['success' => true, 'message' => 'Usuário autenticado com sucesso.', 'data' => ['access_token' =>$token, 'token_type' => 'Bearer']], options: JSON_UNESCAPED_UNICODE);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(['success' => true, 'message' => 'Usuário deslogado com sucesso.', 'data' => []], options: JSON_UNESCAPED_UNICODE);
    }
}
