<?php
include "../../assets/php/config.php"; // Include your database configuration file

// Check if the request method is POST
if (isset($_GET['image-exists'])) {
    
    $requestData = json_decode(file_get_contents('php://input'), true);
    $imageName = $requestData['imageName'];

    // Prepare a parameterized query to check if the image exists
    $query = "SELECT COUNT(*) AS count FROM teams WHERE profile = ?";
    $stmt = $pdo->prepare($query);

    // Bind the image name parameter to the prepared statement
    $stmt->bindParam(1, $imageName, PDO::PARAM_STR);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return JSON response indicating whether the image exists or not
        header('Content-Type: application/json');
        if ($result['count'] > 0) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }
    } else {
        // Error handling if the query execution fails
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'Failed to execute the query']);
    }
} else {
    // If the request method is not POST, return an error response
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
