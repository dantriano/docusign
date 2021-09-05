@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav class="navbar navbar-light justify-content-end">
                <a href="{{ route('documentos.edit') }}" class="btn btn-success btn-sm me-1 text-white">Crear</a>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">

                <div id="app" class="content ">
                    <document-list-component :user="'{!! Auth::id() !!}'"></document-list-component>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@stop