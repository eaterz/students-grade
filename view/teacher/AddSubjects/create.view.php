<?php include './components/head.php'; ?>
<?php include './components/navbar.php'; ?>

<div class="container mx-auto mt-10">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Create a New Subject</h2>
        <form action="/subjects/store" method="POST">
            <div class="mb-4">
                <label for="subject_name" class="block text-sm font-medium text-gray-700">Subject Name</label>
                <input type="text" name="subject_name" id="subject_name" required
                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-gray-300 text-gray-900 placeholder-gray-500"
                       placeholder="Enter subject name">
            </div>
            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Subject
                </button>
            </div>
        </form>
    </div>
</div>

<?php include './components/footer.php'; ?>