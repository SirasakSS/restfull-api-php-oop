<?php 

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: X-Requested-With");
    header("Content-Type: application/json");

    require_once("db_users.php");
    $users = new Database();

    $api = $_SERVER["REQUEST_METHOD"];

    $id = intval($_GET['id'] ?? '');

    // GET All data or Single data
    if ($api == "GET") {
        if ($id != 0) {
            $data = $users->fetch($id);
        } else {
            $data = $users->fetchAll();
        }
        echo json_encode($data);
    }

    // Add new data
    if ($api == "POST") {

        $id = $users->test_input($_POST['id']);
        $first_name = $users->test_input($_POST['first_name']);
        $last_name = $users->test_input($_POST['last_name']);

        if ($users->insert($id, $first_name, $last_name)) {
            echo $users->message("users added successfully", false);
        } else {
            echo $users->message("Failed to add an users", true);
        }
    }

    // Update data
    if ($api == 'PUT') {
        parse_str(file_get_contents('php://input'), $post_input);

        $id = $users->test_input($post_input['id']);
        $first_name = $users->test_input($post_input['first_name']);
        $last_name = $users->test_input($post_input['last_name']);

        if ($id != null) {
            if ($users->update($first_name, $last_name, $id)) {
                echo $users->message("users updated successfully", false);
            } else {
                echo $users->message("Failed to update and users", true);
            }
        } else {
            echo $users->message("users not found!!", true);
        }
    }

    // Delete an users from database
    if ($api == "DELETE") {
        if ($id != null) {
            if ($users->delete($id)) {
                echo $users->message("users deleted successfully", false);
            } else {
                echo $users->message("Failed to delete an users", true);
            }
        } else {
            echo $users->message("users not found!", true);
        }
    }

?>