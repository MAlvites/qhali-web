<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        if (currentUser()->role_id == 1) {
            return view('map');
        }
        return redirect('/dashboard');
    }

    public function create(Request $request)
    {
        $map = Map::create([
            'name' => $request->name,
            'url' => $request->url
        ]);

        return response()->services(true, 'El mapa fue registrado correctamente.', $map);
    }

    public function list()
    {
        $maps = Map::get();
        return response()->services(true, 'Listado de mapas.', $maps);
    }

    public function update(Request $request)
    {
        $map = Map::find($request->id);
        $map->name = $request->name;
        $map->url = $request->url;
        $map->save();
        return response()->services(true, 'El mapa fue actualizado correctamente.', $map);
    }

    public function delete(int $id)
    {
        $map = Map::find($id);
        $map->delete();
        return response()->services(true, 'El mapa fue eliminado correctamente.');
    }

    public function search()
    {
        $maps = Map::selectRaw("id, name, url, url img")
            ->orderByDesc("id")
            ->paginate(15);

        return response()->services(true, 'Lista de mapas', $maps);
    }

    public function getMap(int $id)
    {
        $map = Map::find($id);
        return response()->services(true, 'Mapa.', $map);
    }
}
