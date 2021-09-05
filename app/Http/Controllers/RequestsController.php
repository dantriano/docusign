<?php

namespace App\Http\Controllers;

use App\Models\Request as Peticiones;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

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

    public function getRequestPDFb64(Request $request)
    {
        $req = $this->show($request);
        $signedName = $req->signedName;
        $pdf = getPDF64($signedName, 'signed/');
        if ($pdf)
            return $pdf;
        return false;
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

        $response = Peticiones::leftJoin('users', 'users.id', '=', 'requests.user_id')->select('requests.id as request_id','requests.status as request_status','requests.signedName', 'users.*')->where('document_id', '=', $request->id)->get();
        return response()->json(['res' => $response]);
    }

    public function byUser(Request $request)
    {
        if ($request->expectsJson()) {
            // return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        $response = Peticiones::leftJoin('documents', 'documents.id', '=', 'requests.document_id')->select('requests.id as request_id', 'documents.*')->where('requests.user_id', '=', $request->id)->where('requests.status', '=', $request->status)->get();
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
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            $doc->$key = $value;
        }
        $doc->save();
        return $doc;
    }
    public function show(Request $request)
    {
        $doc = Peticiones::leftJoin('documents', 'documents.id', '=', 'requests.document_id')->select('documents.*', 'requests.id as request_id', 'requests.status as requestStatus', 'requests.signedName')->findOrFail($request->id);
        return $doc;
    }
    public function delete(Request $request)
    {
        $task = Peticiones::destroy($request->id);
        return $task;
        //Esta función obtendra el id de la tarea que hayamos seleccionado y la borrará de nuestra BD
    }
}
