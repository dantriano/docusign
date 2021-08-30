@extends('layouts.app')

@section('content')
<div id="app" class="content ">
    <document-view-component  :edit="'{!! $id !!}'"></document-view-component>
</div>
@stop