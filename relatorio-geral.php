<?php

require_once "classes/fpdf181/fpdf.php";
require __DIR__ . './vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

// This assumes that you have placed the Firebase credentials in the same directory
// as this PHP file.
$serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . './secret/appta-luizabarcelos-24de935ad1a9.json');

$firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        // The following line is optional if the project id in your credentials file
        // is identical to the subdomain of your Firebase project. If you need it,
        // make sure to replace the URL with the URL of your project.
        ->withDatabaseUri('https://appta-luizabarcelos.firebaseio.com')
        ->create();

$database = $firebase->getDatabase();
$values = $database->getReference()->getChild('almoco')->getValue();

$pdf = new FPDF("P");
$pdf->AddPage();
$arquivo = "relatorio-geral.pdf";
$fonte = "Arial";
$estilo = "B";
$border = 1;
$alinhamentoL = "L";
$alinhamentoC = "C";
$tipo_pdf = "I";

foreach ($values as $rstMn) {
    foreach ($rstMn as $indice => $valor) {

        $pdf->SetY("10");
        $nm = 0;

        $totalArtigo = count(($valor));

        $pdf->SetFont($fonte, $estilo, 15);
        $pdf->Cell(190, 10, $rstMn[$indice]['name'], $border, 3, $alinhamentoC);

        if ($totalArtigo != 0) {

            $pdf->SetFont($fonte, $estilo, 8);
            $pdf->Cell(63.3, 7, 'NOME ', 'L, B', -1, $alinhamentoC);

            $pdf->SetFont($fonte, $estilo, 8);
            $pdf->Cell(63.3, 7, 'DATA', 'L, R, B', 0, $alinhamentoC);

            $pdf->SetFont($fonte, $estilo, 8);
            $pdf->Cell(63.3, 7, 'HORA', 'L, R, B', 1, $alinhamentoC);

            foreach ($rstMn as $rstAt) {
                $nm = $nm + 1;
                if ($totalArtigo == $nm) {
                    $pdf->SetFont($fonte, '', 7);
                    $pdf->Cell(63.3, 5, $rstAt['name'], 'L, B', -1, $alinhamentoL);

                    $pdf->SetFont($fonte, '', 7);
                    $pdf->Cell(63.3, 5, $rstAt['date'], 'L, R, B', 0, $alinhamentoL);

                    $pdf->SetFont($fonte, '', 7);
                    $pdf->Cell(63.3, 5, $rstAt['time'], 'L, R, B', 1, $alinhamentoL);
                } else {
                    $pdf->SetFont($fonte, '', 7);
                    $pdf->Cell(63.3, 5, $rstAt['name'], 'L, R, B', -1, $alinhamentoL);

                    $pdf->SetFont($fonte, '', 7);
                    $pdf->Cell(63.3, 5, $rstAt['date'], 'L, R, B', 0, $alinhamentoL);

                    $pdf->SetFont($fonte, '', 7);
                    $pdf->Cell(63.3, 5, $rstAt['time'], 'L, R, B', 1, $alinhamentoL);
                }
            }
        } else {
            $pdf->SetFont($fonte, '', 7);
            $pdf->Cell(190, 8, $objFc->tratarCaracter('Não tem vídeo aula', 1), 'L, R, B', 1, $alinhamentoC);
        }
        $pdf->AddPage();
    }
}
$pdf->Output($arquivo, $tipo_pdf);
