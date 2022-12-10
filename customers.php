<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: X-Requested-With");
    header("Content-Type: application/json");

    require_once("db_customer.php");
    $customer = new Database();

    $api = $_SERVER["REQUEST_METHOD"];

    $CustomerID = intval($_GET['CustomerID'] ?? '');

    // GET All data or Single data
    if ($api == "GET") {
        if ($CustomerID != 0) {
            $data = $customer->fetch($CustomerID);
        } else {
            $data = $customer->fetchAll();
        }
        echo json_encode($data);
    }

    // Add new data
    if ($api == "POST") {

        $CustomerID = $customer->test_input($_POST['CustomerID']);
        $CompanyName = $customer->test_input($_POST['CompanyName']);
        $ContactName = $customer->test_input($_POST['ContactName']);

        if ($customer->insert($CustomerID, $CompanyName, $ContactName)) {
            echo $customer->message("customer added successfully", false);
        } else {
            echo $customer->message("Failed to add an customer", true);
        }
    }

    // Update data
    if ($api == 'PUT') {
        parse_str(file_get_contents('php://input'), $post_input);

        $CustomerID = $customer->test_input($post_input['CustomerID']);
        $CompanyName = $customer->test_input($post_input['CompanyName']);
        $ContactName = $customer->test_input($post_input['ContactName']);

        if ($CustomerID != null) {
            if ($customer->update($CompanyName, $ContactName, $CustomerID)) {
                echo $customer->message("customer updated successfully", false);
            } else {
                echo $customer->message("Failed to update and customer", true);
            }
        } else {
            echo $customer->message("customer not found!!", true);
        }
    }

    // Delete an customer from database
    if ($api == "DELETE") {
        if ($CustomerID != null) {
            if ($customer->delete($CustomerID)) {
                echo $customer->message("customer deleted successfully", false);
            } else {
                echo $customer->message("Failed to delete an customer", true);
            }
        } else {
            echo $customer->message("customer not found!", true);
        }
    }

?>