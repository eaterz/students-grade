<?php include './components/head.php'; ?>
<?php include './components/navbar.php'; ?>

<div class="container mx-auto mt-10">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Create a New Subject</h2>
        <form action="/subjects/store" method="POST" class="space-y-6">
            <div>
                <label for="subject_name" class="block text-sm font-medium text-gray-700">Subject Name</label>
                <input type="text" name="subject_name" id="subject_name" required
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="Enter subject name">
            </div>
            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Save Subject
                </button>
            </div>
        </form>
    </div>
</div>

<?php include './components/footer.php'; ?>