<?php

require './Models/ProductsModel.php';
require './Models/InventoryModel.php';
class ProductsController
{

    public function create(){

        require './view/products.php';
    }

    public function store()
    {
        $productName = $_POST['productName'];
        $categoryId = $_POST['categoryId'];
        $supplier = $_POST['supplier'];
        $price = $_POST['price'];
        $shelfId = $_POST['shelfId'];
        $quantity = $_POST['quantity'];

        $productModel = new ProductsModel();
        $productId = $productModel->create([
            'productName' => $productName,
            'categoryId' => $categoryId,
            'supplier' => $supplier,
            'price' => $price
        ]);

        $inventoryModel = new InventoryModel();
        $inventoryModel->store([
            'shelfId' => $shelfId,
            'productId' => $productId,
            'quantity' => $quantity
        ]);

        header('Location: /inventory');
        exit;
    }
}