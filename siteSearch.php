<?php
// Assume you have already established a database connection
include('connect.php');

// Initialize variables
$search_results = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the search query from the form submission
    $searchQuery = $_POST["search_query"];

    // Perform the database search using a parameterized query
    $sql = "SELECT * FROM articles WHERE title LIKE ? OR content LIKE ?";
    $stmt = mysqli_prepare($conn, $sql);
    $searchQueryWithWildcard = "%" . mysqli_real_escape_string($conn, $searchQuery) . "%";
    mysqli_stmt_bind_param($stmt, "ss", $searchQueryWithWildcard, $searchQueryWithWildcard);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $numResults = mysqli_num_rows($result);

    // Process and display the search results
    if ($numResults > 0) {
        $search_results = "<div class='search-results'><h2>Search Results:</h2><ul>";
        while ($row = mysqli_fetch_assoc($result)) {
            // Highlight search terms in title and content
            $title = htmlspecialchars($row['title']);
            $content = htmlspecialchars($row['content']);
            $highlightedTitle = preg_replace("/($searchQuery)/i", "<strong>$1</strong>", $title);
            $highlightedContent = preg_replace("/($searchQuery)/i", "<strong>$1</strong>", $content);

            // Display each search result as a list item
            $search_results .= "<li><strong>" . $highlightedTitle . "</strong><br>" . $highlightedContent . "</li>";
        }
        $search_results .= "</ul></div>";
    } else {
        $search_results = "<p>No results found for \"" . htmlspecialchars($searchQuery) . "\".</p>";
    }
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <style>
        /* Add your custom CSS styles here */
        .search-results {
            margin-top: 20px;
        }

        /* Add CSS for highlighting */
        strong {
            background-color: yellow;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <?php echo $search_results; ?>
    </div>
</body>

</html>
