 <?php
 session_start();


	$userName = empty($_SESSION["userName"]) ? '로그인/회원가입' : $_SESSION["userName"];
	$userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];

     $num = empty($_REQUEST["num"]) ? null : $_REQUEST["num"];
     $title = "";
     $cate = "";
     $price = "";
     $content ="";
     $state = "";
     $action = "board_insert.php";

     if ($num) {
       require("db_connect.php");
       $query = $db->query("select * from board_free where num = $num");
       if ($row = $query->fetch()) {
    	   $title = $row["title"];
    	   $cate = $row["cate"];
    	   $price = $row["price"];
    	   $content = $row["content"];
    	   $state = $row["state"];
         $action = "board_update.php";
       }
    }

    function select_state($state, $value) {
       if ($state == $value) {
         echo "selected";
       }
    }

    function select_cate($cate, $value) {
       if ($cate == $value) {
         echo "checked";
       }
    }
	?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>캠퍼스 마켓</title>
    <link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/burger_menu.css">
    <link rel="stylesheet" type="text/css" href="css/mainPage.css">
    <link rel="stylesheet" type="text/css" href="css/item.css">

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
				<li><a href="board_main.php?bid=book">전공/교양 교재</a></li>
				<li><a href="board_main.php?bid=tool">실습 도구</a></li>
				<li><a OnClick="saleCheck()">판매하기</a></li>
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
  		<section>
  			<article id="item_wrap">
          <!--페이지 이름-->
  				<div class="item_title">상품 정보 입력</div>
          <!--판매글 입력하는 곳-->
  				<form action="<?=$action?>" method="post" class="item_form" method="post" enctype="multipart/form-data">
            <input type="text" value="<?=$num?>" name="num" style="visibility : hidden; display : none;">
					<ul id="write_form">
						<li id="file_li">
							<div class="img_wrap"><label for="file_upload"><img id="file_img" src="./img/file_img.png"></label><input type="file" id="file_upload" name="img_upload[]" multiple onchange="fileUploadCheck(this.value);"></div>
              <span class="upload_fileList">
                <?php
                  $img_count = 0;
                  if ($num != 0) {
                    ?>
                    <?php
                    $img_query = $db->query("select * from board_free as B, file as F where B.num = F.f_num and B.num = $num");
                    while ($row = $img_query->fetch()){
                      $file_src = "./files/".$row['fm_num']."/".$row['f_img']."";
                      ?>
                      <span class="img_file" id="<?=$img_count?>">
                        <img src="<?=$file_src?>" name="imgs" style="width : 200px">
                        <input type="text" value="<?=$row['f_img']?>" name="uploded_img[]" style="visibility : hidden; display : none;">
                        <input type="text" value="<?=$row['tmp_name']?>" name="uploded_img_tmp[]" style="visibility : hidden; display : none;">
                        <a href="#" id="removeImg" onclick="UpdateDeleteImg(<?=$img_count?>)">╳</a>
                      </span>
                    <?php
                      $img_count++;
                    }
                  }
                 ?>
              </span>
              <span class="fileList">
              </span>
						</li>
						<li>
							<div class="item_text">말머리</div>
							<select class="state_select" type="text" name="state">
								<option value="판매중" <?php select_state($state, "판매중") ?>>판매중</option>
								<option value="판매완료" <?php select_state($state, "판매완료") ?>>판매완료</option>
							</select>
						</li>
						<li>
							<div class="item_text">제목</div>
							<input class="title_write" type="text" name="title" value="<?=$title?>"
							placeholder="상품 제목을 입력해주세요." onfocus="this.placeholder=''" onblur="this.placeholder='상품 제목을 입력해주세요.'">
						</li>
						<li>
							<div class="item_text">카테고리</div>
							<span id="category_select">
								<input id="book" type="radio" name="cate" value="book" <?php select_cate($cate, "book") ?> ><label for="book"><span>전공/교양 교재</span></label>
								<input id="tool" type="radio" name="cate" value="tool" <?php select_cate($cate, "tool") ?>><label for="tool"><span>실습 도구</span></label>
							</span>
						</li>
						<li>
							<div class="item_text">가격</div>
							<input class="price_write" type="text" name="price" value="<?=$price?>"
							placeholder="숫자만 입력해주세요." onfocus="this.placeholder=''" onblur="this.placeholder='숫자만 입력해주세요.'"><span id="price_unit">원</span>
						</li>
						<li id="explain_li">
							<div class="item_text explain_write_title">상세 설명</div>
							<textarea class="explain_write" type="text" name="content" rows="8"
								placeholder="상품 설명을 입력해주세요."
								onfocus="this.placeholder=''"
								onblur="this.placeholder='상품 설명을 입력해주세요.'"><?=$content?></textarea>
						</li>
					</ul>
					<!--버튼-->
					<div class="board_btns">
						<button type="button" onClick="location.href='board_main.php?cate=book'">취소</button>
						<input type="submit" value="등록하기">
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
          <img src="img/logo_footer.png" alt="캠퍼스마켓">
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
</script>
<script src="js/campus_market_javascript.js"></script>
<script>
  	explainWriteSize(window_width);
    boardUpdateImg(<?=$img_count?>);
</script>
