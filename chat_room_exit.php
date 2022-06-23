<?php
// session_start();
//
//
//  $userName = empty($_SESSION["userName"]) ? '로그인/회원가입' : $_SESSION["userName"];
//  $userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];
//  $select_user = $_REQUEST["select_user"]; //member_id
 $rep_index = $_REQUEST["rep_index"];

require("db_connect.php");
 $query = $db->exec("delete from chat where rep_index = $rep_index");

    header("Location:campus_chatting.php");
    exit();
?>
