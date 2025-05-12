<?php include './components/head.php'; ?>
<?php include './components/navbar.php'; ?>

<section class="min-h-screen bg-gradient-to-b from-gray-100 to-gray-200 py-12 flex items-center justify-center">
    <div class="w-full max-w-md mx-auto">
        <!-- Login Card -->
        <div class="bg-blue-600 rounded-xl shadow-xl overflow-hidden">
            <!-- Header with decoration -->
            <div class="relative bg-blue-600 pt-8 ">
                
                <div class="px-8 relative z-10">
                    <div class="mx-auto w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h1 class="mt-4 text-center text-2xl font-bold text-white pb-">Sign In</h1>
                </div>
            </div>

            <!-- Form -->
            <div class="px-8 py-6">
                <form action="/login/process" method="POST" class="space-y-6">
                    <!-- Personal Code Input -->
                    <div class="space-y-2">
                        <label for="personal_code" class="block text-sm font-medium text-white">
                            Personal Code
                        </label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                </svg>
                            </div>
                            <input type="text" id="personal_code" name="personal_code" placeholder="e.g. 123456-12345" maxlength="12" required
                                   class="pl-10 block w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm shadow-sm bg-white text-black placeholder-black"
                            />
                        </div>
                        <p class="mt-1 text-xs text-white">Format: 6 digits, dash, 5 digits</p>
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-white">
                            Password
                        </label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" placeholder="••••••••" required
                                   class="pl-10 block w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm shadow-sm bg-white placeholder-black" 
                            />
                        </div>
                    </div>

                    <!-- Error Messages -->
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="bg-red-50 border-l-4 border-red-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <?php foreach ($errors as $error): ?>
                                        <p class="text-sm text-red-600"><?php echo $error; ?></p>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-blue-600 bg-white  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Sign In
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

<?php include './components/footer.php'; ?>



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