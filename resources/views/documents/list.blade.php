@extends('layouts.app')

@section('content')
<nav class="navbar navbar-light bg-light justify-content-end">
    <a href="{{ route('documentos.edit') }}" class="btn btn-success btn-sm me-1 text-white">Crear</a>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#pendents" type="button" role="tab" aria-controls="home" aria-selected="true">
                        Pendents
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="false">
                        Tots els documents
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="pendents" role="tabpanel" aria-labelledby="pendents-tab">
                    <div id="app" class="content ">
                        <document-list-component  :user="'{!! Auth::id() !!}'"></document-list-component>
                    </div>
                </div>
                <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
                    ...
                </div>
            </div>
        </div>
    </div>
</div>

@stop