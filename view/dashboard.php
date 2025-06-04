<?php

include './components/head.php';
include './components/navbar.php';

// Initialize model and get user data
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

                                <!-- Filters Area -->
                                <div class="mt-3 sm:mt-0 flex space-x-3">
                                    <!-- Name Filter -->
                                    <div class="relative flex-grow focus-within:z-10">
                                        <input type="text" id="nameFilter" placeholder="Filter by name..."
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-black">
                                    </div>

                                    <!-- Subject Filter -->
                                    <div class="relative flex-grow focus-within:z-10">
                                        <select id="subjectFilter" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-black">
                                            <option value="all">All Subjects</option>
                                            <?php foreach ($subjects as $subject): ?>
                                                <option value="<?php echo $subject['id']; ?>" class="text-black"><?php echo $subject['subject_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Sort Order Dropdown -->
                                    <div class="relative flex-grow focus-within:z-10">
                                        <select id="sortOrder" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-black">
                                            <option value="name_asc">Name (A-Z)</option>
                                            <option value="name_desc">Name (Z-A)</option>
                                            <option value="grade_asc">Grade (Low-High)</option>
                                            <option value="grade_desc">Grade (High-Low)</option>
                                        </select>
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
                                <tbody class="bg-white divide-y divide-gray-200" id="gradesTableBody">
                                <?php if (!empty($allGrades)): ?>
                                    <?php foreach ($allGrades as $grade): ?>
                                        <tr class="grade-row hover:bg-gray-50"
                                            data-subject="<?php echo $grade['subject_id']; ?>"
                                            data-student-name="<?php echo strtolower($grade['first_name'] . ' ' . $grade['last_name']); ?>"
                                            data-grade="<?php echo $grade['grade']; ?>"
                                            data-grade-id="<?php echo $grade['id']; ?>">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $grade['first_name'] . ' ' . $grade['last_name']; ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $grade['subject_name']; ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mr-2
                                                    <?php
                                                    if ($grade['grade'] >= 9) echo 'bg-green-100 text-green-800';
                                                    elseif ($grade['grade'] >= 7) echo 'bg-blue-100 text-blue-800';
                                                    elseif ($grade['grade'] >= 5) echo 'bg-yellow-100 text-yellow-800';
                                                    else echo 'bg-red-100 text-red-800';
                                                    ?>">
                                                        <?php echo $grade['grade']; ?>
                                                    </span>
                                                <a href="/grades/edit?id=<?php echo $grade['id']; ?>" class="text-indigo-600 hover:text-indigo-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('M d, Y', strtotime($grade['date'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr id="noGradesRow">
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

                <!-- Student Grades Export -->
                <?php if (!empty($studentGrades)): ?>
                    <div class="mt-8">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="text-lg font-bold text-gray-800">Export Your Grades</h3>
                                </div>
                            </div>

                            <form action="/grades/export" method="POST" class="p-6">
                                <!-- Hidden input to include all student grades -->
                                <input type="hidden" name="student_id" value="<?php echo $currentUserId; ?>">

                                <div class="mb-6">
                                    <p class="text-gray-600 mb-4">Download a PDF file containing all your grades and academic summary.</p>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="font-medium text-gray-700">Total Subjects:</span>
                                                <span class="text-gray-900"><?php echo count($studentGrades); ?></span>
                                            </div>
                                            <div>
                                                <span class="font-medium text-gray-700">Average Grade:</span>
                                                <span class="font-bold
                                                <?php
                                                if ($averageGrade >= 9) echo 'text-green-600';
                                                elseif ($averageGrade >= 7) echo 'text-blue-600';
                                                elseif ($averageGrade >= 5) echo 'text-yellow-600';
                                                else echo 'text-red-600';
                                                ?>">
                                                <?php echo $averageGrade; ?>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button
                                            type="submit"
                                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Export Grades to PDF
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>


<?php if ($currentUserRole === 'teacher'): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameFilter = document.getElementById('nameFilter');
            const subjectFilter = document.getElementById('subjectFilter');
            const sortOrder = document.getElementById('sortOrder');
            const rows = document.querySelectorAll('.grade-row');
            const noGradesRow = document.getElementById('noGradesRow');

            function applyFilters() {
                const nameValue = nameFilter ? nameFilter.value.toLowerCase() : '';
                const subjectValue = subjectFilter ? subjectFilter.value : 'all';
                const sortValue = sortOrder ? sortOrder.value : 'name_asc';

                let visibleRows = [];

                rows.forEach(row => {
                    const studentName = row.dataset.studentName;
                    const subjectId = row.dataset.subject;

                    const nameMatch = studentName.includes(nameValue);
                    const subjectMatch = subjectValue === 'all' || subjectId === subjectValue;

                    if (nameMatch && subjectMatch) {
                        row.style.display = '';
                        visibleRows.push(row);
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (visibleRows.length === 0 && noGradesRow) {
                    noGradesRow.style.display = '';
                } else if (noGradesRow) {
                    noGradesRow.style.display = 'none';
                }

                sortRows(visibleRows, sortValue);
            }

            function sortRows(rows, sortType) {
                const tbody = document.getElementById('gradesTableBody');

                rows.sort((a, b) => {
                    switch(sortType) {
                        case 'name_asc':
                            return a.dataset.studentName.localeCompare(b.dataset.studentName);
                        case 'name_desc':
                            return b.dataset.studentName.localeCompare(a.dataset.studentName);
                        case 'grade_asc':
                            return parseFloat(a.dataset.grade) - parseFloat(b.dataset.grade);
                        case 'grade_desc':
                            return parseFloat(b.dataset.grade) - parseFloat(a.dataset.grade);
                        default:
                            return 0;
                    }
                });

                rows.forEach(row => {
                    tbody.appendChild(row);
                });
            }

            if (nameFilter) {
                nameFilter.addEventListener('input', applyFilters);
            }

            if (subjectFilter) {
                subjectFilter.addEventListener('change', applyFilters);
            }

            if (sortOrder) {
                sortOrder.addEventListener('change', applyFilters);
            }
        });
    </script>
<?php endif; ?>



<?php include './components/footer.php'; ?>