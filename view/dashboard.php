<?php include './components/head.php';?>
<?php include './components/navbar.php';?>
<?php include './Models/DashboardModel.php';?>

<?php
$dashboardModel = new DashboardModel();

// Get user data from the existing session
$currentUser = $_SESSION['user'];
$currentUserRole = $currentUser['role'];
$currentUserId = $currentUser['id'];

// Load data based on user role
if ($currentUserRole === 'teacher') {
    $users = $dashboardModel->getAllUsers(); // Changed from getAllStudents
    $allGrades = $dashboardModel->getAllGradesWithDetails();
    $subjects = $dashboardModel->getAllSubjects(); // For filtering
} else {
    // Student view
    $studentGrades = $dashboardModel->getStudentGrades($currentUserId);
}
?>

    <div class="container mx-auto px-4 py-8 bg-gray-900 min-h-screen">
        <h1 class="text-4xl text-center font-bold mb-8 text-gray-100">
            <span class="border-b-4 border-blue-500 pb-2">Dashboard</span>
        </h1>

        <?php if ($currentUserRole === 'teacher'): ?>
            <!-- Teacher View -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-100 mb-4">Student Grades Overview</h2>

                <!-- Subject Filter -->
                <div class="mb-6">
                    <label for="subjectFilter" class="block text-gray-300 mb-2">Filter by Subject:</label>
                    <select id="subjectFilter" class="bg-gray-700 text-white rounded px-4 py-2 w-full md:w-64">
                        <option value="all">All Subjects</option>
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?php echo $subject['id']; ?>"><?php echo $subject['subject_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Users and Grades Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-700 rounded-lg overflow-hidden">
                        <thead class="bg-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left text-gray-200">Student Name</th>
                            <th class="px-4 py-3 text-left text-gray-200">Subject</th>
                            <th class="px-4 py-3 text-left text-gray-200">Grade</th>
                            <th class="px-4 py-3 text-left text-gray-200">Date</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-600">
                        <?php if (!empty($allGrades)): ?>
                            <?php foreach ($allGrades as $grade): ?>
                                <tr class="subject-row" data-subject="<?php echo $grade['subject_id']; ?>">
                                    <td class="px-4 py-3 text-gray-200"><?php echo $grade['first_name'] . ' ' . $grade['last_name']; ?></td>
                                    <td class="px-4 py-3 text-gray-200"><?php echo $grade['subject_name']; ?></td>
                                    <td class="px-4 py-3 text-gray-200">
                                        <span class="inline-block rounded px-2 py-1
                                            <?php
                                        if ($grade['grade'] >= 9) echo 'bg-green-600';
                                        elseif ($grade['grade'] >= 7) echo 'bg-blue-600';
                                        elseif ($grade['grade'] >= 5) echo 'bg-yellow-600';
                                        else echo 'bg-red-600';
                                        ?>">
                                            <?php echo $grade['grade']; ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-200"><?php echo date('M d, Y', strtotime($grade['date'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-gray-400">No grades found</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php else: ?>
            <!-- Student View -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-100 mb-6">
                    Welcome, <?php echo $currentUser['first_name'] . ' ' . $currentUser['last_name']; ?>
                </h2>

                <div class="bg-gray-700 rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-100 mb-4">Your Grades</h3>

                    <?php if (!empty($studentGrades)): ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php foreach ($studentGrades as $grade): ?>
                                <div class="bg-gray-800 rounded-lg p-4 border-l-4
                                <?php
                                if ($grade['grade'] >= 9) echo 'border-green-500';
                                elseif ($grade['grade'] >= 7) echo 'border-blue-500';
                                elseif ($grade['grade'] >= 5) echo 'border-yellow-500';
                                else echo 'border-red-500';
                                ?>">
                                    <h4 class="text-lg font-semibold text-gray-100"><?php echo $grade['subject_name']; ?></h4>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-gray-300">Grade:</span>
                                        <span class="inline-block rounded px-3 py-1 text-white font-bold
                                        <?php
                                        if ($grade['grade'] >= 9) echo 'bg-green-600';
                                        elseif ($grade['grade'] >= 7) echo 'bg-blue-600';
                                        elseif ($grade['grade'] >= 5) echo 'bg-yellow-600';
                                        else echo 'bg-red-600';
                                        ?>">
                                        <?php echo $grade['grade']; ?>
                                    </span>
                                    </div>
                                    <div class="text-gray-400 text-sm mt-2">
                                        Date: <?php echo date('M d, Y', strtotime($grade['date'])); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Grade Average -->
                        <?php
                        $totalGrades = 0;
                        $gradeCount = count($studentGrades);
                        foreach ($studentGrades as $grade) {
                            $totalGrades += $grade['grade'];
                        }
                        $averageGrade = $gradeCount > 0 ? round($totalGrades / $gradeCount, 1) : 0;
                        ?>
                        <div class="mt-6 bg-gray-800 rounded-lg p-4">
                            <h4 class="text-lg font-semibold text-gray-100">Grade Average</h4>
                            <div class="flex items-center mt-2">
                                <div class="text-2xl font-bold
                                <?php
                                if ($averageGrade >= 9) echo 'text-green-500';
                                elseif ($averageGrade >= 7) echo 'text-blue-500';
                                elseif ($averageGrade >= 5) echo 'text-yellow-500';
                                else echo 'text-red-500';
                                ?>">
                                    <?php echo $averageGrade; ?>
                                </div>
                                <div class="ml-2 text-gray-400">out of 10</div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="bg-gray-800 rounded-lg p-4 text-gray-400">
                            You don't have any grades yet.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- JavaScript for Subject Filtering -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subjectFilter = document.getElementById('subjectFilter');
            if (subjectFilter) {
                subjectFilter.addEventListener('change', function() {
                    const selectedSubject = this.value;
                    const rows = document.querySelectorAll('.subject-row');

                    rows.forEach(row => {
                        if (selectedSubject === 'all' || row.dataset.subject === selectedSubject) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>

<?php include './components/footer.php';?>