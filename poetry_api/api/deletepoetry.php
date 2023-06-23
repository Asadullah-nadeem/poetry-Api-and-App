<?php


$servername = "localhost";
$username = "";
$password = "";
$db = "";

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the required parameter is sent via POST
if (isset($_POST['id'])) {
    $ID = $_POST['id'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("DELETE FROM poetry WHERE id = ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        $response = array("status" => "1", "message" => "Poetry successfully deleted");
    } else {
        $response = array("status" => "0", "message" => "Poetry not found or deletion failed");
    }
    $stmt->close();
} else {
    $response = array("status" => "0", "message" => "Required parameter not sent");
}

echo json_encode($response);
?>
