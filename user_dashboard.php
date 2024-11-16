<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

// Fetch courses from the database
$stmt = $conn->prepare("SELECT * FROM courses");
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Courses</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <header class="dashboard-header">
        <h1>Welcome to Your Dashboard</h1>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="course-container">
        <h2>Available Courses</h2>
        <div class="course-grid">
            <?php if (!empty($courses)) : ?>
                <?php foreach ($courses as $course) : ?>
                    <div class="course-card">
                        <h3><?php echo htmlspecialchars($course['course_name']); ?></h3>
                        <p><?php echo htmlspecialchars($course['description']); ?></p>
                        <!-- Modify the button to link to course details page with course_id as a URL parameter -->
                        <a href="course_details.php?course_id=<?php echo $course['id']; ?>">
                            <button>View Details</button>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No courses available at the moment.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer class="dashboard-footer">
        <p>&copy; 2024 Course Management System</p>
    </footer>
</body>
</html>
