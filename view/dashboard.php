<?php include './components/head.php';?>
<?php include './components/navbar.php';?>
<?php include './Models/DashboardModel.php';?>

<?php
$dashboardModel = new DashboardModel();


$currentUser = $_SESSION['user'];
$currentUserRole = $currentUser['role'];
$currentUserId = $currentUser['id'];


if ($currentUserRole === 'teacher') {
    $users = $dashboardModel->getAllUsers();
    $allGrades = $dashboardModel->getAllGradesWithDetails();
    $subjects = $dashboardModel->getAllSubjects();
} else {

    $studentGrades = $dashboardModel->getStudentGrades($currentUserId);
}
?>

    <div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    <span class="inline-block pb-2 border-b-4 border-indigo-500">Dashboard</span>
                </h1>
                <p class="mt-2 text-lg text-gray-600">
                    Welcome, <?php echo $currentUser['first_name'] . ' ' . $currentUser['last_name']; ?>
                </p>
            </div>

            <?php if ($currentUserRole === 'teacher'): ?>
                <!-- Teacher View -->
                <div class="mb-8">
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                            <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                                <h2 class="text-xl font-bold text-gray-800">Student Grades Overview</h2>

                                <!-- Subject Filter -->
                                <div class="mt-3 sm:mt-0">
                                    <div class="flex rounded-md shadow-sm">
                                        <label for="subjectFilter" class="sr-only">Filter by Subject</label>
                                        <div class="relative flex-grow focus-within:z-10">
                                            <select id="subjectFilter" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="all">All Subjects</option>
                                                <?php foreach ($subjects as $subject): ?>
                                                    <option value="<?php echo $subject['id']; ?>"><?php echo $subject['subject_name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Users and Grades Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <?php if (!empty($allGrades)): ?>
                                    <?php foreach ($allGrades as $grade): ?>
                                        <tr class="subject-row hover:bg-gray-50" data-subject="<?php echo $grade['subject_id']; ?>">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $grade['first_name'] . ' ' . $grade['last_name']; ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $grade['subject_name']; ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                <?php
                                                if ($grade['grade'] >= 9) echo 'bg-green-100 text-green-800';
                                                elseif ($grade['grade'] >= 7) echo 'bg-blue-100 text-blue-800';
                                                elseif ($grade['grade'] >= 5) echo 'bg-yellow-100 text-yellow-800';
                                                else echo 'bg-red-100 text-red-800';
                                                ?>">
                                                    <?php echo $grade['grade']; ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('M d, Y', strtotime($grade['date'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <h3 class="mt-2 text-sm font-medium text-gray-900">No grades found</h3>
                                                <p class="mt-1 text-sm text-gray-500">No student grades have been recorded yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <!-- Student View -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Grade Cards -->
                    <div class="lg:col-span-2">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-bold text-gray-800">Your Grades</h3>
                            </div>

                            <?php if (!empty($studentGrades)): ?>
                                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <?php foreach ($studentGrades as $grade): ?>
                                        <div class="bg-gray-50 rounded-lg p-4 border-l-4 shadow-sm
                                    <?php
                                        if ($grade['grade'] >= 9) echo 'border-green-500';
                                        elseif ($grade['grade'] >= 7) echo 'border-blue-500';
                                        elseif ($grade['grade'] >= 5) echo 'border-yellow-500';
                                        else echo 'border-red-500';
                                        ?>">
                                            <h4 class="text-lg font-semibold text-gray-800"><?php echo $grade['subject_name']; ?></h4>
                                            <div class="flex justify-between items-center mt-3">
                                                <span class="text-gray-600">Grade:</span>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            <?php
                                                if ($grade['grade'] >= 9) echo 'bg-green-100 text-green-800';
                                                elseif ($grade['grade'] >= 7) echo 'bg-blue-100 text-blue-800';
                                                elseif ($grade['grade'] >= 5) echo 'bg-yellow-100 text-yellow-800';
                                                else echo 'bg-red-100 text-red-800';
                                                ?>">
                                                <?php echo $grade['grade']; ?>
                                            </span>
                                            </div>
                                            <div class="text-gray-500 text-sm mt-2">
                                                Date: <?php echo date('M d, Y', strtotime($grade['date'])); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="p-16 flex justify-center">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No grades yet</h3>
                                        <p class="mt-1 text-sm text-gray-500">You don't have any grades recorded at this time.</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Grade Statistics -->
                    <div class="lg:col-span-1">
                        <?php if (!empty($studentGrades)): ?>
                            <?php
                            $totalGrades = 0;
                            $gradeCount = count($studentGrades);
                            foreach ($studentGrades as $grade) {
                                $totalGrades += $grade['grade'];
                            }
                            $averageGrade = $gradeCount > 0 ? round($totalGrades / $gradeCount, 1) : 0;
                            ?>
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                                    <h3 class="text-lg font-bold text-gray-800">Performance Summary</h3>
                                </div>
                                <div class="p-6">
                                    <!-- Average Grade -->
                                    <div class="text-center mb-6">
                                        <p class="text-sm font-medium text-gray-600">Grade Average</p>
                                        <div class="mt-1 flex justify-center">
                                            <div class="text-5xl font-bold
                                        <?php
                                            if ($averageGrade >= 9) echo 'text-green-600';
                                            elseif ($averageGrade >= 7) echo 'text-blue-600';
                                            elseif ($averageGrade >= 5) echo 'text-yellow-600';
                                            else echo 'text-red-600';
                                            ?>">
                                                <?php echo $averageGrade; ?>
                                            </div>
                                            <div class="ml-2 self-end mb-2 text-sm text-gray-500">/ 10</div>
                                        </div>
                                    </div>

                                    <!-- Number of Grades -->
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm font-medium text-gray-600">Total Subjects</span>
                                            <span class="text-xl font-semibold text-gray-800"><?php echo $gradeCount; ?></span>
                                        </div>
                                    </div>

                                    <!-- Performance Indicator -->
                                    <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm font-medium text-gray-600">Performance</span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        <?php
                                            if ($averageGrade >= 9) echo 'bg-green-100 text-green-800';
                                            elseif ($averageGrade >= 7) echo 'bg-blue-100 text-blue-800';
                                            elseif ($averageGrade >= 5) echo 'bg-yellow-100 text-yellow-800';
                                            else echo 'bg-red-100 text-red-800';
                                            ?>">
                                            <?php
                                            if ($averageGrade >= 9) echo 'Excellent';
                                            elseif ($averageGrade >= 7) echo 'Good';
                                            elseif ($averageGrade >= 5) echo 'Average';
                                            else echo 'Needs Improvement';
                                            ?>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
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