<?php 

    require_once("config.php");

    class Database extends config {

        public function fetch($EmployeeID = 0) {
            $sql = "SELECT EmployeeID, LastName, FirstName FROM employees";
            if ($EmployeeID != 0) {
                $sql .= " WHERE EmployeeID = :EmployeeID";
                // "SELECT EmployeeID, LastName, FirstName FROM employees WHERE EmployeeID = :EmployeeID";
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["EmployeeID" => $EmployeeID]);
            $rows = $stmt->fetchAll();
            return $rows;
        }

        public function fetchAll() {
            $sql = "SELECT EmployeeID, LastName, FirstName FROM employees ORDER BY EmployeeID ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows; 
        }

        public function insert($EmployeeID, $LastName, $FirstName) {
            $sql = "INSERT INTO employees(EmployeeID, LastName, FirstName) VALUES(:EmployeeID, :LastName, :FirstName)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["EmployeeID" => $EmployeeID, "LastName" => $LastName, "FirstName" => $FirstName]);
            return true;
        }

        public function update($LastName, $FirstName, $EmployeeID) {
            $sql = "UPDATE employees SET LastName = :LastName, FirstName = :FirstName WHERE EmployeeID = :EmployeeID";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['EmployeeID' => $EmployeeID, "LastName" => $LastName, 'FirstName' => $FirstName]);
            return true;
        }

        public function delete($EmployeeID) {
            $sql = "DELETE FROM employees WHERE EmployeeID = :EmployeeID";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["EmployeeID" => $EmployeeID]);
            return true;
        }

    }

?>