<?php
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['grade_id'])) {

    if ($_SESSION['role'] == 'Admin') {
        
        include "../DB_connection.php";
        include "dataa/grade.php";

        $grades = getAllGrades($conn);

        $grade_id = $_GET['grade_id'];
        $grade = getGradeById($grade_id, $conn);

        if ($grade == 0){
            header("Location: grade.php");
            exit;
        }
        

  
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Grade</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.jpg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include "incc/navbar.php"; ?>
    <div class="container mt-5">
        <a href="grade.php" class="btn btn-dark">Go Back</a><br/><br/>
        <form method="post" class="shadow p-3 mt-5 form-w" action="req/grade-edit.php">
            <h3>Edit Grade</h3><hr>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?=$_GET['error'] ?>
                </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?=$_GET['success'] ?>
                </div>
            <?php } ?>

            <div class="mb-3">
                <label class="form-label">Grade Code</label>
                <input type="text" class="form-control" value="<?= $grade['grade_code'] ?>" 
                        name="grade_code">
            </div>
            <div class="mb-3">
                <label class="form-label">Grade</label>
                <input type="text" class="form-control" value="<?= $grade['grade'] ?>" 
                        name="grade">
            </div>
            <input type="text" class="form-control" value="<?= $grade['grade_id'] ?>" 
                        name="grade_id" hidden>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#navLinks li:nth-child(4) a").addClass('active');
        });
    </script>
</body>
</html>
<?php
    } else {
        header("Location: grade.php");
        exit;
    }
} else {
    header("Location: grade.php");
    exit;
}
?>