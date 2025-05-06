<?php include './components/head.php';?>
<?php include './components/navbar.php';?>


<?php
$students = new StudentsModel();
$student = $students->getUserById($_GET['id']);

?>
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Page Header -->
            <div class="mb-6">
                <div class="flex items-center">
                    <a href="/students" class="mr-2 text-indigo-600 hover:text-indigo-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <h1 class="text-3xl font-extrabold text-gray-900">Edit Student</h1>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="bg-white shadow-md rounded-lg">
                <form action="/students/edit?id=<?php echo $student['id']; ?>" method="POST" class="p-6">
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="personal_code" class="block text-sm  font-medium text-gray-700">Personal Code</label>
                            <input type="text" name="personal_code" id="personal_code"
                                   value="<?php echo htmlspecialchars($student['personal_code'] ?? ''); ?>"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm bg-gray-100 rounded-md">
                        </div>

                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" name="first_name" id="first_name"
                                   value="<?php echo htmlspecialchars($student['first_name'] ?? ''); ?>"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm bg-gray-100 rounded-md">
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" name="last_name" id="last_name"
                                   value="<?php echo htmlspecialchars($student['last_name'] ?? ''); ?>"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm bg-gray-100 rounded-md">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="/students" class="mr-3 px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include './components/footer.php';?>