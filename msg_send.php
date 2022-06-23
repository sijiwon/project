<?php
session_start();


 $userName = empty($_SESSION["userName"]) ? '로그인/회원가입' : $_SESSION["userName"];
 $userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];
 $select_user = $_REQUEST["select_user"]; //member_id
 $rep_index = $_REQUEST["rep_index"]; //num 게시물 번호
 $send_msg = $_REQUEST["send_msg"];

   $reg_date = date("Y-m-d H:i:s");
 require("db_connect.php"); //auser : 판매자, buser : 구매자(먼저 채팅 건 사람)
   $my_state = '';
   $query = $db->query("select * from chat where rep_index = $rep_index");
   if($row = $query->fetch()){
     if ($row['a_user_id'] == $userId) {
       $my_state = 'a';
     } else if ($row['b_user_id'] == $userId) {
       $my_state = 'b';
     }
   }

 if ($my_state == 'a') {
   echo $my_state;
 $query = $db->exec("insert into chat (rep_index, a_user_id, b_user_id, rep_text, regdt, send_user_id)
                      values ($rep_index, '$userId', '$select_user', '$send_msg', '$reg_date', '$userId')");
}else if ($my_state == 'b') {
  echo $my_state;
 $query = $db->exec("insert into chat (rep_index, a_user_id, b_user_id, rep_text, regdt, send_user_id)
                      values ($rep_index, '$select_user', '$userId', '$send_msg', '$reg_date', '$userId')");
}
 header("Location:campus_chatting.php?select_user=$select_user&rep_index=$rep_index");
 exit();

?>
