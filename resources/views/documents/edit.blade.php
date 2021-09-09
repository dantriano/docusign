@extends('layouts.app')

@section('content')
<div id="app" class="content ">
    <document-edit-component :id="{{json_encode($id)}}" :lang="{{json_encode(Lang::get('messages'))}}"></document-edit-component>
</div>
@stop