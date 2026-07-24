<?php
class ProductModel {
    private $conn;
    

    //kini sya kay para mag connect ni sya sa atoang database
    public function __construct($db) {
        $this->conn = $db;
    }


    //I used PDO here for database rather than mysqli because PDO is more secure and flexible. 
    //It also supports multiple database types and provides a better way to handle prepared statements, 
    // which helps prevent SQL injection attacks. Additionally, PDO allows for easier error handling and 
    //fetching of results in different formats. 100% more better than last time in eLibary like integers,
    //get->result() and so on, this one is shorter and cleaner  so we can avoid having 800 lines!

    //GET ALL products or index products
    public function getAllProducts() {
        $stmt = $this->conn->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //gets the product by id
    public function getProductbyId($id) {
        $stmt = $this->conn->prepare("SELECT *FROM products WHERE product_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //for adding new products
    public function addNewProduct($data) {
        $stmt = $this->conn->prepare("INSERT INTO products (category_id, product_name, product_desc, 
        price, stock, image1, image2) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['category_id'],
            $data['product_name'],
            $data['product_desc'],
            $data['price'],
            $data['stock'],
            $data['image1'],
            $data['image2']
        ]);
    }

    //delete product by id
    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->execute([$id]);
    }


}
?>  