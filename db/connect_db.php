<?php
	require("config.php");
    try {
        $pdo = new PDO(
            "mysql:host=$dbhost;dbname=$dbname;charset=utf8",
            $dbuser,
            $dbpass,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
        );
    } catch (PDOException $error) {
        echo $error->getMessage();
    }
?>
