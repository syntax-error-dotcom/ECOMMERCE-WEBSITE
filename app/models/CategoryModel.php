<?php
    class CategoryModel {
        private $conn;

        //kini sya kay para mag connect ni sya sa atoang database
        public function __construct($db) {
            $this->conn = $db;
        }

        //GET ALL categories or index categories
        public function getAllCategory() {
            $stmt = $this->conn->prepare("SELECT * FROM categories");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        //find category, find a specific category by id
        public function getCategoryById($id) {
            $stmt = $this->conn->prepare("SELECT * FROM categories WHERE category_id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        //for adding new category
        public function addCategory($data) {
            $stmt = $this->conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
            $stmt->execute([$data['category_name']]);
        }
        
        //updating category by id
        public function updateCategory($id, $data) {
            $stmt = $this->conn->prepare("UPDATE categories SET category_name = ? WHERE category_id = ?");
            $stmt->execute([$data['category_name'], $id]);

        }

        //delete category by id
        public function deleteCategory($id) {
            $stmt = $this->conn->prepare("DELETE FROM categories WHERE category_id = ?");
            $stmt->execute([$id]);
        }


    }



?>