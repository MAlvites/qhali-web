<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportSendMailRequest;
use App\Mail\SupportSendMail;
use App\Models\SupportMail;
use App\Services\SendMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;

class SupportMailController extends Controller
{
    public function sendMail(SupportSendMailRequest $request): JsonResponse
    {
        $user = $request->user();
        $to = config('mail.support');

        $bodyContent = [
            'content' => $request->content,
            'user_name' => $user->name
        ];

        $body = view("mail.support.support", $bodyContent);
        $sendMailService = new SendMailService($to, "Support Contact - $user->name", $body);
        $sendMailService();

        SupportMail::create([
            'user_id' => $user->id,
            'email_from' => $user->email,
            'email_to' => $to,
            'content' => $request->content
        ]);

        return response()->services(true, 'El correo fue enviado');
    }
}
