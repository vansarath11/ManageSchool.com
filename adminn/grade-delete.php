<?php
    include "../DB_connection.php";
    include "dataa/grade.php";
    session_start();
    if (isset($_SESSION['admin_id']) && 
        isset($_SESSION['role'])     &&
        isset($_GET['grade_id'])) {

    if ($_SESSION['role'] == 'Admin'){ 

    $id = $_GET['grade_id'];
    if (removeGrade($id, $conn)){
        $sm = "Successfully deleted!";
        header("Location: grade.php?success=$sm");
        exit;
    }else{
        $em = "Unknown error occrred";
        header("Location: grade.php?error=$em");
        exit;
    }

    
}else {
    header("Location: grade.php");
    exit;
}

}else {
      header("Location: grade.php");
      exit;
} 
    
 ?>       