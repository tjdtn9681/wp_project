<?php
require_once "./layout.inc";

$base = new Layout;
$base->link='./style.css';

$bn=$_GET['bn'];

if(($bn == 'notice' || $bn == 'programs') && $_SESSION['permit']!=1)
{
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('접근할 수 없습니다.');history.back('/')</script>";
	exit;
}

//프로그램
else if($bn=='programs') 
{
	while (list($key, $value) = each($base->pmenu))
	{
		if($key!='최신')
		{
			$pmenu = $pmenu."<option value='".$value."'>".$key."</option>";
		}
	}
			

	$base->content="
	<form action='./writing.php' method='post' enctype='multipart/form-data'>
		<div>
			<input type='hidden' name='MAX_FILE_SIZE' value='5000000' />
			<input type='hidden' name='bn' value='".$bn."' />
			<div>제목 <input type='text' name='title' size='80'/></div>
			<div>카테고리
			<select name='category'>
				".$pmenu."
			</select></div>
			
			<div>링크 <input type='text' name='link' size='50'/></div>
			<div><input type='file' name='userfile' id='userfile'/></div>
			<div><textarea name='content' cols='90' rows='20'></textarea></div>
			<input type='submit' value='글쓰기'/>
		</div>
	</form>
	";
}

$base->LayoutMain(); //위의 변수들이 입력된 객체를 출력
?>