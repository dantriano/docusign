@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="app" class="content ">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#pendents" type="button" role="tab" aria-controls="home" aria-selected="true">
                            Pendents
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="false">
                            Totes els peticions
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="pendents" role="tabpanel" aria-labelledby="pendents-tab">
                        <requests-list-component :user="'{!! Auth::id() !!}'" :status="0"></requests-list-component>
                    </div>
                    <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
                        <requests-list-component :user="'{!! Auth::id() !!}'" :status="1"></requests-list-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop