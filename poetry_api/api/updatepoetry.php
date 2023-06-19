<?php


$servername = "localhost";
$username = "codeaxei_fsdftrtfgdfg";
$password = "R8dfE4cCL@pGWUi";
$db = "codeaxei_sdfsdfsdfsdfsd";

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the required parameters are sent via POST
if (isset($_POST['poetry_data']) && isset($_POST['id'])) {
    $POETRY = $_POST['poetry_data'];
    $ID = $_POST['id'];

    $query = "UPDATE poetry SET poetry_data = '$POETRY' WHERE id = '$ID'";

    if ($conn->query($query) === true) {
        $response = array("status" => "1", "message" => "Poetry successfully updated");
    } else {
        $response = array("status" => "0", "message" => "Poetry not successfully updated");
    }
} else {
    $response = array("status" => "0", "message" => "Required parameters not sent");
}

echo json_encode($response);
?>
