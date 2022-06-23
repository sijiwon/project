/*세션가져오기*/
let loginState = window.sessionStorage.getItem("userName");

	/*캠퍼스 채팅 보이기*/
	if(loginState) {
		let campusChat = document.getElementsByClassName('campus_chat_header');
		campusChat[0].style.display = "block";
		campusChat[0].style.visibility = "visible";
	}

/*마이페이지 연결*/
function mypageCheck(){
	  if(loginState==null){  //로그인 상태X
		location.replace("login_main.php");
	  }
	  else{ //로그인 상태O
		 location.replace("mypage.php");
	  }
}

/*판매하기 연결*/
function chattingCheck(){
	  if(loginState==null){  //로그인 상태X
		location.replace("login_main.php");
	  }
	  else{ //로그인 상태O
		 location.replace("board_write.php");
	  }
}

/*캠퍼스 채팅 연결*/
function saleCheck(){
	  if(loginState==null){  //로그인 상태X
		location.replace("login_main.php");
	  }
	  else{ //로그인 상태O
		 location.replace("campus_chatting.php");
	  }
}
