<?php
include './components/head.php';
include './components/navbar.php';


$model = new GradesModel();
$grade = $model->getGradeById($_GET['id']);

if (!$grade) {
    ?>
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen py-12">
        <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-lg">
            <div class="px-6 py-4 bg-red-600">
                <h2 class="text-xl font-bold text-white">Grade Not Found</h2>
            </div>
            <div class="p-6 text-center">
                <p class="text-gray-600 mb-4">The grade you are looking for does not exist or has been deleted.</p>
                <a href="/dashboard" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
    <?php
    include './components/footer.php';
    exit();
}
?>

    <div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen py-12">
        <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-lg">
            <div class="px-6 py-4 bg-indigo-600">
                <h2 class="text-xl font-bold text-white">Edit Grade</h2>
            </div>

            <div class="p-6">
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">Student:</p>
                    <p class="font-medium text-gray-800"><?php echo htmlspecialchars($grade['first_name'] . ' ' . $grade['last_name']); ?></p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">Subject:</p>
                    <p class="font-medium text-gray-800"><?php echo htmlspecialchars($grade['subject_name']); ?></p>
                </div>

                <form id="updateGradeForm" action="/grades/update" method="POST">
                    <div class="mb-6">
                        <label for="grade" class="block text-sm font-medium text-gray-700">Grade:</label>
                        <input type="number" id="grade" name="grade" min="0" max="10" step="0.1"
                               value="<?php echo htmlspecialchars($grade['grade']); ?>"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-black" required>
                        <p class="mt-1 text-xs text-gray-500">Enter a value between 0 and 10</p>
                    </div>

                    <input type="hidden" name="grade_id" value="<?php echo htmlspecialchars($grade['id']); ?>">

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Changes
                        </button>

                        <a href="/dashboard" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            Cancel
                        </a>
                    </div>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <form id="deleteGradeForm" action="/grades/delete" method="POST">
                        <input type="hidden" name="grade_id" value="<?php echo htmlspecialchars($grade['id']); ?>">
                        <button type="button" id="deleteGradeBtn" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete Grade
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle form submission with AJAX
            document.getElementById('updateGradeForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Grade updated successfully!');
                            window.location.href = '/dashboard';
                        } else {
                            alert('Error: ' + (data.message || 'Failed to update grade'));
                        }
                    })
                    .catch(error => {
                        alert('An error occurred. Please try again.');
                        console.error(error);
                    });
            });

            // Handle delete button click
            document.getElementById('deleteGradeBtn').addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this grade? This action cannot be undone.')) {
                    const form = document.getElementById('deleteGradeForm');
                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Grade deleted successfully!');
                                window.location.href = '/dashboard';
                            } else {
                                alert('Error: ' + (data.message || 'Failed to delete grade'));
                            }
                        })
                        .catch(error => {
                            alert('An error occurred. Please try again.');
                            console.error(error);
                        });
                }
            });
        });
    </script>

<?php include './components/footer.php'; ?>