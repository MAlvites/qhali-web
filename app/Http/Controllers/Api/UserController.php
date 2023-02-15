<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function create(CreateUserRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {

            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password)
            ]);

            UserRole::create([
                "user_id" => $user->id,
                "role_id" => $request->role_id
            ]);
            DB::commit();
            return response()->services(true, 'Usuario registrado', $user);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->services(true, 'Imposible registrar el usuario');
        }
    }

    public function list(Request $request): JsonResponse
    {
        $users = User::selectRaw('users.id, users.name, email, roles.name role_name, user_roles.role_id')
            ->join('user_roles', 'user_roles.user_id', 'users.id')
            ->join('roles', 'roles.id', 'user_roles.role_id')
            ->whereRaw('users.name like "%'.$request->name.'%"')
            ->orderByDesc('users.id')
            ->paginate(15);
        
        return response()->services(true, 'Lista de usuarios', $users);
    }

    public function delete($id)
    {
        User::find($id)->delete();
        return response()->services(true, 'El usuario fue eliminado', []);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $userRole = UserRole::where('user_id', $user->id)->first();
        if ($userRole->role_id != $request->role_id) {
            $userRole->role_id = $request->role_id;
            $userRole->save();
        }
        return response()->services(true, 'El usuario fue actualizado', []);
    }

    public function getUser(int $id)
    {
        $user = User::selectRaw('users.id, users.name, email, user_roles.role_id')
        ->join('user_roles', 'user_roles.user_id', 'users.id')
        ->where('users.id', $id)
        ->first();

        return response()->services(true, 'Informacion del usuario', $user);
    }
}
