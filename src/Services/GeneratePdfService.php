<?php

namespace App\Services;
use Spipu\Html2Pdf\Html2Pdf;

class GeneratePdfService
{
    public function Pdf($filename, $template){

        try{
            $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8');
            $html2pdf->writeHTML($template);
            $path = $filename;
            $html2pdf->output($path,'F');
        }catch (HTML2PDF_exception $e){
            die($e);
        }
    
    }
    

}
