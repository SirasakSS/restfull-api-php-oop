<?php 

    require_once("config_local.php");

    class Database extends config {

        public function fetch($CustomerID = 0) {
            $sql = "SELECT CustomerID, CompanyName, ContactName FROM customers";
            if ($CustomerID != 0) {
                $sql .= " WHERE CustomerID = :CustomerID";
                // "SELECT CustomerID, CompanyName, ContactName FROM customers WHERE CustomerID = :CustomerID";
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["CustomerID" => $CustomerID]);
            $rows = $stmt->fetchAll();
            return $rows;
        }

        public function fetchAll() {
            $sql = "SELECT CustomerID, CompanyName, ContactName FROM customers ORDER BY CustomerID ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows; 
        }

        public function insert($CustomerID, $CompanyName, $ContactName) {
            $sql = "INSERT INTO customers(CustomerID, CompanyName, ContactName) VALUES(:CustomerID, :CompanyName, :ContactName)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["CustomerID" => $CustomerID, "CompanyName" => $CompanyName, "ContactName" => $ContactName]);
            return true;
        }

        public function update($CompanyName, $ContactName, $CustomerID) {
            $sql = "UPDATE customers SET CompanyName = :CompanyName, ContactName = :ContactName WHERE CustomerID = :CustomerID";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['CustomerID' => $CustomerID, "CompanyName" => $CompanyName, 'ContactName' => $ContactName]);
            return true;
        }

        public function delete($CustomerID) {
            $sql = "DELETE FROM customers WHERE CustomerID = :CustomerID";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["CustomerID" => $CustomerID]);
            return true;
        }

    }

?>