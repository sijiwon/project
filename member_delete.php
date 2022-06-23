<?php
session_start();


$userId = $_SESSION["userId"];
require("db_connect.php");
$query = $db->query("delete from member where id = $userId");
$query = $db->exec("delete from file where fm_num = $userId");
$query = $db->exec("delete from board_free where member_id = '$userId'");
$query = $db->exec("delete from chat where a_user_id = '$userId' or b_user_id = '$userId'");

unset($_SESSION["userId" ]);
unset($_SESSION["userName"]);

?>
<script>
	alert("삭제 되었습니다.");
	location.replace("index.php");
</script>
