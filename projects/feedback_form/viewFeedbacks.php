
<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: adminLogin.php");
    exit;
}
?>

<?php
// DB connection info
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "feedbackv1.0";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch feedbacks
$sql = "SELECT * FROM feedbacks ORDER BY submitted_at DESC";
$result = $conn->query($sql);

// Display
echo "<h2>All Feedback Submissions</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Submitted At</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>" . nl2br(htmlspecialchars($row['message'])) . "</td>
                <td>{$row['submitted_at']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No feedback yet.";
}

$conn->close();
?>

<a href="logout.php">Logout</a>
<a href="adminLogin.php">Admin Login</a>
<a href="feedbackForm.html">Back to Form</a>