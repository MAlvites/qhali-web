<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBotActionRequest;
use App\Http\Requests\UpdateBotActionRequest;
use App\Models\BotAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BotActionController extends Controller
{
    public function index()
    {
        if (currentUser()->role_id == 1) {
            return view('bot-action');
        }
        return redirect('/dashboard');
    }

    public function create(CreateBotActionRequest $request)
    {
        $fileName = "/img/bot-action/".$request->img->getClientOriginalName();

        $request->img->move(public_path('img/bot-action'), $fileName);

        BotAction::create([
            "name" => $request->name,
            "url" => $request->url,
            "img" => $fileName,
            "type" => $request->type
        ]);

        return response()->services(true, 'Acción registrada', []);
    }

    public function search()
    {
        $botActions = BotAction::selectRaw("id, name, url, img, type")
            ->orderByDesc("id")
            ->paginate(15);

        return response()->services(true, 'Lista de acciones', $botActions);
    }

    public function getBotAction(int $botActionId)
    {
        $botAction = BotAction::find($botActionId);

        if (is_null($botAction)) {
            return response()->services(false, 'La acciòn no existe', [], 404);
        }

        return response()->services(true, 'Información de la accióm', $botAction);
    }

    public function delete(int $botActionId)
    {
        BotAction::find($botActionId)->delete();

        return response()->services(true, 'La acción fue eliminada', []);
    }

    public function update(UpdateBotActionRequest $request)
    {
        $botAction = BotAction::find($request->id);
        $botAction->name = $request->name;
        $botAction->url = $request->url;
        $botAction->type = $request->type;

        if ($request->img !== 'null') {
            $fileName = "/img/".$request->img->getClientOriginalName();
            $request->img->move(public_path('img'), $fileName);
            $botAction->img = $fileName;
        }
        $botAction->save();
        return response()->services(true, 'Acción actualizada', []);
    }

    public function getAll()
    {
        $botAction = BotAction::all();

        return response()->services(true, 'Lista de acciones', $botAction);
    }
}
