<?php

namespace App\Http\Controllers;

use mikehaertl\pdftk\Pdf;
use App\Http\Controllers\PdfForm;
use Wbrframe\PdfToHtml\Converter\ConverterFactory;
use Wbrframe\PdfToHtml\Converter\PopplerUtils\PdfToHtmlOptions;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
    }
    public function convertToJson($logFile)
    {
        $lines = file($logFile, FILE_IGNORE_NEW_LINES);

        $data = array();
        $pattern = '@INFO:root:(\d{2}/\d{2}/\d{4}\s\d{2}:\d{2}:\d{2}):\sTemp:\s(.+)\sHumidity:\s(.+)@';
        foreach ($lines as $line) {
            if (preg_match($pattern, $line, $matches)) {
                $data[] = array(
                    'date' => $matches[1],
                    'temp' => $matches[2],
                    'humidity' => $matches[3],
                );
            }
        }
    }
    public function ej()
    {
        $origin = public_path('documents/junta.pdf');
        $destiny = public_path('documents/junta_.pdf');
        $this->toHTML();
        exec("pdftk " . $origin . " output " . $destiny . " ");
        return;

        //java -jar build/jar/pdftk.jar

        // Fill form with data array
        $pdf = new Pdf($origin);
        //$data = $pdf->getDataFields();
        //var_dump($data);
        $pdf->send();
        return;
        exit;
        $result = $pdf->fillForm([
            'name' => 'ÄÜÖ äüö мирано čárka',
            'nested.name' => 'valX',
        ])
            ->needAppearances()
            ->saveAs($destiny);

        // Always check for errors
        if ($result === false) {
            $error = $pdf->getError();
            var_dump($error);
        }

        // Fill form from FDF
        /*$pdf = new Pdf('form.pdf');
        $result = $pdf->fillForm('data.xfdf')
            ->saveAs('filled.pdf');
        if ($result === false) {
            $error = $pdf->getError();
        }*/
    }
    public function toHTML()
    {
        $origin = public_path('documents/junta.pdf');
        $destiny = public_path('documents/junta.html');

        $converterFactory = new ConverterFactory($origin);
        $options = (new PdfToHtmlOptions())->setOutputFilePath($destiny);
        $converter = $converterFactory->createPdfToHtml($options);

        $html = $converter->createHtml();

        // Get absolute path created HTML file
        $htmlFilePath = $html->getFilePath();
        echo $htmlFilePath;
    }
    public function dos()
    {

        $origin = public_path('documents/junta.pdf');
        $destiny = public_path('documents/junta_.pdf');

        $data = [
            'Cognoms i nom' => 'John',
            'DNI, NIE o passaport'  => 'Smith',
            'especialitat' => 'Teacher',
            'Any'        => '45',
            'Cos'     => 'male'
        ];
        $pdf = new pdfForm($origin, $data);

        $pdf->flatten()->save($destiny)->download();
    }
    public function first()
    {
        $origin = public_path('documents/junta.pdf');
        $destiny = public_path('documents/junta_.pdf');
        // Form data:
        $fname      = 'John';
        $lname      = 'Smith';
        $occupation = 'Teacher';
        $age        = '45';
        $gender     = 'male';

        // FDF header section
        $fdf_header = <<<FDF
%FDF-1.2
%,,oe"
1 0 obj
<<
/FDF << /Fields [
FDF;

        // FDF footer section
        $fdf_footer = <<<FDF
"] >> >>
endobj
trailer
<</Root 1 0 R>>
%%EOF;
FDF;

        // FDF content section
        $fdf_content  = "<</T(Cognoms i nom)/V({$fname})>>";
        $fdf_content .= "<</T(DNI, NIE o passaport)/V({$lname})>>";
        $fdf_content .= "<</T(especialitat)/V({$occupation})>>";
        $fdf_content .= "<</T(any)/V({$age})>>";
        $fdf_content .= "<</T(cos)/V({$gender})>>";

        $content = $fdf_header . $fdf_content . $fdf_footer;

        // Creating a temporary file for our FDF file.
        $FDFfile = public_path('documents/fdf.fdf');
        file_put_contents($FDFfile, $content);

        // Merging the FDF file with the raw PDF form
        exec("pdftk " . $origin . " fill_form $FDFfile " . $destiny);
        //exec("pdftk form.pdf fill_form $FDFfile output.pdf"); 

        // Removing the FDF file as we don't need it anymore
        //unlink($FDFfile);
    }
}
