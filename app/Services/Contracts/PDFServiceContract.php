<?php

namespace App\Services\Contracts;

use Barryvdh\DomPDF\PDF;

interface PDFServiceContract
{
    public function generate(string $view, array $data) : PDF;
}
