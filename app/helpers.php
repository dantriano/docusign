<?php
if (!function_exists('getPDF64')) {
    function getPDF64($name, $sub = '')
    {
        $path = docs_path($sub . $name);
        $b64Doc = chunk_split(base64_encode(file_get_contents($path)));
        return $b64Doc;
    }
}
if (!function_exists('setPDF64')) {
    function setPDF64($b64, $name, $sub = '')
    {
        $path = docs_path($sub . $name);
        $pdf_decoded = base64_decode($b64);
        $pdf = fopen($path, 'w');
        fwrite($pdf, $pdf_decoded);
        //close output file
        fclose($pdf);
        return true;
    }
}
if (!function_exists('docs_path')) {
    function docs_path($name, $sub = '')
    {
        return public_path('documents/' . $sub . $name);
    }
}
