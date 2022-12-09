<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: X-Requested-With");
    header("Content-Type: application/json");

    require_once("db.php");
    $product = new Database();

    $api = $_SERVER["REQUEST_METHOD"];

    $ProductID = intval($_GET['ProductID'] ?? '');

    // GET All data or Single data
    if ($api == "GET") {
        if ($ProductID != 0) {
            $data = $product->fetch($ProductID);
        } else {
            $data = $product->fetchAll();
        }
        echo json_encode($data);
    }

    // Add new data
    if ($api == "POST") {

        $ProductID = $product->test_input($_POST['ProductID']);
        $ProductName = $product->test_input($_POST['ProductName']);
        $UnitPrice = $product->test_input($_POST['UnitPrice']);

        if ($product->insert($ProductID, $ProductName, $UnitPrice)) {
            echo $product->message("product added successfully", false);
        } else {
            echo $product->message("Failed to add an product", true);
        }
    }

    // Update data
    if ($api == 'PUT') {
        parse_str(file_get_contents('php://input'), $post_input);

        $ProductID = $product->test_input($post_input['ProductID']);
        $ProductName = $product->test_input($post_input['ProductName']);
        $UnitPrice = $product->test_input($post_input['UnitPrice']);

        if ($ProductID != null) {
            if ($product->update($ProductName, $UnitPrice, $ProductID)) {
                echo $product->message("product updated successfully", false);
            } else {
                echo $product->message("Failed to update and product", true);
            }
        } else {
            echo $product->message("product not found!!", true);
        }
    }

    // Delete an product from database
    if ($api == "DELETE") {
        if ($ProductID != null) {
            if ($product->delete($ProductID)) {
                echo $product->message("product deleted successfully", false);
            } else {
                echo $product->message("Failed to delete an product", true);
            }
        } else {
            echo $product->message("product not found!", true);
        }
    }

?>