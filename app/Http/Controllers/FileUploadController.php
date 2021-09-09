<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{

    public function fileUpload(Request $req, $id = 'file')
    {
        $doc_folder = 'documents';
        $req->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:5048'
        ]);

        if ($req->file()) {
            $file_name = $req->file->getClientOriginalName();
            $file_path = $req->file($id)->store($doc_folder);

            return json_encode(array(
                'success' => 'File has been uploaded.',
                'file_name' => $file_name,
                'file_path' => $file_path
            ));
        }
    }
}
