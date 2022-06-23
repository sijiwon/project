<?php
session_start();


 $userName = empty($_SESSION["userName"]) ? '로그인/회원가입' : $_SESSION["userName"];
 $userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];
 $seller = $_REQUEST["seller"]; //member_id
 $store_index = $_REQUEST["store_index"]; //num
$title = $_REQUEST["title"]; //member_id

   $reg_date = date("Y-m-d H:i:s");

   if ($userId == $seller) {
     ?>
     <script>
       alert("자신이 업로드한 게시물입니다.");
       history.back();
     </script>
     <?php
   } else {

require("db_connect.php"); //auser : 판매자, buser : 구매자(먼저 채팅 건 사람)
$chatroom_check=$db->query("select count(*) from chat where store_index=$store_index and b_user_id='$userId'");
$count = $chatroom_check->fetchColumn();
if ($count == '0'){
   $query = $db->exec("insert into chat (store_index, a_user_id, b_user_id, rep_text, regdt, send_user_id)
                        values ($store_index, '$seller', '$userId', '$title','$reg_date', '$userId')");
   $query = $db->exec("update chat set rep_index = chat_num where store_index=$store_index and b_user_id='$userId'");
  }

  $chatroom=$db->query("select * from chat where store_index=$store_index and b_user_id='$userId'");
  $rep_index = '';
   if ($row = $chatroom->fetch()) {
     $rep_index = $row['rep_index'];
   }
    header("Location:campus_chatting.php?select_user=$seller&rep_index=$rep_index");
    exit();
  }
?>
