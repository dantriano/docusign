@extends('layouts.app')
@section('content')
<div id="app" class="content "></div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="max-width: 30rem">
        @if(session()->has('flash'))
        <div class="alert alert-info">{{session('flash')}}
        </div>
        @endif
            <div class="card">
                <div class="card-body">
                    <div class="login-box">
                        <h1 style="text-align: center">Welcome to Docusign</h1>
                        <div class="row justify-content-center">
                            <div class="col-xs-12">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input name="email" type="email" class="form-control  @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="Enter email" />
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-xs-12" style="text-align: center">
                                        <label id="j_idt22" class="ui-outputlabel ui-widget" style="padding-bottom: 20px">Acceder con</label><img src="/img/logo-clave.png" width="130" class="margin" />
                                        <input type="submit" value="CL@VE" class="btn btn-block" style=" width: 60%; display: inline;color: white;background-color: #3c8dbc;" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop