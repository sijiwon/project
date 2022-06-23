<?php
 session_start();

	$userName = empty($_SESSION["userName"]) ? '로그인/회원가입' : $_SESSION["userName"];
	//$userId = empty($_SESSION["userId"]) ? '' : $_SESSION["userId"];

	require("db_connect.php");

    $numLines = 8; // 보이게 할 게시글 수
    $numLinks = 5; // 한 페이지에 표시할 페이지 링크개수

    $page = empty($_REQUEST["page"]) ? 1 : $_REQUEST["page"]; // 페이지 번호 지정
    $start = ($page - 1) * $numLines; // 보이게할 레코드 번호

    $firstLink = floor(($page - 1) / $numLinks) * $numLinks + 1;
    $lastLink = $firstLink + $numLinks - 1;


    $numRecords = $db->query("select count(*) from board_free")->fetchColumn();
       $member_cnt = $numRecords;
				$numPages = ceil($numRecords/$numLines); //게시판 테이블 레코드 수
				while ($lastLink > $numPages) {
					$lastLink = $numPages;
				}

?>
<div class = "paging">




<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원목록</title>
    <style type="text/css">
        body{font-size:16px}
        a{text-decoration:none;color:rgb(0, 132, 255)}
        a:hover{color:rgb(255, 153, 0)}
        table{width:1328px;border-collapse:collapse}
        td{padding:10px 15px;text-align:center}
        .title{border-top:3px solid #999;border-bottom:2px solid #999;background:#eee;font-weight:bold}
        .brd{border-bottom:1px solid #999}
        table a{text-decoration:none;color:#000;border:1px solid #333;display:inline-block;padding:3px 5px;font-size:12px;border-radius:5px}
        table a:hover{border:0 none;background:rgb(0, 132, 255);color:#fff}
    </style>
    <script type="text/javascript">
        function del_check(num){
            var i = confirm("정말 삭제하시겠습니까?");

            if(i == true){
                // alert("delete.php?u_idx="+idx);
                location.href = "ad_boardlist_delete.php?num=<?=$row['num']?>";
            };
        };
    </script>
</head>
<body>
    <h2>* 관리자 페이지 *</h2>
    <p>"<?php echo $userName; ?>"님, 안녕하세요.</p>
    <p>
    <a href="../index.php" class="bar">홈으로</a>
        <!-- <a href="board/board_list.php">게시판 관리</a> -->
        <a href="boardlist.php" class="bar">게시판 관리</a>
        <a href="memberlist.php" class="bar">회원 관리</a>
        <a href="../logout.php">로그아웃</a>
    </p>
    <hr>
    <p>총 <?php echo $member_cnt; ?>개</p>
    <table>
        <tr class="title">
            <td style="width : 50px;">번호</td>
            <td style="width : 250px;">글제목</td>
            <td style="width : 250px;">내용</td>
            <td style="width : 80px;">가격</td>
            <td style="width : 80px;">카테고리</td>
            <td style="width : 80px;">상태</td>
            <td style="width : 100px;">날짜</td>
            <td style="width : 50px;">수정</td>
            <td style="width : 50px;">삭제</td>
        </tr>

        <?php
        // for($i = 1; $i <= $num; $i++){
        /* $i = 1;
        while($array = mysqli_fetch_array($result)){ */

        /* paging : 시작 번호 = (현재 페이지 번호 - 1) * 페이지 당 보여질 데이터 수 */
        $firstLink = floor(($page - 1) / $numLinks) * $numLinks + 1;
        $lastLink = $firstLink + $numLinks - 1;




        /* paging : 쿼리 작성 - limit 몇번부터, 몇개 */
        $sql = "select * from board_free limit $start, $numLines;";

        /* paging : 쿼리 전송 */
        $query = $db->query("select * from board_free");
        while ($row = $query->fetch()) {


        }

        /* paging : 글번호 */
        $cnt = $start + 1;

        /* paging : 게시판정보 가져오기(반복) */
        /*$query = $db->query("select * from board_free limit $start, $numLines");
        while ($row = $query->fetch()) {
         */
        $query = $db->query("select * from board_free  order by reg_date desc limit $start, $numLines");

               while ($row = $query->fetch()) {
                 if (mb_strlen($row["title"]) and mb_strlen($row["content"]) >= 20) { //mb_strlen("문자열")  문자열 길이 측정
                    $row["title"] = substr($row["title"],0,20).'...';
                    $row["content"] = substr($row["content"],0,20).'...';
                 }

        ?>
        <tr class="brd">
            <!-- <td><?php echo $i; ?></td> -->
            <td><?php echo $cnt; ?></td>
            <td><?php echo $row["title"]; ?></td>
            <td><?php echo $row["content"]; ?></td>
            <td><?php echo $row["price"]; ?></td>
            <td><?php echo $row["cate"]; ?></td>
            <td><?php echo $row["state"]; ?></td>
            <td><?php echo $row["reg_date"]; ?></td>
            <td><a href="ad_board_write.php?num=<?php echo $row["num"]; ?>">수정</a></td>
            <td><a href="ad_boardlist_delete.php?num=<?=$row['num']?>">삭제</a></td>
        </tr>
        <?php
            /* $i++; */
            /* paging */
            $cnt++;
        };
        ?>
    </table>
    <?php
    $firstLink = floor(($page - 1) / $numLinks) * $numLinks + 1;
      $lastLink = $firstLink + $numLinks - 1;

        $numRecords = $db->query("select count(*) from board_free")->fetchColumn(); //

      $numPages = ceil($numRecords/$numLines); //게시판 테이블 레코드 수
      if ($lastLink > $numPages) {
        $lastLink = $numPages;
      }?>
    <div class = "paging">
				<?php
				/*이전 페이지*/
				if ($firstLink > 1) {
				?>
					<a class="page_btn" href = "boardlist.php?page=<?=$firstLink - $numLinks?>"><</a>
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
					<a class="nowPage" href = "boardlist.php?page=<?=$i?>"><?=($i == $page) ? "<b>$i</b>" : $i?></a>
				<?php
					continue;
					}
				?>
					<a class="page_list" href = "boardlist.php?page=<?=$i?>"><?=($i == $page) ? "<b>$i</b>" : $i?></a>
				<?php
				}
				/*다음 페이지*/
				if ($lastLink < $numPages) {
				?>
					<a class="page_btn" href = "boardlist.php?page=<?=$firstLink + $numLinks?>">></a>
				<?php
				} else {
				?>
					<span class="overPage">></span>
				<?php
				}
				?>
				</div>
</body>
</html>
