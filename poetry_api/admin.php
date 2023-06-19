<?php 
include('dbcon.php');
include('session.php'); 
$result=mysqli_query($con, "select * from users where user_id='$session_id'")or die('Error In Session');
$row=mysqli_fetch_array($result);

 ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poetry App</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar bg-light navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <h3 class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Api
                    </h3>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="api/getpoetry.php">Getpoetry Api</a></li>
                        <li><a class="dropdown-item" href="api/addpoetry.php">Addpoetry Api</a></li>
                        <li><a class="dropdown-item" href="api/updatepoetry.php">Updatepoetry Api</a></li>
                        <li><a class="dropdown-item" href="api/deletepoetry.php">Deletepoetry Api</a></li>
                    </ul>
                </li>
                <ul class="navbar-nav">
                 <li class="nav-item">
                 <div class="form-wrapper"> 
<p><a class="btn btn-danger" href="logout.php">Log out</a></p>
             </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <h1 class="mt-4">Upload Poetry</h1>
    <form action="conf.php" method="POST">
        <div class="mb-3">
            <label for="poet_name" class="form-label">Poet Name:</label>
            <input type="text" class="form-control" name="poet_name" id="poet_name">
        </div>
        <div class="mb-3">
            <label for="poetry_data" class="form-label">Poetry Data:</label>
            <textarea class="form-control" name="poetry_data" id="poetry_data" rows="4" cols="50"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

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

    // Check if the delete form was submitted
    if (isset($_POST['delete'])) {
        $id = $_POST['delete'];

        // Delete the record from the database
        $stmt = $pdo->prepare("DELETE FROM poetry WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    // Retrieve data from the database
    $stmt = $pdo->query("SELECT * FROM poetry");
    $poems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <h1 class="mt-4">Poetry List</h1>

    <?php foreach ($poems as $poem): ?>
        <div class="card my-4">
            <div class="card-body">
                <h2 class="card-title"><?php echo $poem['poet_name']; ?></h2>
                <h6 class="card-text"><?php echo $poem['data_time']; ?></h6>
                <p class="card-text"><?php echo $poem['poetry_data']; ?></p>
                <form method="post" style="display: inline;">
                    <input type="hidden" name="delete" value="<?php echo $poem['id']; ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <a href="edit.php?id=<?php echo $poem['id']; ?>" class="btn btn-primary">Edit</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
