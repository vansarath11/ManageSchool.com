<?php
session_start();
include '../../DB_connection.php';
include "../dataa/teacher.php";
include "../dataa/admin.php";
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {

        if (isset($_POST['admin_pass']) &&
            isset($_POST['new_pass'])   && 
            isset($_POST['c_new_pass']) &&
            isset($_POST['teacher_id'])){

            $admin_pass = $_POST['admin_pass'];
            $new_pass = $_POST['new_pass'];
            $c_new_pass = $_POST['c_new_pass'];

            $teacher_id = $_POST['teacher_id'];
            $id = $_SESSION['admin_id'];

            $data = 'teacher_id='.$teacher_id.'#change_password';

            if (empty($admin_pass)) {
                $em = "Admin password is required";
                header("Location: ../teacher-edit.php?perror=$em&$data");
                exit;
            } else if (empty($new_pass)) {
                $em = "New password is required";
                header("Location: ../teacher-edit.php?perror=$em&$data");
                exit;
            } else if (empty($c_new_pass)) {
                $em = "Confirm new password is required";
                header("Location: ../teacher-edit.php?perror=$em&$data");
                exit;
            } else if ($new_pass !== $c_new_pass){
                $em = "New password and confirm password dose not match";
                header("Location: ../teacher-edit.php?perror=$em&$data");
                exit;
            } else if (!adminPasswordVerify($admin_pass, $conn, $id)){
                $em = "Incorrect admin password";
                header("Location: ../teacher-edit.php?perror=$em&$data");
                exit;
            } else {

                 // Hashing the password
                $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);

                $sql = "UPDATE teachers SET 
                password = ? WHERE teacher_id=?";

                $stmt = $conn->prepare($sql);
                $stmt->execute([$new_pass, $teacher_id ]);

                $sm = "The password has been change successfully!";
                header("Location: ../teacher-edit.php?psuccess=$sm&$data");
                exit;
            }

        } else {
            $em = "An error occurred";
            header("Location: ../teacher-edit.php?error=$em&$data");
            exit;
        }
    } else {
        header("Location: ../../logout.php");
        exit;
    }
} else {
    header("Location: ../../logout.php");
    exit;
}
?>

