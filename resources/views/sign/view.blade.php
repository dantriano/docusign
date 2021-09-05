@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="container-fluid justify-content-center">

                <input type="hidden" id="userNIF" value="{!! Auth::user()->nif !!}">
                <input type="hidden" id="userID" value="{!! $req->user_id !!}">
                <input type="hidden" id="reqID" value="{!! $req->request_id !!}">
                <input type="hidden" id="fileName" value="{!! $req->file!!}">
                <input type="hidden" id="signedName" value="{!! $req->signedName!!}">
                <input type="hidden" id="requestStatus" value="{!! $req->request_status!!}">
                
                @if($req->requestStatus==1)
                <div class="alert alert-primary">{{ __('messages.already_signed') }}</div>
                <div class="card">
                    <div id="resultContainer" class="card-body">
                        <div class="d-grid gap-2 d-md-flex justify-content-center">
                            <button id="downloadFile" class="btn btn-primary me-md-2 text-white" type="button" download>{{ __('messages.download_signed_file') }} <i class="bi bi-file-earmark-arrow-down"></i></button>
                            <a href="{{ route('requests') }}" class="btn btn-secondary text-white" type="button">{{ __('messages.go_back') }} <i class="bi bi-arrow-90deg-up"></i></a>
                        </div>
                    </div>
                </div>
                @endif
                @if($req->requestStatus==0)
                <ul class="list-group">
                    <li class="list-group-item"><span class="action-list-badge">1</span>{{ __('messages.download_fill') }}<a class="icons-size-big" href="data:application/octet-stream;base64,{{getPDF64($req->file)}}" download="{{$req->file}}"><i class="bi bi-file-earmark-arrow-down"></i></a></li>
                    <li class="list-group-item"><span class="action-list-badge">2</span>{{ __('messages.upload_document') }}
                        <input id="pdf-upload" type="file" />
                    </li>
                    <li class="list-group-item"><span class="action-list-badge">3</span>{{ __('messages.preview_sign') }}
                        <div id="previewContainer" class="row justify-content-center" style="display:none">
                            <!--<canvas class="col-8"></canvas>-->
                            <div style='position: relative; height: 100%;'>
                                <div id="viewerContainer">
                                    <div id="viewer" class="pdfViewer"></div>
                                </div>
                            </div>
                            <button id="pdf-sign" type="button" class="btn btn-primary text-white">{{ __('messages.sign_sand') }}</button>
                        </div>
                    </li>
                    <li class="list-group-item"><span class="action-list-badge">4</span>{{ __('messages.see_result') }}
                        <div id="firmaMsg"></div>
                        <div id="resultContainer">
                            <div class="d-grid gap-2 d-md-flex justify-content-center">
                                <button id="downloadFile" class="btn btn-primary me-md-2 text-white" type="button" disabled download>{{ __('messages.download_signed_file') }} <i class="bi bi-file-earmark-arrow-down"></i></button>
                                <a href="{{ route('requests') }}" class="btn btn-secondary text-white" type="button">{{ __('messages.go_back') }} <i class="bi bi-arrow-90deg-up"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </div>
</div>
<div id="app" class="content"></div>
@stop
@push('scripts')
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/1.8.349/pdf.min.js"></script>-->
<script src="{{ asset('js/miniapplet.js') }}"></script>
<script src="{{ asset('js/PDFsign.js') }}"></script>

@endpush