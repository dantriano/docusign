<?php

namespace App\Http\Controllers;

use App\Models\Request as Peticiones;
use Illuminate\Http\Request;

class RequestsController extends Controller
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
        return view('requests.list');
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

    public function viewSign(Request $request)
    {
        $req = $this->show($request);
        return view('sign.view', compact('req'));
    }

    //API CALLS
    public function list(Request $request)
    {
        if ($request->expectsJson()) {
            // return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $response = Peticiones::all();
        return response()->json(['res' => $response]);
    }
    public function byDocument(Request $request)
    {
        if ($request->expectsJson()) {
            // return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $response = Peticiones::leftJoin('users', 'users.id', '=', 'requests.user_id')->where('document_id', '=', $request->id)->get();
        return response()->json(['res' => $response]);
    }

    public function byUser(Request $request)
    {
        if ($request->expectsJson()) {
            // return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        $response = Peticiones::leftJoin('documents', 'documents.id', '=', 'requests.document_id')->select('requests.id as request_id', 'documents.*')->where('requests.user_id', '=', $request->id)->get();
        return response()->json(['res' => $response]);
    }
    public function save(Request $request)
    {
        $doc = new Peticiones();
        $doc->user_id = $request->user_id;
        $doc->document_id = $request->document_id;
        $doc->save();
        return response()->json(['res' => $doc]);
    }
    public function update(Request $request)
    {
        $doc = Peticiones::findOrFail($request->id);

        $doc->name = $request->name;
        $doc->desc = $request->desc;

        $doc->save();

        return $doc;
    }
    public function show(Request $request)
    {
        $doc = Peticiones::leftJoin('documents', 'documents.id', '=', 'requests.document_id')->select('requests.id as request_id', 'documents.*')->findOrFail($request->id);
        return $doc;
    }
    public function delete(Request $request)
    {
        $task = Peticiones::destroy($request->id);
        return $task;
        //Esta función obtendra el id de la tarea que hayamos seleccionado y la borrará de nuestra BD
    }
}