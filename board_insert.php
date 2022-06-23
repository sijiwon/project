<?php
  session_start();


   $userName = $_SESSION["userName"];
   $userId = $_SESSION["userId"];

  $save_path="./files/".$userId."/";

  if(!is_dir($save_path)){
    mkdir($save_path, 0777, true);
  };

	$title = $_REQUEST["title"];
  $cate = $_REQUEST["cate"];
  $state = $_REQUEST["state"];
	$price = $_REQUEST["price"];
	$content = $_REQUEST["content"];

  $reg_date = date("Y-m-d H:i:s");

    if ( $price && $title && $state && $cate && $content) {
        require("db_connect.php");
        if (!is_numeric($price)) {
          ?>
          <script>
            alert("가격은 숫자만 입력할 수 있습니다.");
            location.replace('board_write.php');
          </script>
          <?php
        }
        $reg_time = date("Y-m-d H:i:s");

        $countfiles = isset($_FILES['img_upload']['name'])?count($_FILES['img_upload']['name']) : 0;

        // for($i=0; $i<=$countfiles; $i++){
        // $img_tmp[$i] = $_FILES["img_upload"]["tmp_name"][$i];
           // $img_name[$i] = $_FILES["img_upload"]["name"][$i];
           // $img_type[$i] = $_FILES["img_upload"]["type"][$i];
           // $img_error[$i] = $_FILES["img_upload"]["error"][$i];
         // }

        $query = $db->exec("insert into board_free (title, cate, state, price, content, reg_date, edit_date, member_id)
                             values ('$title', '$cate', '$state', '$price', '$content', '$reg_date', '$reg_date', '$userId')");

       $num = $db->query("select num from board_free where member_id = '$userId' and reg_date = '$reg_date'");
       if (json_encode($_FILES['img_upload']['name']) != '[""]'){
         if ($row = $num->fetch()){
          for($i=0; $i<$countfiles; $i++){
            $img_tmp = $_FILES["img_upload"]["tmp_name"][$i];
            $img_name = $_FILES["img_upload"]["name"][$i];
            // if ($img_name == null) { # 첨부된 이미지 파일 없을 때
            //   $img_tmp = 'chatbot_profile_white.jpg';
            //   $img_name = 'chatbot_profile_white.jpg';
            // }
                move_uploaded_file($img_tmp, "./files/".$userId."/$img_name");
                $query = $db->exec("insert into file (fm_num, f_img, f_num, tmp_name) values ($userId, '{$img_name}', ".$row['num'].", '{$img_tmp}')");
            }
          }
        }

        ?>
        <script>
          alert("업로드가 완료되었습니다.");
          location.replace("board_main.php?cate=<?=$cate?>");
        </script>
        <?php
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<script>
    alert('모든 입력란에 값이 입력되어야 합니다.');
    location.replace('board_write.php');
</script>

</body>
</html>
