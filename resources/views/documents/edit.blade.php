@extends('layouts.app')

@section('content')
<div id="app" class="content ">
    <document-edit-component  :edit="'{!! $id !!}'"></document-edit-component>
</div>
@stop