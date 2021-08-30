@extends('layouts.app')

@section('content')
<div id="app" class="content ">
    <document-requests-component  :edit="'{!! $id !!}'"></document-requests-component>
</div>
@stop