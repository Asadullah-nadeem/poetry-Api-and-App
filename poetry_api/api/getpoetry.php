<?php


$servername = "localhost";
$username = "codeaxei_fsdftrtfgdfg";
$password = "R8dfE4cCL@pGWUi";
$db = "codeaxei_sdfsdfsdfsdfsd";

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL query
$query = "SELECT * FROM poetry";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $response = array("status" => "1", "message" => "Data retrieved successfully", "data" => $data);
} else {
    $response = array("status" => "0", "message" => "No data found");
}

$conn->close();

echo json_encode($response);
?>
