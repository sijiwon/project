<?php
session_start();

    $update_nick = $_REQUEST["update_name"];
    $update_new_pw = $_REQUEST["update_new_pw"];
    $update_pw = $_REQUEST["update_pw"];
	$selected_member_id = $_REQUEST["selected_member_id"];

        if ($update_nick && $update_pw) {
          require("db_connect.php");
          $pw_check = $db->query("select * from member where id = $selected_member_id");
          if ($row = $pw_check->fetch()){
              if ($row['pw'] == $update_pw) {

                $update_new_pw = empty($_REQUEST["update_new_pw"]) ? $update_pw :  $_REQUEST["update_new_pw"];

                $query = $db->exec("update member set nick='$update_nick', name='$update_nick', pw='$update_new_pw' where id = $selected_member_id");
      ?>
                    <script>
                        alert('수정이 완료되었습니다.');
                        location.replace('memberlist.php');
                    </script>
      <?php
              } else {
                echo "<script>
                       alert('비밀번호가 일치하지 않습니다.');
                       location.replace('ad_member_update_form.php?id=$selected_member_id');
                   </script>";
          }
        }
      }
?>

 <!doctype html>
 <html>
 <head>
     <meta charset="utf-8">
 </head>
 <body>
   <script>
       alert('빈칸 없이 입력해야 합니다.');
       history.back();
   </script>
</body>
</html>
