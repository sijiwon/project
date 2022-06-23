<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<?php
    $id   = $_REQUEST["join_id"];
    $pw   = $_REQUEST["join_pw"];
    $nick = $_REQUEST["join_name"];
	   $email = $_REQUEST["join_email"];
     $sended_verification_code = $_REQUEST["sended_verification_code"];
     $join_verification_code = $_REQUEST["join_verification_code"];

     $pre_page = "member_join_form.php?join_id=$id&join_name=$nick&join_email=$email&sended_verification_code=$sended_verification_code&join_verification_code=$join_verification_code";
        if ($id && $pw && $nick && $email) {
          if ($sended_verification_code == "") {
            ?>
                      <script>
                          alert('이메일 인증이 필요합니다.');
                          location.replace("<?=$pre_page?>");
                      </script>
            <?php
          }
          if ($sended_verification_code != $join_verification_code) {
            ?>
                      <script>
                          alert('인증번호가 일치하지 않습니다.');
                          location.replace("<?=$pre_page?>");
                      </script>
            <?php
          }
          if (!is_numeric($id)) {
            ?>
            <script>
              alert("옳바르지 않은 아이디 값입니다.");
              location.replace('login_main.php');
            </script>
            <?php
          }
          if (strlen($pw) < 8 || strlen($pw) > 12) {
            ?>
                <script>
                    alert('비밀번호는 8~12자리만 입력할 수 있습니다');
                    location.replace("<?=$pre_page?>");
                </script>
            <?php
          }

          $email = $_REQUEST["join_email"].'@g.shingu.ac.kr';
          require("db_connect.php");
          $reg_date = date("Y-m-d H:i:s");
          $overlap_check = "select count(*) from member where id=$id";
          $overlap_email_check = "select count(*) from member where email='$email'";
          $result = $db->query($overlap_check)->fetchColumn();
          $e_result = $db->query($overlap_email_check)->fetchColumn();

          if ($result == '1') {
?>
              <script>;
                  alert('이미 등록된 아이디입니다.');
                  location.replace("<?=$pre_page?>");
              </script>
<?php
          }
           if ($e_result == '1') {
            ?>
                <script>
                    alert('이미 등록된 계정입니다.');
                    location.replace("<?=$pre_page?>");
                </script>
            <?php
          }else{

            $query = $db->exec("insert into member values ($id, '$pw', '$nick', '$email', '$nick', '$reg_date')");
?>
              <script>
                  alert('가입이 완료되었습니다.');
                  location.replace('login_main.php');
              </script>
<?php
}

      } else {
?>
        <script>
            alert('빈칸 없이 입력해야 합니다.');
            location.replace("<?=$pre_page?>");
        </script>
<?php
      }
 ?>

</body>
</html>
