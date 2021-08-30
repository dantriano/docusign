<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('documents.list');
    }
    public function manager(Request $request)
    {
        $id = $request->id;
        return view('documents.manager', compact('id'));
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        return view('documents.edit', compact('id'));
    }


    //API CALLS
    public function list(Request $request)
    {
        if ($request->expectsJson()) {
            // return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $response = User::all();
        return response()->json(['res' => $response]);
    }
    public function byDocument(Request $request)
    {
        if ($request->expectsJson()) {
            // return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $response = User::where('document_id', '=', $request->id)->get();
        return response()->json(['res' => $response]);
    }


    public function save(Request $request)
    {
        $doc = new User();
        $doc->name = $request->name;
        $doc->desc = $request->desc;
        $doc->save();
        return response()->json(['res' => $doc]);
    }
    public function update(Request $request)
    {
        $doc = User::findOrFail($request->id);

        $doc->name = $request->name;
        $doc->desc = $request->desc;

        $doc->save();

        return $doc;
    }
    public function show(Request $request)
    {
        $doc = User::findOrFail($request->id);
        return $doc;
    }
    public function delete(Request $request)
    {
        $task = User::destroy($request->id);
        return $task;
        //Esta función obtendra el id de la tarea que hayamos seleccionado y la borrará de nuestra BD
    }
}
