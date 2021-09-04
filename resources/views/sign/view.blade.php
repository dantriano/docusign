@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="container-fluid justify-content-center">
                <ul class="list-group">
                    <li><input class="botonP marginR15" type="button" id="botonFirmar" value="Firmar" onclick="javascript:firmar();" />
                        <input class="botonM marginR15" type="button" id="saveFile" value="Guardar Firma" onclick="javascript:guardarFirma();" disabled="disabled" /><br />
                        <div id="divmensaje">&nbsp;</div>
                    </li>
                    <li class="list-group-item"><span class="action-list-badge">1</span>Download the file<span class="badge">35</span></li>
                    <li class="list-group-item"><span class="action-list-badge">2</span>Fill the form and upload the new file here
                        <input id="pdf-upload" type="file" />
                    </li>
                    <li class="list-group-item"><span class="action-list-badge">3</span>Preview and Sign
                        <div class="row justify-content-center">
                            <button id="pdf-sign" type="button" class="btn btn-primary  text-white">Sign</button>
                            <canvas class="col-8"></canvas>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="app" class="content"></div>
@stop
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/1.8.349/pdf.min.js"></script>
<script src="{{ asset('js/pdf_preview.js') }}"></script>
<script src="{{ asset('js/miniapplet.js') }}"></script>
<script src="{{ asset('js/autofirma.js') }}"></script>
@endpush