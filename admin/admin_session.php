<?php
session_start();

$userId = isset($_SESSION["userId"])? $_SESSION["userId"]:"";
$userName = isset($_SESSION["userName"])? $_SESSION["userName"]:"";

/* 관리자가 아닌 경우 index문서로 이동 */
if(!$userId || ($userId != "12345678")){
    echo "
        <script type=\"text/javascript\">
            alert(\"관리자 로그인이 필요합니다.\");
            location.href = \"/index.php\";
        </script>
    ";
};    
?>