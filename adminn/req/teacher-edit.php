<?php
session_start();
include '../../DB_connection.php';
include "../dataa/teacher.php";
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {

        if (isset($_POST['fname'])      &&
            isset($_POST['lname'])      && 
            isset($_POST['username'])   &&
            isset($_POST['teacher_id']) &&
            isset($_POST['address']) &&
            isset($_POST['employee_number']) &&
            isset($_POST['phone_number']) &&
            isset($_POST['qualification']) &&
            isset($_POST['email_address']) &&
            isset($_POST['gender']) &&
            isset($_POST['date_of_birth']) &&
            isset($_POST['sections']) &&
            isset($_POST['subjects'])   &&
            isset($_POST['grades'])) {

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $uname = $_POST['username'];

            $address = $_POST['address'];
            $employee_number = $_POST['employee_number'];
            $phone_number = $_POST['phone_number'];
            $qualification = $_POST['qualification'];
            $email_address = $_POST['email_address'];
            $gender = $_POST['gender'];
            $date_of_birth = $_POST['date_of_birth'];

            $teacher_id = $_POST['teacher_id'];

            $grades = implode(',', $_POST['grades']);
            $subjects = implode(',', $_POST['subjects']);
            $sections = implode(',', $_POST['sections']);

            $data = 'teacher_id='.$teacher_id;

            if (empty($fname)) {
                $em = "First name is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($lname)) {
                $em = "Last name is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($uname)) {
                $em = "Username is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (!unameIsUnique($uname, $conn, $teacher_id)) {
                $em = "Username is taken! try another";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($address)) {
                $em = "Address is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($employee_number)) {
                $em = "Employee number is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($phone_number)) {
                $em = "Phone number is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($qualification)) {
                $em = "Qualification is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($email_address)) {
                $em = "Email address is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($gender)) {
                $em = "Gender is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($date_of_birth)) {
                $em = "Date of birth is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else {
                $sql = "UPDATE teachers SET 
                username = ?, fname=?, lname=?, subjects=?, grades=?,
                address =?, employee_number=?, date_of_birth=?, phone_number=?,
                qualification=?, gender=?, email_address=?, section=? 
                
                WHERE teacher_id=?";

                $stmt = $conn->prepare($sql);
                $stmt->execute([$uname, $fname, $lname, $subjects, $grades,
                $address, $employee_number, $date_of_birth, $phone_number,
                $qualification, $gender, $email_address, $sections,   $teacher_id ]);

                $sm = "Successfully updated!";
                header("Location: ../teacher-edit.php?success=$sm&$data");
                exit;
            }

        } else {
            $em = "An error occurred";
            header("Location: ../teacher.php?error=$em");
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
