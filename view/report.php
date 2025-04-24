<?php include './components/head.php';?>
<?php include './components/navbar.php';?>
<?php include_once './Models/ProductsModel.php'; ?>

<?php
$products = (new ProductsModel())->getAllProducts();
?>

    <div class="container mx-auto px-4 py-8 bg-gray-900 min-h-screen">
        <h1 class="text-4xl text-center font-bold mb-8 text-gray-100">
            <span class="border-b-4 border-blue-500 pb-2">Report Creator</span>
        </h1>

        <form action="/report/generate" method="POST" class="bg-gray-800 rounded-lg shadow-xl p-6">
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-700">
                    <thead>
                        <tr>
                            <th class="border border-gray-700 px-4 py-2 text-gray-300">Select</th>
                            <th class="border border-gray-700 px-4 py-2 text-gray-300">ID</th>
                            <th class="border border-gray-700 px-4 py-2 text-gray-300">Product Name</th>
                            <th class="border border-gray-700 px-4 py-2 text-gray-300">Category</th>
                            <th class="border border-gray-700 px-4 py-2 text-gray-300">Price</th>
                            <th class="border border-gray-700 px-4 py-2 text-gray-300">Supplier</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-300">
                    <?php foreach ($products as $product): ?>
                        <tr class="hover:bg-base-200">
                            <td>
                                <input type="checkbox" name="selected_products[]" value="<?php echo $product['ID']; ?>" class="checkbox checkbox-neutral" />
                            </td>
                            <td><?php echo $product['ID']; ?></td>
                            <td><?php echo $product['PRODUCTNAME']; ?></td>
                            <td><?php echo $product['CATEGORY_ID']; ?></td>
                            <td>€<?php echo number_format($product['PRICE'], 2); ?></td>
                            <td><?php echo $product['SUPPLIER']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <div class="form-control">
                    <h3 class="text-lg font-bold mb-2 text-gray-300">Report Notes:</h3>
                    <textarea name="report_notes" placeholder="Add notes about these products..." 
                        class="w-full bg-gray-700 text-gray-300 border border-gray-600 rounded-lg p-3"></textarea>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Generate Report
                    </button>
                </div>
            </div>
        </form>
    </div>

<?php include './components/footer.php';?>