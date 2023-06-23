<?php


$servername = "localhost";
$username = "";
$password = "";
$db = "";


$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['poetry']) && isset($_POST['poet_name'])) {
    $POETRY = $_POST['poetry'];
    $POET_NAME = $_POST['poet_name'];
    $query = "INSERT INTO poetry (poetry_data, poet_name) VALUES ('$POETRY', '$POET_NAME')";
    if ($conn->query($query) === true) {
        $response = array("status" => "1", "message" => "Poetry successfully inserted");
    } else {
        $response = array("status" => "0", "message" => "Poetry not successfully inserted");
    }
} else {
    $response = array("status" => "0", "message" => "Required parameters not sent");
}
echo json_encode($response);
?>
