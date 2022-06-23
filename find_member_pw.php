<?php
session_start();

	$userName = empty($_SESSION["userName"]) ? '로그인/회원가입' : $_SESSION["userName"];
	//$userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];
	$userEmail = empty($_REQUEST["user_email"]) ? '' : $_REQUEST["user_email"];
  $user_id = empty($_REQUEST["user_id"]) ? '' : $_REQUEST["user_id"];

			if ($userEmail && $user_id){ //이메일 값이 있다면
					require("db_connect.php");
					$id_check = $db->query("select * from member where email = '$userEmail'");
				if ($row = $id_check->fetch()) {
					?>
					<script>
					location.replace('email_check.php?join_email=<?=$userEmail?>&page=findPw&user_pw=<?=$row["pw"]?>','캠퍼스 마켓','width=500px,height=500px');
					</script>
					 <?php
				 }else{
 ?>
						 <script>
							 alert("등록된 회원 정보가 존재하지 않거나 일치하지 않습니다.");
							 history.back();
						 </script>
<?php
					}
			} else {
		?>
		<script>
			alert("빈 칸 없이 입력해주세요.");
			history.back();
		</script>
<?php
	}
	?>
