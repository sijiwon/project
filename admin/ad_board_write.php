<?php
session_start();

   $userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];
   $userNum = empty($_REQUEST["user_num"]) ? '' : $_REQUEST["user_num"];
  // $num = $_REQUEST["num"];

    $num = empty($_REQUEST["num"]) ? null : $_REQUEST["num"];
    $title = "";
    $cate = "";
    $price = "";
    $content ="";
    $state = "";
    //$img = "";
    $action = "ad_board_update.php";

    if ($num) {
      require("db_connect.php");
      $query = $db->query("select * from board_free where num = $num");
      if ($row = $query->fetch()) {
          $title = $row["title"];
          $cate = $row["cate"];
          $price = $row["price"];
          $content = $row["content"];
          $state = $row["state"];
        //$img = $row["img"];
        $action = "ad_board_update.php";
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
<style type="text/css">
  body,select,option,button{font-size:16px}
  input{border:1px solid #999;font-size:14px;padding:5px 10px}
  input,button,select,option{vertical-align:middle}
  form{width:700px;margin:auto}
  input[type=checkbox]{width:20px;height:20px}
  span{font-size:14px;}
  legend{font-size:20px;text-align:center}
  p span{display:block;margin-left:130px}
  button{cursor:pointer}
  .txt{display:inline-block;width:120px}
  .btn{background:#fff;border:1px solid #999;font-size:14px;padding:4px 10px}
  .btn_wrap{text-align:center}

</style>


        <!-- 메인 -->
        <main>
  		<section>
  			<article id="board_wrap">
          <!--페이지 이름-->
          <div class="board_title">게시글 수정</div>
          <!--유저 정보 입력하는 곳-->
          <?php
            require("db_connect.php");
            $query = $db->query("select * from board_free where num = $num");
            while ($row = $query->fetch()){
           ?>
  				<form action="ad_board_update.php" method="post" class="board_form" name="boardUpdate">
					<ul id="write_form">
			<li>
					<div class="item_text">글 번호</div>
					<input type="text" value="<?=$num?>" name="num" readonly>
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
								<input id="tool" type="radio" name="cate" value="tool" <?php select_cate($cate, "tool") ?> ><label for="tool"><span>실습 도구</span></label>
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


          <?php
          }
         ?>
  			</article>
  		</section>
	  </main>

    <p class="btn_wrap">
        <button type="button" class="btn" onclick="history.back()">이전으로</button>
        <button type="button" class="btn" onclick="del_check()">게시글삭제</button>
        <button type="submit" class="btn" >정보수정</button>
    </p>

</form>
