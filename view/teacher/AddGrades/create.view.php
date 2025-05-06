<?php include './components/head.php';?>
<?php include './components/navbar.php';?>

<?php
$GradesModel = new GradesModel();
$students = $GradesModel->getAllStudents();
$subjects = $GradesModel->getAllSubjects();
?>

    <div class="bg-gradient-to-b from-indigo-50 to-white min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page header -->
            <div class="pb-5 border-b border-gray-200 mb-8">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-2">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900">Add New Grade</h1>
                        <p class="text-sm text-gray-500 mt-1">Record a new grade for a student</p>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-8">
                    <form action="/grades/add" method="POST" class="space-y-6">

                        <!-- Student Selection -->
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                            <div class="relative">
                                <select id="student_id" name="student_id" required
                                        class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Student</option>
                                    <?php foreach ($students as $student): ?>
                                        <option value="<?php echo $student['id']; ?>">
                                            <?php echo $student['first_name'] . ' ' . $student['last_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Subject Selection -->
                        <div>
                            <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <div class="relative">
                                <select id="subject_id" name="subject_id" required
                                        class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Subject</option>
                                    <?php foreach ($subjects as $subject): ?>
                                        <option value="<?php echo $subject['id']; ?>">
                                            <?php echo $subject['subject_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>

                        <!-- Grade Slider with Number Display -->
                        <div>
                            <label for="grade" class="block text-sm font-medium text-gray-700 mb-3">Grade (1-10)</label>
                            <div class="flex items-center space-x-6">
                                <div class="w-full">
                                    <input type="range" min="1" max="10" step="1" id="grade_slider"
                                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                           oninput="updateGradeValue(this.value)">
                                    <div class="flex justify-between text-xs text-gray-600 px-1 mt-2">
                                        <span>1</span>
                                        <span>2</span>
                                        <span>3</span>
                                        <span>4</span>
                                        <span>5</span>
                                        <span>6</span>
                                        <span>7</span>
                                        <span>8</span>
                                        <span>9</span>
                                        <span>10</span>
                                    </div>
                                </div>
                                <div class="relative">
                                    <input type="number" id="grade" name="grade" min="1" max="10" value="7" required
                                           class="w-16 h-16 text-center text-2xl font-bold text-indigo-600 rounded-md shadow-sm focus:ring-indigo-500 focus:outline-none border-none">
                                    <div class="absolute left-0 right-0 -top-6 text-xs text-gray-600 text-center">Selected Grade</div>
                                </div>

                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-3">
                            <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Grade
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize the slider and grade value
        document.addEventListener('DOMContentLoaded', function() {
            const gradeInput = document.getElementById('grade');
            const gradeSlider = document.getElementById('grade_slider');

            // Set initial values
            gradeSlider.value = gradeInput.value;

            // Sync slider to input
            gradeInput.addEventListener('input', function() {
                if (this.value > 10) this.value = 10;
                if (this.value < 1) this.value = 1;
                gradeSlider.value = this.value;
            });
        });

        function updateGradeValue(value) {
            document.getElementById('grade').value = value;
        }
    </script>

<?php include './components/footer.php';?>