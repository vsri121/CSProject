<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Add course
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];
    $stmt = $conn->prepare("INSERT INTO courses (course_name, description) VALUES (:course_name, :description)");
    $stmt->execute(['course_name' => $course_name, 'description' => $description]);
}

// Delete course
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM courses WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

$courses = $conn->query("SELECT * FROM courses")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Manage Courses</title>
</head>
<body>
    <h2>Manage Courses</h2>
    <form method="POST">
        <input type="text" name="course_name" placeholder="Course Name" required>
        <textarea name="description" placeholder="Course Description" required></textarea>
        <button type="submit">Add Course</button>
    </form>

    <h3>All Courses</h3>
    <ul>
        <?php foreach ($courses as $course): ?>
            <li>
                <strong><?php echo $course['course_name']; ?></strong> - <?php echo $course['description']; ?>
                <a href="?delete=<?php echo $course['id']; ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>