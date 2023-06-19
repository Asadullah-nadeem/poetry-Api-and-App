<?php
// Assuming your database connection details
$servername = "localhost";
$username = "codeaxei_fsdftrtfgdfg";
$password = "R8dfE4cCL@pGWUi";
$dbname = "codeaxei_sdfsdfsdfsdfsd";

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $poetryData = $_POST["poetry_data"];
    $poetName = $_POST["poet_name"];

    // Prepare and execute the SQL query
    $stmt = $pdo->prepare("INSERT INTO poetry (poetry_data, poet_name) VALUES (:poetryData, :poetName)");
    $stmt->bindParam(":poetryData", $poetryData);
    $stmt->bindParam(":poetName", $poetName);

    try {
        $stmt->execute();
        echo "Poetry uploaded successfully!";
    } catch(PDOException $e) {
        echo "Error uploading poetry: " . $e->getMessage();
    }
}
?>
