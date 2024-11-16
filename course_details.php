<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

// Check if course_id is set
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    // Fetch the course details from the database
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = :course_id");
    $stmt->bindParam(':course_id', $course_id);
    $stmt->execute();
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        echo "Course not found.";
        exit();
    }
} else {
    echo "Invalid course ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <link rel="stylesheet" href="styles5.css">
</head>
<body>
    <header class="dashboard-header">
        <h1>Course Details</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="course-details-container">
        <h2><?php echo htmlspecialchars($course['course_name']); ?></h2>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($course['description']); ?></p>
    </main>

    <footer class="dashboard-footer">
        <p>&copy; 2024 Course Management System</p>
    </footer>
</body>
</html>
