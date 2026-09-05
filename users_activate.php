<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['role']!=="Admin"){
        header('location:index.php');
    }

    $id = $_GET['id'];

    $activate = $pdo->prepare("UPDATE tbl_user SET is_active = REPLACE(is_active, '0', '1') WHERE user_id=".$id);

    if($activate->execute()){
		header('location:register.php');
    }
?>