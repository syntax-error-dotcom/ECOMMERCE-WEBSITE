<?php
    class OrderModel {
        private $conn;

        //kini sya kay para mag connect ni sya sa atoang database
        public function __construct($db) {
            $this->conn = $db;
        }



        public function createOrder($data) {
            $stmt = $this->conn->prepare("INSERT INTO orders(user_id, street, barangay, city, total, order_status) 
            VALUES (?, ?, ?, ?, ?, 'pending')");
            $stmt->execute([
                $data['user_id'],
                $data['street'],
                $data['barangay'],
                $data['city'],
                $data['total']
            ]);
            


            //ma return sya sa order niya after pag insert, for example once the customer makes an order, tas
            //gi insert na natu iyaha order sa database, e butang iyaha screen back to order screen, instead 
            //sa dashboard or sa uban page, of course this can still be altered, hence why I put this comment kay
            //para if there are changes with the flow, you can noticed this comment and make changes THANKS!
            return $this->conn->lastInsertId();

        }




        //GET ALL orders or index orders
        public function getAllOrders() {
            $stmt = $this->conn->prepare('SELECT * FROM orders');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //GETS ORDER BY ID
        public function getOrderbyId($id) {
            $stmt = $this->conn->prepare("SELECT * FROM orders WHERE order_id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getOrdersByUserId($user_id) {
            $stmt = $this->conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        public function updateStatus($status, $id) {
            //do we need update Order? I think Order are set, you cant changed that, you cant changed your address,
            //cant change the quantity, once the order is submit!, you can only make changes on order list
            $stmt = $this->conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
            $stmt->execute([$status, $id]);
        }
        
        public function deleteOrder($id) {
            //holdup do we have a delete Order? can the admin delete Order? why would the admin delete an ORDER?
            //because if we have cancel Order we can do that so, but when you said deleteOrder, IT MEANS the 
            //customer already have submitted the order if he wants to cancel thats difference because cancelling
            //an order means not deleting it, we change the status of this specific order to canceled and would be
            //stored in the database right? YES YOURE RIGHT BRO!
        }

    
    }








?>