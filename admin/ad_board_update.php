<?php
  session_start();


  $userName = $_SESSION["userName"];
  $userId = $_SESSION["userId"];


  $num = $_REQUEST["num"];
  
  $title = $_REQUEST["title"];
  $cate = $_REQUEST["cate"];
  $state = $_REQUEST["state"];
  $price = $_REQUEST["price"];
  $content = $_REQUEST["content"];
  // $uploaded_img = new Array();
  // empty($_POST["uploded_img"]) ? null : $_POST["uploded_img"];
  // $uploded_img_tmp = new Array();
  //   empty($_POST["uploded_img_tmp"]) ? null : $_POST["uploded_img_tmp"];

    if ( $price && $title && $state && $cate && $content) {
        require("db_connect.php");

        $edit_time = date("Y-m-d H:i:s");

        // if (count($_FILES['img_upload']['name']) == 0) {
        //   $img_name = 'chatbot_profile_white.jpg';
        // }
       
        $query = $db->exec("update board_free set title='$title', cate='$cate', state='$state', price='$price',
         content='$content', edit_date='$edit_time' where num = $num");
        ?>
        <script>
			alert("게시물 수정이 완료되었습니다.");
			location.replace("boardlist.php");
		</script>
        <?php

    }
?>