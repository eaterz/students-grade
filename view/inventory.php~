<?php include './components/head.php';?>
<?php include './components/navbar.php';?>
<?php include_once './Models/InventoryModel.php';?>

<h1 class="text-4xl text-center font-bold mb-6">Inventory</h1>

<?php
$inventoryModel = new InventoryModel();
$inventoryItems = $inventoryModel->getInventoryItems();
?>

<div class="flex justify-center mb-6">
    <select id="categoryFilter" class="block appearance-none w-1/3 bg-gray-800 text-white border border-gray-600 hover:border-gray-400 px-3 py-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
        <option value="all">All</option>
        <?php   
        $categories = array_unique(array_column($inventoryItems, 'CATEGORY'));
        foreach ($categories as $category) {
            echo "<option value='" . $category . "'>" . $category . "</option>";
        }
        ?>
    </select>
</div>

<table class="table-auto w-full border-collapse border border-gray-300" id="inventoryTable">
    <thead>
        <tr class="bg-gray-700 text-white">
            <th class="border border-gray-300 px-4 py-2">Product ID</th>
            <th class="border border-gray-300 px-4 py-2">Product Name</th>
            <th class="border border-gray-300 px-4 py-2">Category</th>
            <th class="border border-gray-300 px-4 py-2">Quantity</th>
            <th class="border border-gray-300 px-4 py-2">Price</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($inventoryItems)) {
            foreach ($inventoryItems as $item) {
                echo "<tr data-id='" . $item["inventory_id"] . "' class='inventory-item hover:bg-gray-500 cursor-pointer transition-colors duration-300 hover:text-white'>";
                echo "<td class='border border-gray-300 px-4 py-2'>" . $item["inventory_id"] . "</td>";
                echo "<td class='border border-gray-300 px-4 py-2'>" . $item["PRODUCTNAME"] . "</td>";
                echo "<td class='border border-gray-300 px-4 py-2'>" . $item["CATEGORY"] . "</td>";
                echo "<td class='border border-gray-300 px-4 py-2'>" . $item["QUANTITY"] . "</td>";
                echo "<td class='border border-gray-300 px-4 py-2'>" . $item["PRICE"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='border border-gray-300 px-4 py-2 text-center'>No data found</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- Modal -->
<div id="itemModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden transition-opacity duration-300">
    <div class="bg-gray-800 text-white rounded-lg shadow-lg p-6 w-1/3 transform transition-transform duration-300 scale-95">
        <div class="modal-content">
            <h2 class="text-2xl font-bold mb-4"><span id="modalProductName"></span></h2>
            <p><strong>Category:</strong> <span id="modalCategory"></span></p>
            <p><strong>Quantity:</strong> <span id="modalQuantity"></span></p>
            <p><strong>Price:</strong> <span id="modalPrice"></span></p>
            <p><strong>Supplier:</strong> <span id="modalSupplier"></span></p>
            <div class="flex justify-end mt-4">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mr-2">Edit</button>
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Delete</button>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('categoryFilter').addEventListener('change', function() {
    var filter = this.value;
    var rows = document.querySelectorAll('#inventoryTable tbody tr');
    rows.forEach(function(row) {
        var category = row.cells[2].innerText;
        if (filter === 'all' || category === filter) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

document.querySelectorAll('.inventory-item').forEach(function(item) {
    item.addEventListener('click', function() {
        var productName = this.cells[1].innerText;
        var category = this.cells[2].innerText;
        var quantity = this.cells[3].innerText;
        var price = this.cells[4].innerText;
        var supplier = this.cells[5] ? this.cells[5].innerText : 'Unknown'; // Assuming supplier is in the 6th cell

        document.getElementById('modalProductName').innerText = productName;
        document.getElementById('modalCategory').innerText = category;
        document.getElementById('modalQuantity').innerText = quantity;
        document.getElementById('modalPrice').innerText = price;
        document.getElementById('modalSupplier').innerText = supplier;

        var modal = document.getElementById('itemModal');
        modal.classList.remove('hidden');
        setTimeout(function() {
            modal.classList.remove('opacity-0');
            modal.querySelector('.modal-content').classList.remove('scale-95');
        }, 10);
    });
});

document.getElementById('itemModal').addEventListener('click', function(event) {
    if (event.target === this) {
        var modal = this;
        modal.classList.add('opacity-0');
        modal.querySelector('.modal-content').classList.add('scale-95');
        setTimeout(function() {
            modal.classList.add('hidden');
        }, 300);
    }
});
</script>