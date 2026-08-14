<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;

class CvTextExtractor
{
    public function extract(string $path, string $mimeType): string
    {
        return match (true) {
            str_contains($mimeType, 'pdf')  => $this->fromPdf($path),
            str_contains($mimeType, 'word') ||
            str_ends_with($path, '.docx')   => $this->fromDocx($path),
            default                          => file_get_contents($path),
        };
    }

    private function fromPdf(string $path): string
    {
        $parser = new Parser();
        $pdf    = $parser->parseFile($path);
        return $pdf->getText();
    }

    private function fromDocx(string $path): string
    {
        $word  = IOFactory::load($path);
        $text  = '';
        foreach ($word->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $text .= $element->getText() . "\n";
                }
            }
        }
        return $text;
    }
}
