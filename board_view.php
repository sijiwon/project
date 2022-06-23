<?php
session_start();

	$userName = empty($_SESSION["userName"]) ? '로그인/회원가입' : $_SESSION["userName"];
	$userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];

  $num = empty($_REQUEST["num"]) ? '' : $_REQUEST["num"];
//  $userNum = empty($_REQUEST["user_num"]) ? '' : $_REQUEST["user_num"];
  $cate = empty($_REQUEST["cate"]) ? "free" : $_REQUEST["cate"];
	$search = empty($_REQUEST["search"]) ? "" : $_REQUEST["search"]; //입력한 검색어
 	$page = empty($_REQUEST["page"]) ? 1 : $_REQUEST["page"]; // 페이지 번호 지정

 require("db_connect.php");
  $board_check_count = $db->query("select count(*) from board_free where num = '$num'");
	$board_check = $board_check_count->fetchColumn();
	if ($board_check == '0') {
		?>
				<script>
						alert('존재하지 않는 게시글입니다.');
						history.back();
				</script>
		<?php
	}


	$location_nav_title = '';
	$category = $db->query("select * from board_free where num = '$num'");
  if ($row = $category->fetch()) {
		if ($row['cate'] == 'book') {
			$location_nav_title = '전공/교양 교재';
		} else if ($row['cate'] == 'tool') {
			$location_nav_title = '실습 도구';
		}
		$cate = $row['cate'];
	}
	$writer_id = '';
	$img_find_count = $db->query("select count(*) from file as F, board_free as B where F.f_num = B.num and B.num = $num");
	$slide_img_find_count = $db->query("select count(*) from file as F, board_free as B where F.f_num = B.num and B.num = $num");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
   <meta charset="utf-8">
   <title>캠퍼스 마켓</title>
   <link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/burger_menu.css">
   <link rel="stylesheet" type="text/css" href="css/login_find.css">
   <link rel="stylesheet" type="text/css" href="css/item.css">
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
   <section id="board_view_wrap">
		 <div class="location_nav">
			 <button type="button" OnClick="location.href='index.php'"><img src="./img/home_ic_icon.png"></button>
			 <span>></span>
			 <button type="button" OnClick="location.href='board_main.php?cate=<?=$cate?>&page=<?=$page?>&search<?=$search?>'"><?=$location_nav_title?></button>
		 </div>
		<!--이미지뷰-->
      <section id="board_view_img_wrap">
		 <div id="board_img_wrap">
            <div class="slides">
							<?php
							$file_count = 0;
							$img_num = $img_find_count->fetch();
							if ($img_num[0] == 0 && $file_count == 0){
									$file_src = "./img/chatbot_profile_white.jpg";
									?>
	               	<div class="view_img"><img src="<?=$file_src?>"></div>
	 								<?php
							} else {
								$img_find = $db->query("select * from file as F, board_free as B where F.f_num = B.num and B.num = $num");
								while ($img_one = $img_find->fetch()) { //이미지
									$file_src = "./files/".$img_one['fm_num']."/".$img_one['f_img']."";
									$file_count++;
									?>
		               <div class="view_img"><img src="<?=$file_src?>"></div>
	 								<?php
								}
							}
							 ?>
            </div>
		  </div>
        </section>
		<!--아이템 정보-->
		<section id="board_view_info_wrap">
			<?php
						$query = $db->query("select * from board_free where num = '$num'");
						while ($row = $query->fetch()) {
							$member_id = $row["member_id"];
							$cate = $row["cate"];
			 ?>
      	<!--글 작성자일 경우에만 보임-->
			<div class="writer_view">
				<input type="button" value="수정" OnClick="location.href='board_write.php?num=<?=$row["num"]?>'">
				<input type="button" value="삭제" OnClick="board_delete_click(<?=$row["num"]?>, '<?=$row["cate"]?>')">
			</div>
			<!--writer_view END-->
			<div class="view_title"><?=str_replace(" ", "&nbsp",$row["title"])?></div>
			<div class="view_info view_state"><?=$row["state"]?></div>
			<div class="view_info"><span>판매자</span><span class="view_right"><?=$row["member_id"]?></span></div>
			<div class="view_info"><span>가격</span><span class="view_right"><?=number_format($row["price"])?>원</span></div>
			<div class="chatting" onclick="chattingCheck(<?=$row["member_id"]?>, <?=$row["num"]?>, '<?=$row["title"]?>')">채팅</div>
        </section>
		<!--이미지 슬라이드-->
		<section id="board_view_slide_wrap">
			<div class="board_slide_btn">
      <button type="button" id="left_btn"><img src="./img/left_button.png" alt=""></button>
							<?php
							$slide_file_count = 0;
							$img_num_slide = $slide_img_find_count->fetch();
							if ($img_num_slide[0] == 0 && $slide_file_count == 0){
								$file_src = "./img/chatbot_profile_white.jpg";
								?>
 			  		  		<div class="slide_imgs"><img src="<?=$file_src?>"></div>
 								<?php
							} else {
								$slide_img_find = $db->query("select * from file as F, board_free as B where F.f_num = B.num and B.num = $num");
								while ($img_slide = $slide_img_find->fetch()) { //이미지
										$file_src = "./files/".$img_slide['fm_num']."/".$img_slide['f_img']."";
										$slide_file_count++;
							 ?>
			  		  <div class="slide_imgs"><img src="<?=$file_src?>"></div>
							<?php
							}
						};
							 ?>
					<button type="button" id="right_btn"><img src="./img/right_button.png" alt=""></button>
            </div>
		</section>
		<!--아이템 상세 설명-->
		<section id="board_view_explain_wrap">
			<div class="explain_title">상세 설명</div>
			<div class="explain_text">
      <?=str_replace("\n", "<br>", str_replace(" ", "&nbsp",$row["content"]))?> <!--str_replace("문자열에서 변경하고싶은 문자", "이 문자로 변경", "문자열" )-->
            </div>
        </section>
				<?php
				 }
			 ?>
     </section>
   </main>
   </div>
   <!-- wrap END -->
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
	let mid = '<?php echo $member_id ?>';
</script>
<script src="js/campus_market_javascript.js"></script>
<script>
		writerCheck();
		boardImgChange();
</script>
