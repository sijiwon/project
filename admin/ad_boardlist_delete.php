<?php
  session_start();

 $num = $_REQUEST["num"];
 require("db_connect.php");
 $query = $db->exec("delete from file where f_num=$num");
 $query = $db->exec("delete from board_free where num = $num");                         
?>
<script>		
	alert("삭제 되었습니다.");
	location.replace("boardlist.php");
</script>
