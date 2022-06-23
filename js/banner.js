
/*윈도우 사이즈 받아오기(브라우저 창 크기 조절할 때 실행)*/
window.onresize = function(event) {
	bannerSizeChange(window.innerWidth);
	bannerChange();
};

/*브라우저 실행 시 (html 로딩 끝난 후 시작)*/
window.onload = function() {
	/*첫 화면 크기 */
	bannerSizeChange(window.innerWidth);
	bannerChange();
};

	const banner = document.querySelector('#banner_wrap');
	const slide = document.querySelector('.slides');
	const bannerImgs = document.querySelectorAll('.banner_img');
	let currentIndex = 0; // 현재 슬라이드 화면 인덱스
	
	const buttonLeft = document.querySelector('#left_btn');
	const buttonRight = document.querySelector('#right_btn');

/*배너 슬라이드*/
function bannerChange(){
	bannerImgs.forEach((bannerImgs) => {
	  bannerImgs.style.width = `${banner.clientWidth}px`; // inner의 width를 모두 outer의 width로 만들기
	})

	slide.style.width = `${banner.clientWidth * bannerImgs.length}px`; // innerList의 width를 inner의 width * inner의 개수로 만들기

	/*
	  버튼에 이벤트 등록하기
	*/

	buttonLeft.addEventListener('click', () => {
	  currentIndex--;
	  currentIndex = currentIndex < 0 ? 0 : currentIndex; // index값이 0보다 작아질 경우 0으로 변경
	  slide.style.marginLeft = `-${banner.clientWidth * currentIndex}px`; // index만큼 margin을 주어 옆으로 밀기
	  clearInterval(interval); // 기존 동작되던 interval 제거
	  interval = getInterval(); // 새로운 interval 등록
	});

	buttonRight.addEventListener('click', () => {
	  currentIndex++;
	  currentIndex = currentIndex >= bannerImgs.length ? bannerImgs.length - 1 : currentIndex; // index값이 inner의 총 개수보다 많아질 경우 마지막 인덱스값으로 변경
	  slide.style.marginLeft = `-${banner.clientWidth * currentIndex}px`; // index만큼 margin을 주어 옆으로 밀기
	  clearInterval(interval); // 기존 동작되던 interval 제거
	  interval = getInterval(); // 새로운 interval 등록
	});

}
/*
	주기적으로 화면 넘기기
*/
const getInterval = () => {
  return setInterval(() => {
	currentIndex++;
	currentIndex = currentIndex >= bannerImgs.length ? 0 : currentIndex;
	slide.style.marginLeft = `-${banner.clientWidth * currentIndex}px`;
  }, 4000);
}

let interval = getInterval(); // interval 등록

  /*화면 사이즈에 따라 이미지 변경*/
function bannerSizeChange(count){
	/* 반응형 */
	/* 큰 데스크탑 */
	if (count > 1440) {
	document.getElementById("banner_img_change").src="./img/banner1_1920.png";
	document.getElementById("banner_img_change2").src="./img/banner2_1920.png";
	}
	
	if (count <= 1440) {
		document.getElementById("banner_img_change").src="./img/banner1_1440.png";
		document.getElementById("banner_img_change2").src="./img/banner2_1440.png";
	}

	if (count <= 1023) {
		document.getElementById("banner_img_change").src="./img/banner1_768.png";
		document.getElementById("banner_img_change2").src="./img/banner2_768.png";
	}

	if (count <= 375) {
		document.getElementById("banner_img_change").src="./img/banner1_375.png";
		document.getElementById("banner_img_change2").src="./img/banner2_375.png";
	}

}
