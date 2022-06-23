
let window_width =  window.innerWidth; // 첫 화면 사이즈
campusChatView(window_width);// header부분 캠퍼스 채팅 요소 보이게

/*윈도우 사이즈 받아오기(브라우저 창 크기 조절할 때 실행)*/
window.onresize = function(event) {
	window_width = window.innerWidth;
	explainWriteSize(window_width); //상세설명 세로 사이즈 조정
	campusChatView(window_width); // header부분 캠퍼스 채팅 요소 보이게
	bannerSizeChange(window_width); // 배너 이미지 사이즈 변경
	bannerChange(); //배너 슬라이드 사이즈 변경
	boardImgChange(); // 게시물 상세보기에서 슬라이드 변경
	chattingViewChange(window_width);
};

/*브라우저 실행 시 (html 로딩 끝난 후 시작)*/
window.onload = function() {
	chattingViewChange(window_width); // header부분 캠퍼스 채팅 요소 보이게
};
/*board.js*/
let explain_write = document.querySelector('.explain_write');

/*상세설명 입력칸 세로 사이즈 변경*/
function explainWriteSize(count){
	/* 반응형 */
	/* 큰 데스크탑 */
	if (explain_write){
		if (count > 1200) {
		explain_write.rows=8;
		}
		if (count <= 1100) {
		explain_write.rows=9;
		}
		if (count <= 800) {
		explain_write.rows=15;
		}
	}
}


let img_count = 0;
let uploaded_img_count = 0;
let filesArr = new Array();
let html = new Array();

/*추가된 파일 요소 생성*/
function fileUploadCheck(value) {
			 filesArr = new Array();
			 html = new Array();
        const target = document.getElementsByName('img_upload[]');
				img_count = target.length;
        $.each(target[0].files, function(index, file){
			if(img_count+uploaded_img_count > 4) {
				alert("이미지 파일은 최대 4개까지 등록할 수 있습니다.");
				//document.getElementById('file_upload').value="";
				return;
			}
					$('.fileList').empty();
            const fileName = file.name;
						html[img_count] = '<span class="img_file" id="'+img_count+'">' // class="img_file"
            html[img_count]  += '<img src="'+URL.createObjectURL(file)+'" name="imgs" style="width : 200px">' //미리보기 이미지
            //html[img_count]  += '<a href="#" id="removeImg" onclick="deleteImg()">╳</a>'; //이미지 삭제 버튼
						html[img_count]  += '</span>'

            const fileEx = fileName.slice(fileName.lastIndexOf(".") + 1).toLowerCase(); //파일 이름에서 확장자 부분만 가져오기
            if(fileEx != "jpg" && fileEx != "png" &&  fileEx != "gif" &&  fileEx != "bmp"){
                alert("파일은 (jpg, png, gif, bmp) 형식만 등록 가능합니다.");
                //resetFile();
                return false;
            }
			filesArr.push(html);
      $('.fileList').html(html); // fileList 클래스 태그 안에 위에서 입력한 html 생성
			img_count++; // 추가된 파일 갯수 +1
        });
    };


/*선택된 파일 삭제*/
		function deleteImg(){
			const flist = document.querySelectorAll(".fileList > span"); //.fileList에 있는 span 요소들 가져오기
			let files = $('#file_upload')[0].files;	//사용자가 입력한 파일을 변수에 할당
			console.log(files);
			let fileArray = Array.from(files);	//변수에 할당된 파일을 배열로 변환(FileList -> Array)
			console.log(fileArray);
			flist.forEach((el, index) => { // 가져온 요소들로 반복문을 통해 인덱스 가져옴
				el.onclick = () => { // 해당 인덱스의 요소가 클릭되면
					console.log(fileArray);
					html.splice(index, 1);
					fileArray.splice(index, 1);	//해당하는 index의 파일을 배열에서 제거
					$('.fileList').html(html); // 제거한걸 다시 .fileList에 적용시킴
				}
			});
			img_count--; // 추가된 파일 갯수 -1
			if(img_count <= 0){
				img_count = 0;
			}
		}


	function boardUpdateImg(value) {
			uploaded_img_count = value;
			console.log(uploaded_img_count);
	}

function UpdateDeleteImg(index){
	const flist = document.querySelectorAll(".upload_fileList > span"); //.upload_fileList에 있는 span 요소들 가져오기
	console.log(flist);
	let files = $('.img_file')[0];	//사용자가 입력한 파일을 변수에 할당
	console.log(files);
	let fileArray = Array.from(flist);	//변수에 할당된 파일을 배열로 변환(FileList -> Array)
	console.log(fileArray);
	$('#'+index+'').remove();
	uploaded_img_count--; // 추가된 파일 갯수 -1
	if(img_count <= 0){
		uploaded_img_count = 0;
	}
}


/*게시물 삭제 할 것인지*/
function board_delete_click(b_num, b_cate) {
	if (!confirm('해당 게시물을 삭제 하시겠습니까?')){
		event.preventDefault();
	}else{
		console.log('board_delete.php?num='+b_num+'&cate='+b_cate+'');
		location.href='board_delete.php?num='+b_num+'&cate='+b_cate+'';
	}
}

/*login.js*/
function campusChatView(count){
		/*캠퍼스 채팅 보이기*/
	if(loginState != '로그인/회원가입') {
		let campusChat = document.getElementsByClassName('campus_chat_header');
		let burger_campusChat = document.getElementById('burger_chat');
		/* 반응형 */
		/* 큰 데스크탑 */
		if (count > 1100) {
			campusChat[0].style.display = "block";
			campusChat[0].style.visibility = "visible";

			burger_campusChat.style.display = "none";
			burger_campusChat.style.visibility = "hidden";
		}
		if (count <= 1100) {
			campusChat[0].style.display = "none";
			campusChat[0].style.visibility = "hidden";

			burger_campusChat.style.display = "block";
			burger_campusChat.style.visibility = "visible";
		}

	}
}

/*마이페이지 연결*/
function mypageCheck(){
	  if(loginState=='로그인/회원가입'){  //로그인 상태X
		location.replace("login_main.php");
	  }
	  else{ //로그인 상태O
		 location.replace("mypage.php");
	  }
}

/*판매하기 연결*/
function chattingCheck(seller, store_index, title){
	  if(loginState=='로그인/회원가입'){  //로그인 상태X
		location.replace("login_main.php");
	  }
	  else{ //로그인 상태O
			if (seller!=null) {
		 	location.replace("campus_chatting_connect.php?seller="+seller+"&store_index="+store_index+"&title="+title);
			}else {
			location.replace("campus_chatting.php");
			}
	  }
}

/*캠퍼스 채팅 연결*/
function saleCheck(){
	  if(loginState=='로그인/회원가입'){  //로그인 상태X
		location.replace("login_main.php");
	  }
	  else{ //로그인 상태O
		 location.replace("board_write.php");
	  }
}

/*채팅방 나가기*/
function chat_room_exit(index) {
	if (!confirm('해당 채팅방에서 나가시겠습니까?')){
		event.preventDefault();
	}else{
		location.href='chat_room_exit.php?rep_index='+index+'';
	}
}


/*글 상세보기에서 작성자일 경우*/
function writerCheck(){
	  if(loginState=='로그인/회원가입'){  //로그인 상태X
	  }
	  else{ //로그인 상태O
			if (loginId == mid) {
				let writerView = document.getElementsByClassName('writer_view');
				writerView[0].style.display = "block";
				writerView[0].style.visibility = "visible";
			}
		 }
}

/*마이페이지에서 로그아웃 할 것인지*/
function logout_click() {
	if (!confirm('로그아웃 하시겠습니까?')){
		event.preventDefault();
	}else{
		location.href='logout.php';
	}
}




/*banner.js*/
	const banner = document.querySelector('#banner_wrap');
	const banner_slide = document.querySelector('.banner_slides');
	const bannerImgs = document.querySelectorAll('.banner_img');
	let banner_currentIndex = 0; // 현재 슬라이드 화면 인덱스

	const banner_buttonLeft = document.querySelector('#banner_left_btn');
	const banner_buttonRight = document.querySelector('#banner_right_btn');

/*배너 슬라이드*/
function bannerChange(){
	if (banner) {
		bannerImgs.forEach((bannerImgs) => {
		  bannerImgs.style.width = `${banner.clientWidth}px`; // inner의 width를 모두 outer의 width로 만들기
		})

		banner_slide.style.width = `${banner.clientWidth * bannerImgs.length}px`; // innerList의 width를 inner의 width * inner의 개수로 만들기

		/*
		  버튼에 이벤트 등록하기
		*/

		banner_buttonLeft.addEventListener('click', () => {
		  banner_currentIndex--;
		  banner_currentIndex = banner_currentIndex < 0 ? 0 : banner_currentIndex; // index값이 0보다 작아질 경우 0으로 변경
		  banner_slide.style.marginLeft = `-${banner.clientWidth * banner_currentIndex}px`; // index만큼 margin을 주어 옆으로 밀기
		  clearInterval(banner_interval); // 기존 동작되던 interval 제거
		  banner_interval = banner_getInterval(); // 새로운 interval 등록
		});

		banner_buttonRight.addEventListener('click', () => {
		  banner_currentIndex++;
		  banner_currentIndex = banner_currentIndex >= bannerImgs.length ? bannerImgs.length - 1 : banner_currentIndex; // index값이 inner의 총 개수보다 많아질 경우 마지막 인덱스값으로 변경
		  banner_slide.style.marginLeft = `-${banner.clientWidth * banner_currentIndex}px`; // index만큼 margin을 주어 옆으로 밀기
		  clearInterval(banner_interval); // 기존 동작되던 interval 제거
		  banner_interval = banner_getInterval(); // 새로운 interval 등록
		});
	}
}
/*
	주기적으로 화면 넘기기
*/
const banner_getInterval = () => {
	if(banner){
  return setInterval(() => {
	banner_currentIndex++;
	banner_currentIndex = banner_currentIndex >= bannerImgs.length ? 0 : banner_currentIndex;
	banner_slide.style.marginLeft = `-${banner.clientWidth * banner_currentIndex}px`;
  }, 4000);
	}
}


  let banner_interval = banner_getInterval(); // interval 등록


	let bannerImg1 = document.getElementById("banner_img_change");
	let bannerImg2 = document.getElementById("banner_img_change2");
  /*화면 사이즈에 따라 이미지 변경*/
function bannerSizeChange(count){
	/* 반응형 */
	/* 큰 데스크탑 */
	if (bannerImg1 && bannerImg2) {
		if (count > 1440) {
		bannerImg1.src="./img/banner1_1920.png";
		bannerImg2.src="./img/banner2_1920.png";
		}

		if (count <= 1440) {
			bannerImg1.src="./img/banner1_1440.png";
			bannerImg2.src="./img/banner2_1440.png";
		}

		if (count <= 1023) {
			bannerImg1.src="./img/banner1_768.png";
			bannerImg2.src="./img/banner2_768.png";
		}

		if (count <= 375) {
			bannerImg1.src="./img/banner1_375.png";
			bannerImg2.src="./img/banner2_375.png";
		}
	}
}




/*item_slider.js*/
/*게시물 상세보기부분 슬라이드*/
	const board = document.querySelector('#board_img_wrap');
	const slide = document.querySelector('.slides');
	const boardImgs = document.querySelectorAll('.view_img');
	let currentIndex = 0; // 현재 슬라이드 화면 인덱스

	const buttonLeft = document.querySelector('#left_btn');
	const buttonRight = document.querySelector('#right_btn');
	const slideImgs = document.querySelectorAll('.slide_imgs');


/*이미지 슬라이드*/
function boardImgChange(){
	if (board) {
		boardImgs.forEach((boardImgs) => {
		  boardImgs.style.width = `${board.clientWidth}px`; // inner의 width를 모두 outer의 width로 만들기
		})

		slide.style.width = `${board.clientWidth * boardImgs.length}px`; // innerList의 width를 inner의 width * inner의 개수로 만들기

		/*
		  버튼에 이벤트 등록하기
		*/

		buttonLeft.addEventListener('click', () => {
		  currentIndex--;
		  currentIndex = currentIndex < 0 ? 0 : currentIndex; // index값이 0보다 작아질 경우 0으로 변경
		  slide.style.marginLeft = `-${board.clientWidth * currentIndex}px`; // index만큼 margin을 주어 옆으로 밀기
		  clearInterval(interval); // 기존 동작되던 interval 제거
		  interval = getInterval(); // 새로운 interval 등록
		});

		buttonRight.addEventListener('click', () => {
		  currentIndex++;
		  currentIndex = currentIndex >= boardImgs.length ? boardImgs.length - 1 : currentIndex; // index값이 inner의 총 개수보다 많아질 경우 마지막 인덱스값으로 변경
		  slide.style.marginLeft = `-${board.clientWidth * currentIndex}px`; // index만큼 margin을 주어 옆으로 밀기
		  clearInterval(interval); // 기존 동작되던 interval 제거
		  interval = getInterval(); // 새로운 interval 등록
		});

			function click_img(index){
				slideImgs[index].addEventListener('click', () => {
					currentIndex = index;
					slide.style.marginLeft = `-${board.clientWidth * currentIndex}px`;
					clearInterval(interval); // 기존 동작되던 interval 제거
					interval = getInterval(); // 새로운 interval 등록
				});
			}

		for (var i=0; i<slideImgs.length; i++) {
			click_img(i);
		}
	}
}
/*
	주기적으로 화면 넘기기
*/
const getInterval = () => {
	if (board) {
	  return setInterval(() => {
		currentIndex++;
		currentIndex = currentIndex >= boardImgs.length ? 0 : currentIndex;
		slide.style.marginLeft = `-${board.clientWidth * currentIndex}px`;
	}, 4000);
	}
}

let interval = getInterval(); // interval 등록



/*채팅 글자수 세기*/
function textCount(){
	let num = document.getElementById('msg_write').value.length;
	document.getElementById('text_count').value = num;
	let msg_submit = document.getElementById('msg_submit');
	if(num > 0) {
		msg_submit.style.backgroundColor = "#007EFF"; // 배경색 변경
		msg_submit.style.cursor = "pointer"; //커서 변경
		msg_submit.disabled = false; //버튼 활성화
	} else {
		msg_submit.style.backgroundColor = "#c4c4c4";
		msg_submit.style.cursor = "default";
		msg_submit.disabled = true; //버튼 비활성화
	}
}

let user_list_wrap = document.getElementById('user_list_wrap'); //사용자 선택 화면
let chat_view = document.getElementById('chat_view'); //채팅 내역
let unselect = document.getElementById('unselect');
let selected = document.getElementById('selected');
let chat_back_btn = document.getElementById('chat_back_btn'); //사용자 리스트 화면으로 가는 버튼

/*채팅 화면 변경*/
function chattingViewChange(window_width) {
	if (user_list_wrap && chat_view && chat_back_btn) {
		if (window_width >= 1100) {
			chat_view.style.float = 'right';
			user_list_wrap.style.display = 'inline-block';
			user_list_wrap.style.visibility = 'visible';
			chat_view.style.display = 'inline-block';
			chat_view.style.visibility = 'visible';
			if(selectUser){
				unselect.style.visibility = 'hidden';
				unselect.style.display = 'none';
				selected.style.visibility = 'visible';
				selected.style.display = 'inline-block';
			}else{
				unselect.style.visibility = 'visible'
				unselect.style.display = 'inline-block';
				selected.style.visibility = 'hidden';
				selected.style.display = 'none';
			}
		} else {
			chat_view.style.float = 'none';
			if (selectUser) {
				user_list_wrap.style.display = 'none';
				user_list_wrap.style.visibility = 'hidden';
				chat_view.style.display = 'inline-block';
				chat_view.style.visibility = 'visible';
				unselect.style.visibility = 'hidden';
				unselect.style.display = 'none';
				selected.style.visibility = 'visible';
				selected.style.display = 'inline-block';
			} else {
				user_list_wrap.style.display = 'inline-block';
				user_list_wrap.style.visibility = 'visible';
				chat_view.style.display = 'none';
				chat_view.style.visibility = 'hidden';
			}
		}
	}
}



/*member_join.js*/
/*이메일 입력 확인*/
function emailCheck() {
  form = document.memberJoin; /*form태그의 name을 통해 input값 접근*/
  check = form.join_email.value;
  if (check == '') {
    alert('메일 주소를 입력해주세요.');
    form.join_email.focus();
    return false;
  } else {
    window.open('email_check.php?join_email='+form.join_email.value+'@g.shingu.ac.kr&page=join','캠퍼스 마켓','width=500px,height=500px');
  }
}
