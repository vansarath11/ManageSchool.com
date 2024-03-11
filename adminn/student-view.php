<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "dataa/student.php";
        include "dataa/subject.php";
        include "dataa/grade.php";
        include "dataa/section.php";

        if (isset($_GET['student_id'])) {
            $student_id = $_GET['student_id'];
            $student = getStudentById($student_id, $conn);
        } else {
            $student = 0;
        }
    } else {
        header("Location: ../teacher.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student - Teacher</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.jpg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include "incc/navbar.php"; ?>
    <div class="container mt-5">
        <?php if ($student != 0) { ?>
           
            <div class="card" style="width: 22rem;">
                    <img src="../img/student-<?= $student['gender']?>.jpg" 
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-center">@<?= $student['username']; ?></h5>
                        
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">First name:  <?= $student['fname']; ?></li>
                        <li class="list-group-item">Last name:  <?= $student['lname']; ?></li>
                        <li class="list-group-item">Username:  <?= $student['username']; ?></li>
                        <li class="list-group-item">Address:  <?= $student['address']; ?></li>
                        <li class="list-group-item">Date of birth:  <?= $student['date_of_birth']; ?></li>
                        <li class="list-group-item">Email:  <?= $student['email_address']; ?></li>
                        <li class="list-group-item">Gender:  <?= $student['gender']; ?></li>
                        <li class="list-group-item">Date of joined:  <?= $student['date_of_joined']; ?></li>

                        <li class="list-group-item">Grade: 
                        <?php 
                            $grade = $student['grade'];
                            $g = getGradeById($grade, $conn);                
                            echo $g['grade_code'].'-'.$g['grade'];
                            ?>
                        </li>

                        <li class="list-group-item">Section: 
                        <?php 
                            $section = $student['section'];
                            $s = getSectioById($section, $conn);
                            echo $s['section'];
                            ?>
                        </li>
                        <li class="list-group-item">Parent first name:  <?= $student['parent_fname']; ?></li>
                        <li class="list-group-item">Parent last name:  <?= $student['parent_lname']; ?></li>
                        <li class="list-group-item">Parent phone number:  
                            <?= $student['parent_phone_number']; ?></li>

                    </ul>
                    <div class="card-body">
                        <a href="student.php" class="card-link">Go Back</a>
                    </div>
            </div>


        <?php
        } else {
            header("Location: student.php");
            exit;
        } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#navLinks li:nth-child(3) a").addClass('active');
        });
    </script>
</body>
</html>