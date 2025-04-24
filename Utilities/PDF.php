<?php
// PDF.php


require_once 'libraries/dompdf-3.1.0/dompdf/autoload.inc.php';


use Dompdf\Dompdf;

class PDF {
    private $output;

    public function generate($data, $reportNotes = '') {
        $dompdf = new Dompdf();
        $html = '<h1>Produktu atskaite</h1>';

        // Add report notes if provided
        if (!empty($reportNotes)) {
            $html .= '<div style="margin-bottom: 20px; padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd;">';
            $html .= '<strong>Piezimes:</strong><br>';
            $html .= nl2br(htmlspecialchars($reportNotes));
            $html .= '</div>';
        }

        $html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
        $html .= '<tr style="background-color: #eeeeee;">';
        $html .= '<th>ID</th><th>Nosaukums</th><th>Cena</th><th>Piegadatajis</th>';
        $html .= '</tr>';

        foreach ($data as $row) {
            if (is_array($row)) {
                $html .= '<tr>';
                $html .= '<td>' . $row['ID'] . '</td>';
                $html .= '<td>' . $row['PRODUCTNAME'] . '</td>';
                $html .= '<td>' . $row['PRICE'] . '</td>';
                $html .= '<td>' . $row['SUPPLIER'] . '</td>';
                $html .= '</tr>';
            }
            else {
                $html .= '<tr>';
                $html .= '<td>' . $row->id . '</td>';
                $html .= '<td>' . $row->name . '</td>';
                $html .= '<td>' . $row->price . '</td>';
                $html .= '<td>' . $row->supplier . '</td>';
                $html .= '</tr>';
            }
        }

        $html .= '</table>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $this->output = $dompdf->output();
    }

    public function output() {
        return $this->output;
    }
}