<?php
 session_start();

	$userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];
	$userNum = empty($_REQUEST["user_num"]) ? '' : $_REQUEST["user_num"];
	$member_id = $_REQUEST["id"];
	?>
<style type="text/css">
  body,select,option,button{font-size:16px}
  input{border:1px solid #999;font-size:14px;padding:5px 10px}
  input,button,select,option{vertical-align:middle}
  form{width:700px;margin:auto}
  input[type=checkbox]{width:20px;height:20px}
  span{font-size:14px;color:#f00}
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
  			<article id="member_wrap">
          <!--페이지 이름-->
          <div class="member_title">회원정보 수정</div>
          <!--유저 정보 입력하는 곳-->
          <?php
            require("db_connect.php");
            $query = $db->query("select * from member where id = $member_id");
            while ($row = $query->fetch()){
           ?>
  				<form action="ad_member_update.php" method="post" class="member_form" name="memberUpdate">
					<ul id="write_form">




						<li>
							<div class="member_text">닉네임</div>
							<input class="member_write" type="text" name="update_name" value="<?=$row['nick']?>"
							placeholder="닉네임을 입력해주세요." onfocus="this.placeholder=''" onblur="this.placeholder='닉네임을 입력해주세요.'">
						</li>
			<li>
              <div class="member_text">사용자 아이디</div>
              <input class="member_write" type="text" name="selected_member_id" value="<?=$member_id?>" readonly">
            </li>
            <li>
              <div class="member_text">새 비밀번호</div>
              <input class="member_write" type="password" name="update_new_pw"
              placeholder="비밀번호 8~12자리를 입력해주세요." onfocus="this.placeholder=''" onblur="this.placeholder='비밀번호 8~12자리를 입력해주세요.'">
            </li>
						<li>
							<div class="member_text">비밀번호</div>
							<input class="member_write" type="password" name="update_pw"
							placeholder="기존의 비밀번호를 입력해주세요." onfocus="this.placeholder=''" onblur="this.placeholder='기존의 비밀번호를 입력해주세요.'">
						</li>
					</ul>
          <div class="agreement">새 비밀번호를 입력하지 않을 경우 기존의 비밀번호가 유지됩니다.</div>

          <?php
          }
         ?>
  			</article>
  		</section>
	  </main>

    <p class="btn_wrap">
        <button type="button" class="btn" onclick="history.back()">이전으로</button>
        <button type="button" class="btn" onclick="location.href='memberlist.php'">홈으로</button>
        <button type="button" class="btn" onclick="del_check()">회원탈퇴</button>
        <button type="submit" class="btn" >정보수정</button>
    </p>

</form>


      

<!-- <-- 
						<li>
							<div class="member_text">닉네임</div>
							<input class="member_write" type="text" name="update_name" value="<?=$row['nick']?>"
							placeholder="닉네임을 입력해주세요." onfocus="this.placeholder=''" onblur="this.placeholder='닉네임을 입력해주세요.'">
						</li>
            <li>
              <div class="member_text">새 비밀번호</div>
              <input class="member_write" type="password" name="update_new_pw"
              placeholder="비밀번호 8~12자리를 입력해주세요." onfocus="this.placeholder=''" onblur="this.placeholder='비밀번호 8~12자리를 입력해주세요.'">
            </li>
						<li>
							<div class="member_text">비밀번호</div>
							<input class="member_write" type="password" name="update_pw"
							placeholder="기존의 비밀번호를 입력해주세요." onfocus="this.placeholder=''" onblur="this.placeholder='기존의 비밀번호를 입력해주세요.'">
						</li>
					</ul>
          <div class="agreement">새 비밀번호를 입력하지 않을 경우 기존의 비밀번호가 유지됩니다.</div>


-->