<?php
    class CartItemModel {
        private $conn;

        public function __construct($db) {
            $this->conn = $db;
        }
        

        public function getByCartId($cart_id) {
            $stmt = $this->conn->prepare("SELECT cart_items.*, products.product_name, products.price, 
            products.image1 FROM cart_items
            JOIN products ON cart_items.product_id = products.product_id
            WHERE cart_items.cart_id = ?      
            ");
            $stmt->execute([$cart_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);


            ///hmm i think this was the point that I made earlier, in this specific statement, it takes all the
            //cart_items row where the user_id = ?, it means it would only take cart_items where it is own by
            //the specific user or the owner of the cart.

        }


        public function addItem($data) {
            $stmt = $this->conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity)
            VALUES (?, ?, ?)");

            $stmt->execute([
                $data['cart_id'], 
                $data['product_id'], 
                $data['quantity']
                ]);
        }

        public function removeItem($cart_item_id) {
            $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE cart_item_id = ?");
            $stmt->execute([$cart_item_id]);

            //this prob the only where we use delete, BUT its given, we dont need to record the user cart, when
            //it doesnt even bother buying them yet, we only care once he hit that order button.
        }

        public function clearCart($cart_id) {
            $stmt = $this->conn->prepare(
                "DELETE FROM cart_items WHERE cart_id = ?"
            );
            $stmt->execute([$cart_id]);
        }

    }



?>