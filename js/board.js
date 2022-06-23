
/*윈도우 사이즈 받아오기(브라우저 창 크기 조절할 때 실행)*/
window.onresize = function(event) {
	explainWriteSize(window.innerWidth);
};

/*브라우저 실행 시 (html 로딩 끝난 후 시작)*/
window.onload = function() {
	/*첫 화면 크기 */
	explainWriteSize(window.innerWidth);
};

let explain_write = document.querySelector('.explain_write');

function explainWriteSize(count){
	/* 반응형 */
	/* 큰 데스크탑 */
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

const inputImage = document.getElementById("file_upload")
inputImage.addEventListener("change", e => {
    readImgs(e.target)
})

/*파일 확장자 체크*/
function fileUploadCheck(fileVal) {
	/*확장자 추출*/
	let fileLength = fileVal.length; //파일 이름 길이
	let fileDot = fileVal.lastIndexOf(".")+1; //.부터 끝까지 파일 이름 길이 (확장자+1)
	let extension = fileVal.substring(fileDot, fileLength).toLowerCase(); // substring(시작index, 종료index), toLowerCase()소문자로 변환

  if (fileVal) {	
	/*업로드 가능한 이미지 파일인지*/
	if(extension != "jpg" && extension != "png" &&  extension != "gif" &&  extension != "bmp"){
		alert("이미지 파일은 (jpg, png, gif, bmp) 형식만 등록 가능합니다.");
		document.getElementById('file_upload').value="";
		return;
	}
  }

}

/*업로드한 파일 이미지 변경*/
function readImgs(input) {
	/*input태그에 파일이 있는 경우*/
  if (input.files && input.files[0]) {
    let reader = new FileReader(); //파일 읽기 객체 생성
	//let target = document.getElementsByName('upload[]');
	//var str = '';
	//let imgs_wrap = document.getElementById('imgs_wrap');
	//let new_img = document.createElement('img');

	reader.onload = function(e) {
		document.getElementById('file_img').src = e.target.result;
	};
    reader.readAsDataURL(input.files[0]);
  } else {
    document.getElementById('file_img').src = "./img/file_img.png";
  }
}

