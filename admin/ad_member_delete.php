<?php
session_start();


$userId = $_SESSION["userId"];
$selected_member_id = $_REQUEST["selected_member_id"];
require("db_connect.php");
$query = $db->query("delete  from member where id = $selected_member_id");
?>
<script>
	alert("삭제 되었습니다.");
	location.replace("memberlist.php");
</script>

