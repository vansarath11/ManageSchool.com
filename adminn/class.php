<?php
$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "sms_db";
            
$conn = mysqli_connect($sName, $uName, $pass, $db_name);
            
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$gradesQuery = "SELECT * FROM grades";
$sectionQuery = "SELECT * FROM section";
$classQuery = "SELECT * FROM class";

$gradesResult = mysqli_query($conn, $gradesQuery);
$sectionResult = mysqli_query($conn, $sectionQuery);
$classResult = mysqli_query($conn, $classQuery);

if (!$gradesResult || !$sectionResult || !$classResult) {
    die("Query execution failed: " . mysqli_error($conn));
}

mysqli_close($conn);
?>

<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "dataa/class.php";
        include "dataa/grade.php";
        include "dataa/section.php";
        $classes = getAllClasses($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Class</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.jpg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php
include "incc/navbar.php";
if ($classes != 0) {
?>
    <div class="container mt-5">
        <a href="class-add.php" class="btn btn-dark">Add New Class</a>
        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger mt-3 n-table" role="alert">
                <?= $_GET['error'] ?>
            </div>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-info mt-3 n-table" role="alert">
                <?= $_GET['success'] ?>
            </div>
        <?php } ?>
        <div class="table-responsive">
    <table class="table table-bordered mt-3 n-table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Class</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        while ($gradeRow = mysqli_fetch_assoc($gradesResult)) {
            $sectionRow = mysqli_fetch_assoc($sectionResult);
            $classRow = mysqli_fetch_assoc($classResult);
            
            if ($gradeRow === null || $sectionRow === null || $classRow === null) {
                break;
            }

            echo "<tr>";
            echo "<th scope='row'>$i</th>";
            echo "<td>{$gradeRow['grade_code']} - {$gradeRow['grade']} {$sectionRow['section']}</td>";
            echo "<td>";
            echo "<a href='class-delete.php?class_id={$classRow['class_id']}' class='btn btn-danger'>Delete</a>";
            echo "</td>";
            echo "</tr>";

            $i++;
        }
?>

            </tbody>
        </table>
    </div>
    </div>

<?php } else { ?>
    <div class="alert alert-info .w-450 m-5" role="alert">
        Empty!
    </div>
<?php } ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $("#navLinks li:nth-child(6) a").addClass('active');
    });
</script>
<div>

</div>
</body>
</html>
<?php
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>