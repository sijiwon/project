<?php
  session_start();

  $userName = $_SESSION["userName"];
  $userId = $_SESSION["userId"];

  $num = $_REQUEST["num"];
  $cate = $_REQUEST["cate"];
  require("db_connect.php");
  $query = $db->exec("delete from file where f_num = $num");
  $query = $db->exec("delete from board_free where num = $num");
?>
<script>alert("게시물이 삭제되었습니다.");
location.replace('board_main.php?cate=<?=$cate?>');
</script>
