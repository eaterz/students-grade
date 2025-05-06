<?php include "./components/head.php" ?>

<!-- Modern navbar with better styling and responsive design -->
<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo/Brand -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/dashboard" class="flex items-center">
                    <svg class="h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-900">Student Portal</span>
                </a>
            </div>


            <!-- Navigation Links -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <div class="flex space-x-4">
                    <?php
                    if (Validator::Role('student')) {
                        ?>
                        <a href="/dashboard" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">Dashboard</a>
                        <a href="/logout" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:bg-red-50 hover:text-red-700 transition-colors duration-200">Logout</a>
                        <?php
                    } else if (Validator::Role('teacher')) {
                        ?>
                        <a href="/dashboard" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">Dashboard</a>
                        <a href="/students" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">Students</a>
                        <a href="/subjects" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">Subjects</a>
                        <a href="/grades" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">Grades</a>
                        <a href="/logout" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:bg-red-50 hover:text-red-700 transition-colors duration-200">Logout</a>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state -->
    <div class="mobile-menu hidden sm:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <?php
            if (Validator::Role('student')) {
                ?>
                <a href="/dashboard" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-700">Dashboard</a>
                <a href="/logout" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-red-50 hover:text-red-700">Logout</a>
                <?php
            } else if (Validator::Role('teacher')) {
                ?>
                <a href="/dashboard" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-700">Dashboard</a>
                <a href="/student" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-700">Students</a>
                <a href="/subjects" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-700">Subjects</a>
                <a href="/grades" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-700">Grades</a>
                <a href="/logout" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-red-50 hover:text-red-700">Logout</a>
                <?php
            }
            ?>
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');

            // Toggle the icons
            const menuOpenIcon = mobileMenuButton.querySelector('svg:first-child');
            const menuCloseIcon = mobileMenuButton.querySelector('svg:last-child');

            menuOpenIcon.classList.toggle('block');
            menuOpenIcon.classList.toggle('hidden');
            menuCloseIcon.classList.toggle('block');
            menuCloseIcon.classList.toggle('hidden');
        });
    });
</script>