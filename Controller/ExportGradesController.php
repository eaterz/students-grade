<?php

include "Utilities/PDF.php";
include "Models/DashboardModel.php";
class ExportGradesController
{

    public function generateReport() {
        $studentId = isset($_POST['student_id']) ? $_POST['student_id'] : [];



        $dashboardModel = new DashboardModel();
        $results = $dashboardModel->getStudentGrades($studentId);

        if (empty($results)) {
            echo "nav atrastas atzīmes"; exit;
        }

        $reportData = [];
        foreach ($results as $grade) {
            $reportData[] = [
                'Subject_name' => $grade['subject_name'],
                'Grade' => $grade['grade'],
            ];
        }
        $pdf = new PDF();

        $pdf->generate($reportData);

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="grades_' . date('Y-m-d') . '.pdf"');
        header('Cache-Control: max-age=0');

        echo $pdf->output();
        exit;
    }
}