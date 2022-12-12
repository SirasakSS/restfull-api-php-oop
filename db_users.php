<?php 

    require_once("config.php");

    class Database extends Config {

        public function fetch($id = 0) {
            $sql = "SELECT id, first_name, last_name FROM users";
            if ($id != 0) {
                $sql .= " WHERE id = :id";
                // "SELECT id, first_name, last_name FROM users WHERE id = :id";
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);
            $rows = $stmt->fetchAll();
            return $rows;
        }

        public function fetchAll() {
            $sql = "SELECT id, first_name, last_name FROM users ORDER BY id ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows; 
        }

        public function insert($id, $first_name, $last_name) {
            $sql = "INSERT INTO users(id, first_name, last_name) VALUES(:id, :first_name, :last_name)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id, "first_name" => $first_name, "last_name" => $last_name]);
            return true;
        }

        public function update($first_name, $last_name, $id) {
            $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id, "first_name" => $first_name, 'last_name' => $last_name]);
            return true;
        }

        public function delete($id) {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);
            return true;
        }

    }

?>