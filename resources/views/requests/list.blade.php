@extends('layouts.app')

@section('content')
<div id="app" class="content ">
    <requests-list-component  :user="'{!! Auth::id() !!}'"></requests-list-component>
</div>
@stop