<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SendMailService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $token = Str::random(64);
  
        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        $resetUrl = config('app.url').'/password/reset/'.$token.'?email='.$request->email;;
        $body = view("email.reset-password", ["url" => $resetUrl]);
        $sendMailService = new SendMailService($request->email, "Recuperacion de clave", $body);
        $sendMailService();
         
        return back()->with('message', 'Te enviamos un correo con el enlace para restablecer la contraseña');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
  
        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email, 
                'token' => $request->token
            ])
            ->first();
  
        if(!$updatePassword){
            return back()->withInput()->with('error', 'Token invalido');
        }
  
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
 
        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('/login')->with('message', 'La contraseña fue cambiada');
    }
}
