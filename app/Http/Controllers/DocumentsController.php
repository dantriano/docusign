<?php

namespace App\Http\Controllers;

use App\Models\Document;

use Illuminate\Http\Request;

class DocumentsController extends Controller
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

        $response = Document::all();
        return response()->json(['res' => $response]);
    }
    public function byUser(Request $request)
    {
        if ($request->expectsJson()) {
            // return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $response = Document::where('user_id', '=', $request->id)->get();
        return response()->json(['res' => $response]);
    }
    public function get(Request $request)
    {
        if ($request->expectsJson()) {
            // return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $response = Document::find($request->id);
        return response()->json(['res' => $response]);
    }


    public function save(Request $request)
    {
        $doc = new Document();
        $doc->name = $request->name;
        $doc->desc = $request->desc;
        $doc->save();
        return response()->json(['res' => $doc]);
    }
    public function update(Request $request)
    {
        $doc = Document::findOrFail($request->id);

        $doc->name = $request->name;
        $doc->desc = $request->desc;

        $doc->save();

        return $doc;
    }
    public function show(Request $request)
    {
        $doc = Document::findOrFail($request->id);
        return $doc;
    }
    public function delete(Request $request)
    {
        $task = Document::destroy($request->id);
        return $task;
        //Esta función obtendra el id de la tarea que hayamos seleccionado y la borrará de nuestra BD
    }
}
