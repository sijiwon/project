
<?php
    $id = $_REQUEST["id"];
    $pw = $_REQUEST["pw"];

    if ($id && $pw) {

      if (!is_numeric($id)) {
        ?>
        <script>
          alert("옳바르지 않은 아이디 값입니다.");
          location.replace('login_main.php');
        </script>
        <?php
      }
        require("db_connect.php");

        $query = $db->query("select * from member where id=$id and pw='$pw'");
        if ($row = $query->fetch()) {
            session_start();

            $_SESSION["userId"] = $row["id"];
            $_SESSION["userName"] = $row["nick"];

            if ($row["id"] == 12345678) {
              header("Location:./admin/admin.php");
              exit;
            }else{
              header("Location:index.php");
              exit;
            }
        }
        echo '<script>
            alert("등록되지 않은 계정입니다.");
            location.replace("login_main.php");
          </script>';
      } else {
          echo '<script>
              alert("아이디 또는 비밀번호가 입력되지 않았습니다.");
              location.replace("login_main.php");
            </script>';
      }
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

  <script>
    alert('아이디 또는 비밀번호가 틀렸습니다.');
    history.back();
  </script>

</body>
</html>
