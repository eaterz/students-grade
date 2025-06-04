<?php
// PDF.php

require_once 'libraries/dompdf-3.1.0/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class PDF {
    private $output;

    public function generate($data, $studentInfo = null, $reportNotes = '') {
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);

        // Start building HTML
        $html = $this->generateHtmlHeader();

        // Add student information if provided
        if (!empty($studentInfo)) {
            $html .= $this->generateStudentInfoSection($studentInfo);
        }

        // Add report notes if provided
        if (!empty($reportNotes)) {
            $html .= $this->generateNotesSection($reportNotes);
        }

        // Add grades table
        $html .= $this->generateGradesTable($data);

        // Add summary section
        $html .= $this->generateSummarySection($data);

        // Add footer
        $html .= $this->generateFooter();

        $html .= '</body></html>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $this->output = $dompdf->output();
    }

    private function generateHtmlHeader() {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Studentu Atzīmju Atskaite</title>
            <style>
                body {
                    font-family: DejaVu Sans, sans-serif;
                    margin: 20px;
                    color: #333;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 2px solid #4CAF50;
                    padding-bottom: 15px;
                }
                .header h1 {
                    color: #2E7D32;
                    margin: 0;
                    font-size: 24px;
                }
                .student-info {
                    background-color: #f8f9fa;
                    padding: 15px;
                    border-radius: 5px;
                    margin-bottom: 20px;
                    border-left: 4px solid #4CAF50;
                }
                .notes-section {
                    background-color: #fff3cd;
                    padding: 15px;
                    border-radius: 5px;
                    margin-bottom: 20px;
                    border-left: 4px solid #ffc107;
                }
                .grades-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 30px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                .grades-table th {
                    background-color: #4CAF50;
                    color: white;
                    padding: 12px;
                    text-align: left;
                    font-weight: bold;
                }
                .grades-table td {
                    padding: 10px 12px;
                    border-bottom: 1px solid #ddd;
                }
                .grades-table tr:nth-child(even) {
                    background-color: #f8f9fa;
                }
                .grade-excellent {
                    background-color: #d4edda !important;
                    color: #155724;
                    font-weight: bold;
                }
                .grade-good {
                    background-color: #cce5ff !important;
                    color: #004085;
                }
                .grade-poor {
                    background-color: #f8d7da !important;
                    color: #721c24;
                }
                .summary {
                    background-color: #e3f2fd;
                    padding: 15px;
                    border-radius: 5px;
                    margin-top: 20px;
                    border-left: 4px solid #2196F3;
                }
                .footer {
                    text-align: center;
                    margin-top: 30px;
                    padding-top: 15px;
                    border-top: 1px solid #ddd;
                    font-size: 12px;
                    color: #666;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Studentu Atzīmju Atskaite</h1>
                <p>Ģenerēts: ' . date('Y-m-d H:i:s') . '</p>
            </div>';
    }

    private function generateStudentInfoSection($studentInfo) {
        $html = '<div class="student-info">';
        $html .= '<h3 style="margin-top: 0; color: #2E7D32;">Studenta informācija</h3>';

        if (isset($studentInfo['name'])) {
            $html .= '<p><strong>Vārds:</strong> ' . htmlspecialchars($studentInfo['name']) . '</p>';
        }
        if (isset($studentInfo['student_id'])) {
            $html .= '<p><strong>Studenta ID:</strong> ' . htmlspecialchars($studentInfo['student_id']) . '</p>';
        }
        if (isset($studentInfo['class'])) {
            $html .= '<p><strong>Klase:</strong> ' . htmlspecialchars($studentInfo['class']) . '</p>';
        }

        $html .= '</div>';

        return $html;
    }

    private function generateNotesSection($reportNotes) {
        return '
        <div class="notes-section">
            <h3 style="margin-top: 0; color: #856404;">Piezīmes</h3>
            <p>' . nl2br(htmlspecialchars($reportNotes)) . '</p>
        </div>';
    }

    private function generateGradesTable($data) {
        $html = '<table class="grades-table">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Nr.</th>';
        $html .= '<th>Mācību priekšmets</th>';
        $html .= '<th>Atzīme</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        $counter = 1;
        foreach ($data as $row) {
            $grade = $this->extractValue($row, 'Grade');
            $gradeClass = $this->getGradeClass($grade);

            $html .= '<tr>';
            $html .= '<td>' . $counter . '</td>';
            $html .= '<td>' . htmlspecialchars($this->extractValue($row, 'Subject_name')) . '</td>';
            $html .= '<td class="' . $gradeClass . '">' . htmlspecialchars($grade) . '</td>';
            $html .= '</tr>';

            $counter++;
        }

        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }

    private function generateSummarySection($data) {
        $totalSubjects = count($data);
        $grades = [];
        $gradeSum = 0;

        foreach ($data as $row) {
            $grade = $this->extractValue($row, 'Grade');
            if (is_numeric($grade)) {
                $grades[] = (float)$grade;
                $gradeSum += (float)$grade;
            }
        }

        $averageGrade = !empty($grades) ? round($gradeSum / count($grades), 2) : 0;
        $highestGrade = !empty($grades) ? max($grades) : 0;
        $lowestGrade = !empty($grades) ? min($grades) : 0;

        $html = '<div class="summary">';
        $html .= '<h3 style="margin-top: 0; color: #1976D2;">Kopsavilkums</h3>';
        $html .= '<p><strong>Kopējais priekšmetu skaits:</strong> ' . $totalSubjects . '</p>';
        $html .= '<p><strong>Vidējā atzīme:</strong> ' . $averageGrade . '</p>';
        $html .= '<p><strong>Augstākā atzīme:</strong> ' . $highestGrade . '</p>';
        $html .= '<p><strong>Zemākā atzīme:</strong> ' . $lowestGrade . '</p>';
        $html .= '</div>';

        return $html;
    }

    private function generateFooter() {
        return '
        <div class="footer">
            <p>Šī atskaite tika ģenerēta automātiski ' . date('Y-m-d H:i:s') . '</p>
            <p>Studentu informācijas sistēma</p>
        </div>';
    }

    private function extractValue($row, $key, $default = '') {
        if (is_array($row)) {
            return isset($row[$key]) ? $row[$key] : $default;
        } elseif (is_object($row)) {
            return isset($row->$key) ? $row->$key : $default;
        }
        return $default;
    }

    private function getGradeClass($grade) {
        if (!is_numeric($grade)) {
            return '';
        }

        $numericGrade = (float)$grade;

        if ($numericGrade >= 9) {
            return 'grade-excellent';
        } elseif ($numericGrade >= 7) {
            return 'grade-good';
        } elseif ($numericGrade < 5) {
            return 'grade-poor';
        }

        return '';
    }

    public function output() {
        return $this->output;
    }
}