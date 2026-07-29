<?php 
class CartModel {
    private $conn;

        //kini sya kay para mag connect ni sya sa atoang database
        public function __construct($db) {
            $this->conn = $db;
        }

        public function getOrCreateCart($user_id) {

            //select and checks if cart exists
            $stmt = $this->conn->prepare("SELECT * FROM  carts(user_id) VALUES (?)");
            $stmt->execute([$user_id]);  
            $cart = $stmt->fetch(PDO::FETCH_ASSOC);

            

            // if no cart exists yet, create one
            if(!$cart) {
                $stmt = $this->conn->prepare("INSERT INTO carts (user_id) VALUES (?)");
                $stmt->execute([$user_id]);
                
                //returns the new cart id
                return $this->conn->lastInsertId();

                //ah okay

            }
            //if cart already exist then drop here.
            return $cart['cart_id'];
            
            

        }

        


}



?>