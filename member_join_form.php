 <?php
 session_start();

	$userName = empty($_SESSION["userName"]) ? '로그인/회원가입' : $_SESSION["userName"];
  $userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];

	$join_id = empty($_REQUEST["join_id"]) ? '' : $_REQUEST["join_id"];
	$join_name = empty($_REQUEST["join_name"]) ? '' : $_REQUEST["join_name"];
   $join_email = empty($_REQUEST["join_email"]) ? '' : $_REQUEST["join_email"];
   $sended_verification_code = empty($_REQUEST["sended_verification_code"]) ? '' : $_REQUEST["sended_verification_code"];
   $join_verification_code = empty($_REQUEST["join_verification_code"]) ? '' : $_REQUEST["join_verification_code"];
	require("db_connect.php");
	?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>캠퍼스 마켓</title>
    <link rel="stylesheet" type="text/css" href="css/burger_menu.css">
    <link rel="stylesheet" type="text/css" href="css/member.css">
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
            <img src="img/logo.png" alt="캠퍼스마켓">
          </a>
        </div>
        <!-- 검색창 -->
        <div class="search_header">
          <form action="board_main.php" method="post">
            <input type="text" name="search" value=""
            placeholder="검색어를 입력하세요." onfocus="this.placeholder=''" onblur="this.placeholder='검색어를 입력하세요.'"
             class="search_text">
            <input type="image" src="img/search_img.png" alt="검색하기" class="search_img">
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
  			<article id="member_wrap">
          <!--페이지 이름-->
  				<div class="member_title">회원가입</div>
          <!--유저 정보 입력하는 곳-->
  				<form action="member_join.php" method="get" class="member_form" name="memberJoin">
            <ul id="write_form">
  						<li>
  							<div class="member_text">닉네임</div>
  							<input class="member_write" type="text" name="join_name" value="<?=$join_name?>"
  							placeholder="닉네임을 입력해주세요." onfocus="this.placeholder=''" onblur="this.placeholder='닉네임을 입력해주세요.'">
  						</li>
  						<li>
  							<div class="member_text">아이디</div>
  							<input class="member_write" type="text" name="join_id" value="<?=$join_id?>"
  							placeholder="학번을 입력해주세요." onfocus="this.placeholder=''" onblur="this.placeholder='학번을 입력해주세요.'">
  						</li>
  						<li>
  							<div class="member_text">비밀번호</div>
  							<input class="member_write" type="password" name="join_pw" value=""
  							placeholder="비밀번호 8~12자리를 입력해주세요." onfocus="this.placeholder=''" onblur="this.placeholder='비밀번호 8~12자리를 입력해주세요.'">
  						</li>
  						<li id="email_write">
  							<div class="member_text">이메일</div>
  							<input class="member_write_email" type="text" name="join_email" value="<?=$join_email?>"
  							placeholder="이메일을 입력해주세요." onfocus="this.placeholder=''" onblur="this.placeholder='이메일을 입력해주세요.'">
  							<div id="shingu_email">@ g.shingu.ac.kr</div>
  							<button class="verification_code" type="button" onclick='emailCheck()'>인증하기</button>
  						</li>
  					<?php
  						//if (/*이메일value가 있다면*/){
  					?>
  						<li>
  							<div class="member_text">인증번호</div>
                <input type="text" value="<?=$sended_verification_code?>" name="sended_verification_code" id="sended_verification_code" style="visibility : hidden; display : none;">
  							<input class="member_write" type="text" name="join_verification_code" value=""
  							placeholder="이메일로 전송된 인증번호를 입력해주세요." onfocus="this.placeholder=''" onblur="this.placeholder='이메일로 전송된 인증번호를 입력해주세요.'">
  						</li>
  					<?php
  						//}
  					?>
  					</ul>
					<div class="agreement">가입 시 <input type="button" value="이용약관" onclick="window.open('terms_of_service.php', 'popup', 'width=1024px, height=auto')"> 및
						<input type="button" value="개인정보 취급방침" onclick="window.open('privacy_policy.php', 'popup', 'width=1024px, height=auto')">에 동의합니다.</div>
					<!--버튼-->
					<div class="member_btns">
						<button type="button" OnClick="location.href ='login_main.php'" class="">취소</button>
						<input type="submit" value="회원가입" id="login_submit">
					</div>
				</form> <!--join_form END-->
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
</html>
<script>
	/*세션 가져오기*/
  let loginState = '<?php echo $userName ?>';
  let loginId = '<?php echo $userId ?>';
</script>
<script src="js/campus_market_javascript.js"></script>
