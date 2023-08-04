<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Search</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <style>
        /* Add your custom CSS styles here */
        .search-results {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Website Search</h1>
        <form method="post" action="siteSearch.php" class="mt-3">
            <div class="input-group">
                <input type="text" name="search_query" class="form-control" placeholder="Enter your search query" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    <div class="container mt-5">
        <h2>Titles</h2>
        <div class="row">
            <?php
            // Assume you have already established a database connection
            include('connect.php');

            // Fetch latest articles from the database
            $sql = "SELECT * FROM articles ORDER BY id DESC";
            $result = mysqli_query($conn, $sql);

            // Display latest articles
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-6 mb-4">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars($row['content']) . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            // Close the connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>

</html>
