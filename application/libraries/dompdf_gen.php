<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class Dompdf_gen
{
    public $dompdf;

    public function __construct()
    {
        // Check if Dompdf is loaded properly
        if (!class_exists(Dompdf::class)) {
            throw new Exception("Dompdf is not installed or autoloaded. Please install Dompdf via Composer.");
        }

        // Configure Dompdf options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Initialize Dompdf
        $this->dompdf = new Dompdf($options);

        // Make the Dompdf instance available globally in CodeIgniter
        $CI = &get_instance();
        $CI->dompdf = $this->dompdf;
    }
}
