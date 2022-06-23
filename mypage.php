<?php
session_start();

		$userName = empty($_SESSION["userName"]) ? '로그인/회원가입' : $_SESSION["userName"];
		$userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];
	 $userNum = empty($_REQUEST["user_num"]) ? '' : $_REQUEST["user_num"];

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
   <meta charset="utf-8">
   <title>캠퍼스 마켓</title>
   <link rel="stylesheet" type="text/css" href="css/burger_menu.css">
   <link rel="stylesheet" type="text/css" href="css/mypage.css">
   <link rel="stylesheet" type="text/css" href="css/common.css">
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
          <form action="board_main.php" method="post">
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
    <section id="mypage_wrap">
		<section id="mypage_member_wrap">
			<div class="profile">
				<div class="profile_img"><img src="./img/profile.png"></div>
				<p><?=$userName?></p>
			</div>
			<div class="mypage_link" onclick="location.href='member_update_form.php'">회원정보 수정</div>
			<div class="mypage_link" onclick="member_out()">회원탈퇴</div>
			<div class="mypage_link" onclick="logout_click()">로그아웃</div>
		</section>

		<section id="mypage_list_wrap">
		<div class="sale_list_title">판매내역</div>
			<ul class="sale_list vertical_scroll">
			<?php
			 require("db_connect.php");
			 $query = $db->query("select * from board_free where member_id = $userId");
			while ($row = $query->fetch()){
				if (mb_strlen($row["title"]) >= 20) { //mb_strlen("문자열")  문자열 길이 측정
					$row["title"] = substr($row["title"],0,20).'...';
				}
			?>
				<li class="mypage_link" onclick="location.href='board_view.php?num=<?=$row["num"]?>'"><?=$row['title']?></li>
			<?php
			};
			?>
			</ul>
		</section>
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

	/*회원탈퇴*/
	function member_out(){
			var i = confirm("정말 탈퇴하시겠습니까? 탈퇴 시 모든 정보가 삭제됩니다.");

			if(i == true){
					// alert("delete.php?u_idx="+idx);
					location.replace("member_delete.php");
			};
	};
</script>
<script src="js/campus_market_javascript.js"></script>
