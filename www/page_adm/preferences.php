<?php $type="adm"; $gNum="05"; $gName="환경설정(유지보수 종류)"; ?>
<?php include("../pub/inc/_dtd.php") ?>
<?php include("../pub/inc/_header.php") ?>
<div id="mainContent" class="container sub_wrap">

	<div class="inner">
		<a href="javascript:history.back();" class="goback">뒤로</a>
		<div class="title"><?=$gName?></div>
		
		<div class="preferences">
			<div class="folderbox">
				<div class="addbox">
					<input type="text" class="text" value="SSL(보안인증서)">
					<button class="btn">추가</button>
				</div>
				<div class="list">
					<button type="button" class="btn">SSL(보안인증서)</button>
					<button type="button" class="btn">SSL(보안인증서)</button>
					<button type="button" class="btn">SSL(보안인증서)</button>
					<button type="button" class="btn">SSL(보안인증서)</button>
					<button type="button" class="btn on">SSL(보안인증서)</button>
				</div>
			</div>
			<div class="inputs">
				<div class="stit ss mt0">이름</div>
				<input type="text" class="text w100p">
				<div class="stit ss">순서</div>
				<input type="text" class="text w100p">
				<div class="stit ss">사용여부</div>
				<div class="flex radios">
					<label class="radio"><input type="radio" name="radio"><i></i>Y</label>
					<label class="radio"><input type="radio" name="radio"><i></i>N</label>
				</div>
				<div class="stit ss">내용</div>
				<textarea name="" id="" cols="30" rows="10" class="text w100p" placeholder="placeholder에 들어갈 내용 입력"></textarea>
				<div class="board_bottom">
					<div class="btns_tac">
						<button class="btn btn_g">저장</button>
						<button class="btn btn_bl">삭제</button>
					</div>
				</div> <!-- //board_bottom -->
			</div>
		</div>

	</div>

</div>
<?php include("../pub/inc/_footer.php") ?>