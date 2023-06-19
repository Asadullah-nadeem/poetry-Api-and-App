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

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $poet_name = $_POST['poet_name'];
    $poetry_data = $_POST['poetry_data'];

    // Update the record in the database
    $stmt = $pdo->prepare("UPDATE poetry SET poet_name = :poet_name, poetry_data = :poetry_data WHERE id = :id");
    $stmt->bindParam(':poet_name', $poet_name);
    $stmt->bindParam(':poetry_data', $poetry_data);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirect back to the Poetry List page
    header("Location: admin.php");
    exit();
} else {
    // Check if the ID parameter is set
    if (!isset($_GET['id'])) {
        // Redirect back to the Poetry List page if ID is not provided
        header("Location: admin.php");
        exit();
    }

    $id = $_GET['id'];

    // Retrieve the poem from the database
    $stmt = $pdo->prepare("SELECT * FROM poetry WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $poem = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the poem exists
    if (!$poem) {
        // Redirect back to the Poetry List page if poem does not exist
        header("Location: admin.php");
        exit();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Poetry</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Edit Poetry</h1>
    <form action="edit.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $poem['id']; ?>">
        <div class="mb-3">
            <label for="poet_name" class="form-label">Poet Name:</label>
            <input type="text" class="form-control" name="poet_name" id="poet_name" value="<?php echo $poem['poet_name']; ?>">
        </div>
        <div class="mb-3">
            <label for="poetry_data" class="form-label">Poetry Data:</label>
            <textarea class="form-control" name="poetry_data" id="poetry_data" rows="4" cols="50"><?php echo $poem['poetry_data']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
