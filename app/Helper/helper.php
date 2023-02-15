<?php

use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

function currentUser()
{
    
    $user = Auth::user();

    $userRole = UserRole::where('user_id', $user->id)->first();

    $user->role_id = $userRole->role_id;

    return $user;
}