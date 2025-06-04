<?php include './components/head.php';?>
<?php include './components/navbar.php';?>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Create New Student</h1>
                <a href="/students" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Students List
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="mb-4 rounded-md bg-red-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800"><?php echo $_GET['error']; ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/students/create/store">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <!-- Personal Code -->
                            <div class="sm:col-span-3">
                                <label for="personal_code" class="block text-sm font-medium text-gray-700">Personal Code</label>
                                <div class="mt-1">
                                    <input type="text" name="personal_code" id="personal_code" maxlength="12" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm bg-gray-100 rounded-md">
                                </div>
                            </div>

                            <!-- First Name -->
                            <div class="sm:col-span-3">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                <div class="mt-1">
                                    <input type="text" name="first_name" id="first_name" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm bg-gray-100 rounded-md">
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="sm:col-span-3">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                <div class="mt-1">
                                    <input type="text" name="last_name" id="last_name" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm  bg-gray-100 rounded-md">
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="sm:col-span-3">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <div class="mt-1">
                                    <input type="password" name="password" id="password" required
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm  bg-gray-100 rounded-md">
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="sm:col-span-3">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <div class="mt-1">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm  bg-gray-100 rounded-md">
                                </div>
                            </div>

                            <!-- Role - Hidden field since we're creating a student -->
                            <input type="hidden" name="role" value="student">
                        </div>

                        <div class="mt-8 flex justify-end">
                            <a href="/students" class="mr-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-white bg-red-600  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const personalCodeInput = document.getElementById('personal_code');

        personalCodeInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/[^0-9]/g, ''); // remove non-digits
            if (value.length > 6) {
                value = value.slice(0, 6) + '-' + value.slice(6);
            }
            e.target.value = value;
        });
    </script>

<?php include './components/footer.php';?>