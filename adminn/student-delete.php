<?php
    include "../DB_connection.php";
    include "dataa/student.php";
    session_start();
    if (isset($_SESSION['admin_id']) && 
        isset($_SESSION['role'])     &&
        isset($_GET['student_id'])) {

    if ($_SESSION['role'] == 'Admin'){ 

    $id = $_GET['student_id'];
    if (removeStudent($id, $conn)){
        $sm = "Successfully deleted!";
        header("Location: student.php?success=$sm");
        exit;
    }else{
        $em = "Unknown error occrred";
        header("Location: student.php?error=$em");
        exit;
    }

    
}else {
    header("Location: student.php");
    exit;
}

}else {
      header("Location: teacher.php");
      exit;
} 
    
 ?>       