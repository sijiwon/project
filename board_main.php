 <?php
 session_start();

	$userName = empty($_SESSION["userName"]) ? '로그인/회원가입' : $_SESSION["userName"];
	$userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];

	require("db_connect.php");

  $cate = empty($_REQUEST["cate"]) ? "free" : $_REQUEST["cate"]; //어떤 게시판인지 선택
	$search = empty($_REQUEST["search"]) ? "" : $_REQUEST["search"]; //입력한 검색어

	$numLines = 8; // 보이게 할 게시글 수
	$numLinks = 5; // 한 페이지에 표시할 페이지 링크개수

	$page = empty($_REQUEST["page"]) ? 1 : $_REQUEST["page"]; // 페이지 번호 지정
	$start = ($page - 1) * $numLines; // 보이게할 레코드 번호

	if ($cate == "book") { /*게시판이 교재일 때*/
		$title = '전공/교양 교재';
		/*게시글 가져오기*/
		$query = $db->query("select * from board_free where cate='book' order by num desc limit $start, $numLines");

	} else if ($cate == "tool"){
		$title = '실습 도구';
		$query = $db->query("select * from board_free where cate='tool' order by num desc limit $start, $numLines");

	} else {
    if ($search == ""){
      echo "<script>alert('검색어를 입력해주세요.'); history.back();</script>";
    } else {
      $title = '"'.$search.'"검색 결과' ;
      $query = $db->query("select * from board_free where title like '%$search%' or content like '%$search%' order by num desc limit $start, $numLines");
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
    <link rel="stylesheet" type="text/css" href="css/board.css">
    <style media="screen">

    </style>

  </head>
  <body>
  <script src="https://code.jquery.com/jquery-3.6.0.slim.js"></script>
    <div id="wrap"> <!-- footer가 계속 화면 하단에 있도록 해주는 역할 -->
      <!-- 헤더 -->
		<header>
        <!-- 로고 -->
        <div class="logo_header">
          <a href="index.php">
            <img src="./img/logo.png" alt="캠퍼스마켓">
          </a>
        </div>
        <!-- 검색창 -->
        <div class="search_header">
          <form action="board_main.php" method="get">
            <input type="text" name="search" value="<?=$search?>"
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
        <!--게시글-->
        <section class="board">
			<div class="board_wrap"> <!-- 전공/교양 최신 게시글 -->
				<div class="board_title"> <!-- 게시글 타이틀 -->
					<span class="board_name"><?=$title?></span>
				</div>
				<div class="clear"></div>
				<div class="board_list">
					<?php
          $result_count = 0;
            while ($row = $query->fetch()) {
              if (mb_strlen($row["title"]) >= 17) { //mb_strlen("문자열")  문자열 길이 측정
                $row["title"] = substr($row["title"],0,17).'...';
              }

              $img_find_count = $db->query("select count(*) from file as F, board_free as B where F.f_num = B.num and B.num = ".$row['num']."");
              $img_find_num = $img_find_count->fetch();
              if ($img_find_num[0] == 0){
                $file_src = './img/chatbot_profile_white.jpg';
              } else {
                $img_find = $db->query("select * from file as F, board_free as B where F.f_num = B.num and B.num = ".$row['num']."");
                if($img_one=$img_find->fetch()){
                  $file_src = "./files/".$img_one['fm_num']."/".$img_one['f_img']."";
                }
              }

					?>
						<ul class="boards boards_bottom" onclick="location.href='board_view.php?cate=<?=$row["cate"]?>&num=<?=$row["num"]?>&page=<?=$page?>'">
              <li class="board_img"> <!--제품이미지-->
								<img src="<?=$file_src?>">
							</li>
							<li class="board_items">
								<span class="item_name"><?=$row["title"]?></span><br>
								<span class="item_price"><?=number_format($row["price"])?>원</span>
							</li>
						</ul>
					<?php
          $result_count++;
						}
            if ($cate == 'free' && !$result_count) {
          ?>
            <h1 style="margin : 100px;">"<?=$search?>"과(와) 일치하는 검색결과가 없습니다.</h1>
          <?php
            }
					?>
				</div>
				<?php
				$firstLink = floor(($page - 1) / $numLinks) * $numLinks + 1;
				$lastLink = $firstLink + $numLinks - 1;
        if ($cate == 'free') {
          $numRecords = $db->query("select count(*) from board_free where title like '%$search%' or content like '%$search%'")->fetchColumn();
        } else {
				  $numRecords = $db->query("select count(*) from board_free where cate='$cate'")->fetchColumn(); //
        }
				$numPages = ceil($numRecords/$numLines); //게시판 테이블 레코드 수
				if ($lastLink > $numPages) {
					$lastLink = $numPages;
				}

				?>
				<div class = "paging">
				<?php
				/*이전 페이지*/
				if ($firstLink > 1) {
				?>
					<a class="page_btn" href = "board_main.php?cate=<?=$cate?>&page=<?=$firstLink - $numLinks?>"><</a>
				<?php
				}else {
				?>
					<span class="overPage"><</span>
				<?php
				}
				/*페이지 수*/
				for ($i = $firstLink; $i <= $lastLink; $i++) {
					if ($page == $i) {
				?>
					<a class="nowPage" href = "board_main.php?cate=<?=$cate?>&page=<?=$i?>&search=<?=$search?>"><?=($i == $page) ? "<b>$i</b>" : $i?></a>
				<?php
					continue;
					}
				?>
					<a class="page_list" href = "board_main.php?cate=<?=$cate?>&page=<?=$i?>&search=<?=$search?>"><?=($i == $page) ? "<b>$i</b>" : $i?></a>
				<?php
				}
				/*다음 페이지*/
				if ($lastLink < $numPages) {
				?>
					<a class="page_btn" href = "board_main.php?cate=<?=$cate?>&page=<?=$firstLink + $numLinks?>&search=<?=$search?>">></a>
				<?php
				} else {
				?>
					<span class="overPage">></span>
				<?php
				}
				?>
				</div>

				</div>
			</div>
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
</script>
<script src="js/campus_market_javascript.js"></script>
