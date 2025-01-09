<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $date = $_POST['date'];
    $amount = $_POST['amount'];

    // Validate data (optional but recommended)
    if (empty($date) || empty($amount)) {
        echo "Date and amount are required.";
        exit;
    }

    // Create a new mysqli instance
    $con = new mysqli('localhost', 'root', '', 'saving_dashboard');

    // Check for connection error
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Prepare the SQL statement
    $stmt = $con->prepare("INSERT INTO savingtable (Date, Saving_Amount) VALUES (?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }

    // Bind the parameters to the prepared statement
    $stmt->bind_param("sd", $date, $amount);  // "s" for string, "d" for double (float)

    // Execute the query
    if ($stmt->execute()) {
        echo "Data inserted successfully.";
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
} else {
    echo "Invalid request method.";
}
?>
