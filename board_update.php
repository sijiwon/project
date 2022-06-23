<?php
  session_start();


  $userName = $_SESSION["userName"];
  $userId = $_SESSION["userId"];

  $save_path="./files/".$userId."/";

  if(!is_dir($save_path)){
    mkdir($save_path, 0777, true);
  };

  $num = $_REQUEST["num"];
	$title = $_REQUEST["title"];
  $cate = $_REQUEST["cate"];
  $state = $_REQUEST["state"];
	$price = $_REQUEST["price"];
	$content = $_REQUEST["content"];
  $uploaded_img = empty($_POST["uploded_img"]) ? null : $_POST["uploded_img"];
  $uploded_img_tmp =  empty($_POST["uploded_img_tmp"]) ? null : $_POST["uploded_img_tmp"];
  // $uploaded_img = new Array();
  // empty($_POST["uploded_img"]) ? null : $_POST["uploded_img"];
  // $uploded_img_tmp = new Array();
  //   empty($_POST["uploded_img_tmp"]) ? null : $_POST["uploded_img_tmp"];

    if ( $price && $title && $state && $cate && $content) {
        if (!is_numeric($price)) {
          ?>
          <script>
            alert("가격은 숫자만 입력할 수 있습니다.");
            location.replace('board_write.php');
          </script>
          <?php
        }

        require("db_connect.php");

        $edit_time = date("Y-m-d H:i:s");

        // if (count($_FILES['img_upload']['name']) == 0) {
        //   $img_name = 'chatbot_profile_white.jpg';
        // }
        $query = $db->exec("delete from file where f_num = $num");
        if($uploaded_img != null) {
          for($i=0; $i<count($uploaded_img); $i++){
          $query = $db->exec("insert into file (fm_num, f_img, f_num, tmp_name) values ($userId, '$uploaded_img[$i]', $num, '$uploded_img_tmp[$i]')");
          }
        }

        if (json_encode($_FILES['img_upload']['name']) != '[""]'){
        $countfiles = isset($_FILES['img_upload']['name'])?count($_FILES['img_upload']['name']) : 0;

        for($i=0; $i<$countfiles; $i++){
           $img_tmp = $_FILES["img_upload"]["tmp_name"][$i];
           $img_name = $_FILES["img_upload"]["name"][$i];
           $img_type = $_FILES["img_upload"]["type"][$i];
           $img_error = $_FILES["img_upload"]["error"][$i];
           echo $img_tmp;
           echo $img_name;
           echo $img_type;
           echo $img_error;
             move_uploaded_file($img_tmp, "./files/".$userId."/$img_name");
             $query = $db->exec("insert into file (fm_num, f_img, f_num, tmp_name) values ($userId, '{$img_name}', $num, '{$img_tmp}')");
         }
       }

        $query = $db->exec("update board_free set title='$title', cate='$cate', state='$state', price='$price',
         content='$content', edit_date='$edit_time' where num = $num");
         ?>
         <script>
             alert("게시물 수정이 완료되었습니다.");
             location.replace("board_view.php?cate=<?=$cate?>&num=<?=$num?>");
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
    history.back();
</script>

</body>
</html>
