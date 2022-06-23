 <?php
 session_start();

	$userName = empty($_SESSION["userName"]) ? '로그인/회원가입' : $_SESSION["userName"];
	$userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];
	$userNum = empty($_REQUEST["user_num"]) ? '' : $_REQUEST["user_num"];

	require("db_connect.php");

		$select_user = empty($_REQUEST["select_user"]) ? '' : $_REQUEST["select_user"];
    $store_index = empty($_REQUEST["store_index"]) ? '' : $_REQUEST["store_index"];
    $rep_index = empty($_REQUEST["rep_index"]) ? '' : $_REQUEST["rep_index"];



// set_time_limit(0);
//
// function test()
// {
// echo '10초마다 수행 : '.date('Y-m-d (H:i:s)').'<br />';
// }
//
// function test2()
// {
// echo '5초 후 한 번 수행 : '.date('Y-m-d (H:i:s)').'<br />';
// }
//
// $chk_test2 = 0;
// $c = 1;
// while (1)
// {
// echo '기본 : '.date('Y-m-d (H:i:s)').'<br />';
// if ( $c%10==0 ) test(); // 10마다 후 실행
// if ( $c%5==0 && !$chk_test2 ) { $chk_test2 = 1; test2(); } // 5초 후 한 번 실행
// flush();
// sleep(1); // 1초씩 지연
// $c++;
// }


	?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>캠퍼스 마켓</title>
    <link rel="stylesheet" type="text/css" href="css/burger_menu.css">
    <link rel="stylesheet" type="text/css" href="css/chatting.css">
	<link rel="stylesheet" type="text/css" href="css/common.css">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@300&display=swap" rel="stylesheet">
    <style media="screen">

    </style>

  </head>
  <body>
  <script src="https://code.jquery.com/jquery-3.6.0.slim.js"></script>
    <div id="wrap"> <!-- footer가 계속 화면 하단에 있도록 해주는 역할 -->
      <!-- 헤더 -->
     <header>
	  <!--<div id="header_wrap">-->
        <!-- 로고 -->
        <div class="logo_header">
          <a href="index.php">
            <img src="./img/logo.png" alt="캠퍼스마켓">
          </a>
        </div>
        <!-- 검색창 -->
        <div class="search_header">
          <form action="board_main.php" method="get">
            <input type="text" name="search" value=""
            placeholder="검색어를 입력하세요." onfocus="this.placeholder=''" onblur="this.placeholder='검색어를 입력하세요.'"
             class="search_text">
            <input type="image" src="./img/search_img.png" alt="검색하기" class="search_img">
          </form>
        </div>
		<!--햄버거 메뉴-->
		<input class="burger-check" type="checkbox" id="burger-check"/><label class="burger-icon" for="burger-check" style="background-color : white; padding : 20px 45px 20px 15px; border-radius : 5px 0px 0px 5px;"><span class="burger-sticks"></span></label>
		  <div class="menu">
			<div style="width: 200px;"> <!--텍스트 밀림 방지-->
			  <ul class="menu_wrap">
				<li id="login_burger"><a OnClick="mypageCheck()" class="header_right"><?=$userName?></a></li>
				<li><a href="index.php">홈</a></li>
				<li><a href="board_main.php?cate=book">전공/교양 교재</a></li>
				<li><a href="board_main.php?cate=tool">실습 도구</a></li>
				<li><a OnClick="saleCheck()" style="cursor : pointer;">판매하기</a></li>
        <li id='burger_chat'><a href="campus_chatting.php">캠퍼스 채팅</a></li>
        <?php
        if ($userId == 12345678) {
          ?>
          <li><a href="./admin/admin.php?cate=tool">관리자 페이지</a></li>
        <?php
          }
         ?>
			  </ul>
			</div>
		  </div>
        <!--캠퍼스 채팅-->
        <div class="campus_chat_header">
      <a OnClick="location.href='campus_chatting.php'" class="header_right">캠퍼스 채팅</a>
        </div>
        <!-- 로그인/회원가입 -->
        <div class="login_header">
			<a OnClick="mypageCheck()" class="header_right"><?=$userName?></a>
        </div>
      </header>
      <!-- GNB -->
       <nav class="GNB">
		<div class="GNB_wrap">
			<ul>
				<li><a href="board_main.php?cate=book">전공/교양 교재</a></li>
				<li><a href="board_main.php?cate=tool">실습 도구</a></li>
        <?php
        if ($userId == 12345678) {
          ?>
          <li><a href="./admin/admin.php?cate=tool">관리자 페이지</a></li>
        <?php
          }
         ?>
			</ul>
			<div class="GNB_right sale_btn" OnClick="saleCheck()">판매하기</div>
		</div>
      </nav>
      <!-- 메인 -->
      <main>
		<section id="chatting_wrap">
			<article id="user_list_wrap"> <!--사용자 선택-->
        <div>
				<ul class="user_list" style="overflow : auto; height: 700px;">
				<?php
        $chat_user_list = $db->query("select * from chat where b_user_id = '$userId' or a_user_id = '$userId' group by rep_index");
				while($row = $chat_user_list->fetch()){
          if ($userId == $row['a_user_id']){
            $chat_user_name = $row['b_user_id'];
          } else {
            $chat_user_name = $row['a_user_id'];
          }
				?>
					<li onclick="location.href='campus_chatting.php?rep_index=<?=$row['rep_index']?>&select_user=<?=$chat_user_name?>'"><!--?현재페이지로 선택한 사용자 데이터-->
						<div class="user_profile"><img src="./img/profile.png"></div>
						<span><?=$chat_user_name?></span>
					</li>
				<?php
				}
				?>
				</ul>
      </div>
			</article><!--사용자 선택 END-->
			<article id="chat_view"> <!--채팅 부분-->
        <div id="unselect">
  				<div class="chatting_default"><img src="./img/chatting_img.png"></div>
  				<div class="chatting_default_text">채팅할 상대를 선택해주세요</div>
        </div>

        <div id="selected" style="width : 100%;">
				<div class="chatting_view_top">
				<!--사용자 리스트 화면으로-->
					<div id="chat_back_btn" onclick="location.href='campus_chatting.php'"><</div>
				<!--사용자 프로필, 더보기-->
					<div class="user_profile chat_top_profile"><img src="./img/profile.png"></div>
					<span><?=$select_user?></span>
					<input class="more-check" type="checkbox" id="more-check"/><label class="more-icon" for="more-check" style="padding : 10px;"><span class="more-circle"></span></label>
					<div class="more_menu">
						<ul class="more_wrap">
							<li class="more_options"><a href="#">알림음 끄기</a></li>
							<li class="more_options"><a href="#">상대 차단하기</a></li>
							<li class="more_options"><span onclick="chat_room_exit(<?=$rep_index?>)">채팅방 나가기</span></li>
						</ul>
					</div>
				</div><!--chatting_view_top END-->
				<!--채팅 내역-->
				<div class="chatting_view_main">
          <?php
          $query = $db->query("select * from chat where rep_index = '$rep_index' order by regdt");
          while($row = $query->fetch()){
            if ($userId == $row['send_user_id']){
           ?>
           <!--본인 채팅-->
           <div class="chatting_right">
           <span class="chat_regtime"><?=substr($row['regdt'],0,16)?></span>
             <div class="my_chat_wrap speech_balloon">
               <div>
                 <div class="my_chat"><?=$row['rep_text']?>
                 <?php
                    if ($row['store_index'] != null){
                      ?>
                      <br><br><a href="board_view.php?num=<?=$row['store_index']?>" class="first_chat">게시글 상세보기</a>
                      <?php
                    }
                  ?>
               </div>
             </div>
             </div>
           </div>
           <?php
         } else if ($select_user == $row['send_user_id']){
           ?>
           <!--상대방 채팅-->
   					<div class="chatting_left">
   						<div class="user_profile chat_profile"><img src="./img/profile.png"></div>
   						<div class="other_user_chat_wrap speech_balloon">
   							<div>
                  <div class="other_user_chat"><?=$row['rep_text']?>
                    <?php
                       if ($row['store_index'] != null){
                         ?>
                         <br><br><a href="board_view.php?num=<?=$row['store_index']?>" class="first_chat">게시글 상세보기</a>
                         <?php
                       }
                     ?>
                  </div>
                </div>
   						</div>
   						<span class="chat_regtime"><?=substr($row['regdt'],0,16)?></span>
   					</div>
           <?php
          }
          }
          ?>
				</div><!--chatting_view_main END-->

				<div class="msg_write">
					<form action="msg_send.php" method="get">
            <input name="select_user" type="text" value="<?=$select_user?>" style="visibility : hidden; display : none;">
            <input name="rep_index" type="text" value="<?=$rep_index?>" style="visibility : hidden; display : none;">
						<textarea class="textarea_msg" type="text" name="send_msg" rows="2" id="msg_write"
						placeholder="메세지를 입력해주세요."
						onfocus="this.placeholder=''"
						onblur="this.placeholder='메세지를 입력해주세요.'"
						onkeydown="textCount()"
						onkeyup="textCount()"
						onkeypress="textCount()"
						></textarea>
						<div class="msg_write_bottom">
							<span class="text_limit"><input id="text_count" value="0" readonly>/1000</span>
							<input id="msg_submit" type="submit" disabled value="전송">
			      </div>
        </div>
        </div>
			</article><!--채팅 내역 END-->
		</section>
	  </main>
    </div> <!-- wrap END -->
    <!-- 푸터 -->
    <footer>
      <div id="footer_content">
        <div class="logo_footer">
          <img src="./img/logo_footer.png" alt="캠퍼스마켓">
        </div>
        <div class="title_footer">신구대학교 교재, 도구 중고 거래 사이트</div>
        <div class="studentID"><span class="enter">6조&nbsp </span> 2017132078 권은진, 2020136179 강민지, <span class="enter2">2019136177 시지원, 2019136030 천서정</span></div>
        <nav>
          <a href="privacy_policy.php" class="privacyPolicy">개인청보처리방침</a>
          <a href="terms_of_service.php" class="tos">이용약관</a>
        </nav>
      </div>
    </footer>
    <!-- Channel Plugin Scripts -->
  <script>
    (function() {
      var w = window;
      if (w.ChannelIO) {
        return (window.console.error || window.console.log || function(){})('ChannelIO script included twice.');
      }
      var ch = function() {
        ch.c(arguments);
      };
      ch.q = [];
      ch.c = function(args) {
        ch.q.push(args);
      };
      w.ChannelIO = ch;
      function l() {
        if (w.ChannelIOInitialized) {
          return;
        }
        w.ChannelIOInitialized = true;
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = 'https://cdn.channel.io/plugin/ch-plugin-web.js';
        s.charset = 'UTF-8';
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
      }
      if (document.readyState === 'complete') {
        l();
      } else if (window.attachEvent) {
        window.attachEvent('onload', l);
      } else {
        window.addEventListener('DOMContentLoaded', l, false);
        window.addEventListener('load', l, false);
      }
    })();
    ChannelIO('boot', {
      "pluginKey": "a1e6b6cf-3f80-4483-b6f6-6e9ea8082e59"
    });
  </script>
  <!-- End Channel Plugin -->
  </body>
  </html>
<script>
	/*세션 가져오기*/
  let loginState = '<?php echo $userName ?>';
  let loginId = '<?php echo $userId ?>';

	let selectUser = '<?php echo $select_user ?>';
</script>
<script src="js/campus_market_javascript.js"></script>
