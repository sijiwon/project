<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<?php
    session_start();

    // $_REQUEST["action"] 값에 따라 세션변수 생성 또는 삭제
    $action = isset($_REQUEST["action"]) ? $_REQUEST["action"] : "";
    
    if ($action == "create") 
        $_SESSION["id"] = "test";
    else if ($action == "delete") 
    unset($_SESSION["id"]);
   
   // 세션변수는 등록 즉시 사용 가능하므로
    // 프로그램을 다시 실행할 필요가 없음
    
    // 세션변수 읽기
    $session = isset($_SESSION["id"]) ? $_SESSION["id"] : "";
?>
        
 세션변수 userid의 값 : <?= $session ?><br>
 <a href="?action=create">세션변수 생성</a><br>
 <a href="?action=delete">세션변수 삭제</a>
 
 </body>
 </html>
