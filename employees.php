<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: X-Requested-With");
    header("Content-Type: application/json");

    require_once("db_employees.php");
    $employee = new Database();

    $api = $_SERVER["REQUEST_METHOD"];

    $EmployeeID = intval($_GET['EmployeeID'] ?? '');

    // GET All data or Single data
    if ($api == "GET") {
        if ($EmployeeID != 0) {
            $data = $employee->fetch($EmployeeID);
        } else {
            $data = $employee->fetchAll();
        }
        echo json_encode($data);
    }

    // Add new data
    if ($api == "POST") {

        $EmployeeID = $employee->test_input($_POST['EmployeeID']);
        $LastName = $employee->test_input($_POST['LastName']);
        $FirstName = $employee->test_input($_POST['FirstName']);

        if ($employee->insert($EmployeeID, $LastName, $FirstName)) {
            echo $employee->message("employee added successfully", false);
        } else {
            echo $employee->message("Failed to add an employee", true);
        }
    }

    // Update data
    if ($api == 'PUT') {
        parse_str(file_get_contents('php://input'), $post_input);

        $EmployeeID = $employee->test_input($post_input['EmployeeID']);
        $LastName = $employee->test_input($post_input['LastName']);
        $FirstName = $employee->test_input($post_input['FirstName']);

        if ($EmployeeID != null) {
            if ($employee->update($LastName, $FirstName, $EmployeeID)) {
                echo $employee->message("employee updated successfully", false);
            } else {
                echo $employee->message("Failed to update and employee", true);
            }
        } else {
            echo $employee->message("employee not found!!", true);
        }
    }

    // Delete an employee from database
    if ($api == "DELETE") {
        if ($EmployeeID != null) {
            if ($employee->delete($EmployeeID)) {
                echo $employee->message("employee deleted successfully", false);
            } else {
                echo $employee->message("Failed to delete an employee", true);
            }
        } else {
            echo $employee->message("employee not found!", true);
        }
    }

?>