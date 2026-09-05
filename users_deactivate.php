<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['role']!=="Admin"){
        header('location:index.php');
    }

    error_reporting(0);

    $id = $_GET['id'];


    $deactivate = $pdo->prepare("UPDATE tbl_user SET is_active = REPLACE(is_active, '1', '0') WHERE user_id=".$id);

    if($deactivate->execute()){
		header('location:register.php');
    }
?>