<?php
session_start();

	$userName = empty($_SESSION["username"]) ? '로그인/회원가입' : $_SESSION["username"];
	$userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];
	 $userNum = empty($_REQUEST["user_num"]) ? '' : $_REQUEST["user_num"];

 require("db_connect.php");

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
   <meta charset="utf-8">
   <title>캠퍼스 마켓</title>
   <link rel="stylesheet" type="text/css" href="css/burger_menu.css">
   <link rel="stylesheet" type="text/css" href="css/mainPage.css">
   <link rel="stylesheet" type="text/css" href="css/login_find.css">
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
				<li><a OnClick="saleCheck()" style="cursor : pointer;">판매하기</a></li>
				<li id='burger_chat'><a href="campus_chatting.php">캠퍼스 채팅</a></li>
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
			</ul>
			<div class="GNB_right sale_btn" OnClick="saleCheck()">판매하기</div>
		</div>
      </nav>
     <!-- 메인 -->
   <main>
     <section>
       <article id="login_find_wrap">
         <!--페이지 이름-->
         <div class="login_find_title">아이디 찾기</div>
         <!--유저 정보 입력하는 곳-->
         <form action="find_member_id.php" method="get" class="member_form">
           <input class="login_find_write" type="text" name="user_email" value=""
             placeholder="이메일" onfocus="this.placeholder='', this.value='@g.shingu.ac.kr'" onblur="this.placeholder='이메일'">
           <!--버튼-->
           <div class="find_btn">
             <input type="submit" value="찾기" id="find_submit">
           </div>
         </form> <!--login_form END-->
         <!--멤버 찾기-->
           <ul class="find_member">
             <li><a href="find_member_id_form.php">아이디 찾기</a></li>
             <li>|</li>
			 <li><a href="find_member_pw_form.php">비밀번호 찾기</a></li>
           </ul>
       </article>
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
 </body>
 <script>
	/*세션 가져오기*/
	let loginState = '<?php echo $userName ?>';
  let loginId = '<?php echo $userId ?>';
</script>
<script src="js/campus_market_javascript.js"></script>
