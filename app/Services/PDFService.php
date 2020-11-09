<?php

namespace App\Services;

use PDF;
use Barryvdh\DomPDF\PDF as DomPDF;
use App\Services\Contracts\PDFServiceContract;

class PDFService implements PDFServiceContract
{
    public function generate(string $view, array $data) : DomPDF
    {
        return PDF::loadView($view, $data);
    }
}
