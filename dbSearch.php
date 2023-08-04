<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Bar Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-5">Search Bar Db Example</h1>
        <div class="row justify-content-center mt-3">
            <div class="col-md-6">
                <!-- Search Form -->
                <form method="post" action="" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search_query" class="form-control" placeholder="Enter your search query" required>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>

                <div class="text-center">
                    <?php
                    // better to call connect directly ! 
                    include('connect.php')
              

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Get the search query from the form submission
                        $searchQuery = $_POST["search_query"];

                        // Perform the database search using a parameterized query
                        $sql = "SELECT * FROM articles WHERE title LIKE ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        $searchQueryWithWildcard = "%" . mysqli_real_escape_string($conn, $searchQuery) . "%";
                        mysqli_stmt_bind_param($stmt, "s", $searchQueryWithWildcard);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $numResults = mysqli_num_rows($result);

                        // Display the number of search results
                        echo "<p class='mt-3'>Found $numResults results for: " . htmlspecialchars($searchQuery) . "</p>";

                        // Process and display the search results
                        if ($numResults > 0) {
                            echo "<div class='list-group'>";
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Display each search result as a list item
                                echo "<a href='#' class='list-group-item list-group-item-action'>" . htmlspecialchars($row['title']) . "</a>";
                            }
                            echo "</div>";
                        } 
                    }

                    // Close the connection
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
