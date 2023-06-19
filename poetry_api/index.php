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

// Check if a search query is submitted
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Add a WHERE clause to the SQL query to filter based on the search query
    $stmt = $pdo->prepare("SELECT * FROM poetry WHERE poet_name LIKE :search OR poetry_data LIKE :search");
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();

    // Retrieve the filtered data
    $poems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Retrieve all data from the database
    $stmt = $pdo->query("SELECT * FROM poetry");
    $poems = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch suggestions for autocomplete
if (isset($_GET['suggestion'])) {
    $search = $_GET['suggestion'];

    // Add a WHERE clause to the SQL query to filter based on the search query
    $stmt = $pdo->prepare("SELECT poet_name FROM poetry WHERE poet_name LIKE :search LIMIT 5");
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();

    // Retrieve the suggested poet names
    $suggestions = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Return the suggestions as JSON
    echo json_encode($suggestions);
    exit(); // Terminate the script after sending suggestions
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poetry App</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <h1>Poetry List</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <form class="d-flex" action="" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" id="search-bar" autocomplete="off">
                <div id="suggestion-dropdown" class="dropdown-menu"></div>
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <div class="container mt-4">
        <?php foreach ($poems as $poem): ?>
            <div class="card my-4">
                <div class="card-body">
                    <h2 class="card-title"><?php echo $poem['poet_name']; ?></h2>
                    <h6 class="card-text"><?php echo $poem['data_time']; ?></h6>
                    <p class="card-text"><?php echo $poem['poetry_data']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // AJAX request to fetch suggestions
        $('#search-bar').on('input', function() {
            var suggestion = $(this).val();
            if (suggestion !== '') {
                $.ajax({
                    url: 'index.php?suggestion=' + suggestion,
                    type: 'GET',
                    success: function(data) {
                        var suggestions = JSON.parse(data);
                        var suggestionList = '';
                        if (suggestions.length > 0) {
                            for (var i = 0; i < suggestions.length; i++) {
                                suggestionList += '<a class="dropdown-item" href="#">' + suggestions[i] + '</a>';
                            }
                        } else {
                            suggestionList = '<a class="dropdown-item" href="#">No suggestions found</a>';
                        }
                        $('#suggestion-dropdown').html(suggestionList);
                    }
                });
            } else {
                $('#suggestion-dropdown').html('');
            }
        });
    </script>
</body>

</html>
