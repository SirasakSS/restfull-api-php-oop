<?php 

    require_once("config.php");

    class Database extends Config {

        public function fetch($ProductID = 0) {
            $sql = "SELECT ProductID, ProductName, UnitPrice FROM products";
            if ($ProductID != 0) {
                $sql .= " WHERE ProductID = :ProductID";
                // "SELECT ProductID, ProductName, UnitPrice FROM products WHERE ProductID = :ProductID";
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["ProductID" => $ProductID]);
            $rows = $stmt->fetchAll();
            return $rows;
        }

        public function fetchAll() {
            $sql = "SELECT ProductID, ProductName, UnitPrice FROM products ORDER BY ProductID ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows; 
        }

        public function insert($ProductID, $ProductName, $UnitPrice) {
            $sql = "INSERT INTO products(ProductID, ProductName, UnitPrice) VALUES(:ProductID, :ProductName, :UnitPrice)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["ProductID" => $ProductID, "ProductName" => $ProductName, "UnitPrice" => $UnitPrice]);
            return true;
        }

        public function update($ProductName, $UnitPrice, $ProductID) {
            $sql = "UPDATE products SET ProductName = :ProductName, UnitPrice = :UnitPrice WHERE ProductID = :ProductID";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['ProductID' => $ProductID, "ProductName" => $ProductName, 'UnitPrice' => $UnitPrice]);
            return true;
        }

        public function delete($ProductID) {
            $sql = "DELETE FROM products WHERE ProductID = :ProductID";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["ProductID" => $ProductID]);
            return true;
        }

    }

?>