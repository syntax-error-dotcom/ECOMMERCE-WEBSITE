<?php
    class OrderItemModel {
        private $conn;

        //kini sya kay para mag connect ni sya sa atoang database
        public function __construct($db) {
            $this->conn = $db;
        }


        public function createOrderItem($data) {
            $stmt = $this->conn->prepare("INSERT INTO order_items (order_id, product_id, price, quantity)
            VALUES (?, ?, ?, ?)");

            $stmt->execute([
                $data['order_id'], 
                $data['product_id'], 
                $data['price'], 
                $data['quantity']

            ]);


        }


        public function getByOrderId($order_id) {
            $stmt = $this->conn->prepare("SELECT order_items.*, products.product_name, products.image1 
            FROM order_items
            JOIN products ON order_items.product_id = products.product_id
            WHERE order_items.order_id = ?"
            );
            $stmt->execute([$order_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        //is this the only thing we have? no remove? oh my bad, we can design 'remove' order in the design
        //capturing fluent in inserting in and out in our database, or do we add them? cause this is just 
        //my assumption, how do pro does it?


    }


?>