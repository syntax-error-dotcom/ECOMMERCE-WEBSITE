<?php
    class UserModel {
        private $conn;
        private $table = 'users';

        public function __construct($db) {
            $this->conn = $db;
        }

        //finds the email for login
        public function findByEmail($email) {
            $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE email = ?");
            $stmt->execute([$email]);

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }

        public function findbyId($user_id) {
            $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE user_id = ?");
            $stmt->execute([$user_id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }

        public function create($data) {
            $stmt = $this->conn->prepare("INSERT INTO users(firstName, lastName, email, password, contact_no,
            street, barangay, city, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['firstName'], 
                $data['lastName'],
                $data['email'],
                $data['password'],
                $data['contact_no'],
                $data['street'],
                $data['barangay'],
                $data['city'],
                'user'

            ]);


        }

        public function emailExists($email) {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM {$this->table} WHERE email = ?");
            $stmt->execute([$email]);

            return $stmt->fetchColumn() > 0;

        }


        //update user profile
        public function update($id, $data) {
            $stmt = $this->conn->prepare("UPDATE {$this->table} SET firstName=?, lastName=?, 
            contact_no=?, street=?, barangay=?, city=? WHERE user_id=?");
            $stmt->execute([
                $data['firstName'], 
                $data['lastName'],
                $data['contact_no'],
                $data['street'],
                $data['barangay'],
                $data['city'],
                $id

            ]);


        }


    }



?>