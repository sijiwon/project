<?php
session_start();
    $userName = empty($_SESSION["userName"]) ? '로그인/회원가입' : $_SESSION["userName"];
    $userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];

    $update_nick = $_REQUEST["update_name"];
    $update_pw = $_REQUEST["update_pw"];

        if ($update_nick && $update_pw) {
          $update_new_pw = empty($_REQUEST["update_new_pw"]) ? $update_pw :  $_REQUEST["update_new_pw"];
          if (strlen($update_pw) < 8 || strlen($update_pw) > 12 || strlen($update_new_pw) < 8 || strlen($update_new_pw) > 12) {
            ?>
                <script>
                    alert('비밀번호는 8~12자리만 입력할 수 있습니다');
                    location.replace("member_update_form.php");
                </script>
            <?php
          } else {

          require("db_connect.php");
          $pw_check = $db->query("select * from member where id = $userId");
          if ($row = $pw_check->fetch()){
              if ($row['pw'] == $update_pw) {

                $query = $db->exec("update member set nick='$update_nick', name='$update_nick', pw='$update_new_pw' where id = $userId");
                $_SESSION["userName"] = $update_nick;
      ?>
                    <script>
                        alert('수정이 완료되었습니다.');
                        location.replace('mypage.php');
                    </script>
      <?php
              } else {
                echo "<script>
                       alert('비밀번호가 일치하지 않습니다.');
                       location.replace('member_update_form.php');
                   </script>";
          }
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
