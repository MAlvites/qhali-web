<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ChangePasswordUnauthorizeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\IfExistEmailRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Notifications\SendPasswordResetEmail as NotificationsSendPasswordResetEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthenticateController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->services(false, 'Acceso Inautorizado', [], 401);
        }

        $data = [
            'session_token' => $request->user()->createToken($request->device)->plainTextToken
        ];

        return response()->services(true, 'El usuario inicio sesion', $data);
    }
    
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->services(true, 'La sesión fue cerrada');

    }

    public function getUser(Request $request)
    {
        $user = User::selectRaw('users.id, users.name, email, user_roles.role_id')
        ->join('user_roles', 'user_roles.user_id', 'users.id')
        ->where('users.id', $request->user()->id)
        ->first();
        return response()->services(true, 'Informacion del usuario', $user);
    }

    public function sendPasswordResetEmail(IfExistEmailRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        $user->remember_token = Str::random(30);
        $user->save();
        $user->notify(new NotificationsSendPasswordResetEmail($user));

        return response()->services(true, 'Se envió el correo para restablecer la contraseña');
    }

    public function changePassword(Request $request): JsonResponse
    {
        $user = User::where('remember_token', $request->remember_token)->first();

        if (is_null($user)) {
            throw new ChangePasswordUnauthorizeException();
        }

        $user->remember_token = null;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->services(true, 'La contrseña fue cambiada con éxito');
    }
}