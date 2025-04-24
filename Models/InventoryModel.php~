<?php
require_once './Models/Model.php';

class InventoryModel extends Model
{
    public $db;

    public function __construct()
    {
        $this->db = new DbConnect();
    }

    public function getInventoryItems()
    {
        $sql = "SELECT 
                    INVENTORY.ID as inventory_id, 
                    PRODUCTS.PRODUCTNAME, 
                    CATEGORY.CATEGORY, 
                    INVENTORY.QUANTITY, 
                    PRODUCTS.PRICE 
                FROM INVENTORY 
                JOIN PRODUCTS ON INVENTORY.PRODUCT_ID = PRODUCTS.ID 
                JOIN CATEGORY ON PRODUCTS.CATEGORY_ID = CATEGORY.ID";

        return $this->db->execute($sql);
    }

    public function store($data)
    {

        $shelfId = $data['shelfId'];
        $productId = $data['productId'];
        $quantity = $data['quantity'];


        $sql = "INSERT INTO INVENTORY (SHELF_ID, PRODUCT_ID, QUANTITY, LASTUPDATE) 
            VALUES (:shelfId, :productId, :quantity, NOW())";


        $params = [
            ':shelfId' => $shelfId,
            ':productId' => $productId,
            ':quantity' => $quantity
        ];


        return $this->db->execute($sql, $params, true);
    }
}