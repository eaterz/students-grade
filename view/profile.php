<?php include './components/head.php'; ?>
<?php include './components/navbar.php'; ?>

    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-3xl mx-auto px-4">
            <!-- Status Messages -->
            <?php if (isset($_GET['success'])): ?>
                <div class="mb-4 p-3 rounded bg-green-50 text-green-800 border border-green-200">
                    <?php echo $_GET['success']; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="mb-4 p-3 rounded bg-red-50 text-red-800 border border-red-200">
                    <?php echo $_GET['error']; ?>
                </div>
            <?php endif; ?>

            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row items-center">
                        <!-- Profile Image and Upload -->
                        <div class="mb-4 sm:mb-0 sm:mr-6">
                            <div class="relative">
                                <div class="h-24 w-24 rounded-full overflow-hidden bg-gray-100 border-2 border-gray-200">
                                    <?php if (!empty($userDetails['profile_image'])): ?>
                                        <img src="<?php echo $userDetails['profile_image']; ?>" alt="Profile" class="h-full w-full object-cover">
                                    <?php else: ?>
                                        <div class="h-full w-full flex items-center justify-center bg-gray-200 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <form action="/profile/updateImage" method="POST" enctype="multipart/form-data" class="mt-2">
                                    <label for="profile-upload" class="cursor-pointer block text-center text-xs text-blue-600 hover:text-blue-800">
                                        Change Image
                                        <input type="file" id="profile-upload" name="profile_image" class="hidden" onchange="this.form.submit()">
                                    </label>
                                </form>
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="text-center sm:text-left">
                            <h1 class="text-2xl font-bold text-gray-800">
                                <?php echo $userDetails['first_name'] . ' ' . $userDetails['last_name']; ?>
                            </h1>
                            <p class="text-blue-600 font-medium">
                                <?php echo ucfirst($userDetails['role']); ?>
                            </p>
                            <div class="mt-1 text-gray-500">
                                Personal Code: <?php echo $userDetails['personal_code']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php include './components/footer.php'; ?>