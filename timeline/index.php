<?php
require_once '../layout.inc';
require_once '../db.php';

$base = new Layout;
$base->link = '../style.css';

$tn='timeline';
$timeid = $_GET['id'];
$onepage=500;



if($_GET['p']==false)
{
	$_GET['p']=1;
}

if($_SESSION['permit']==1){
$db = new DBC;
$db->DBI();
	$db->query = "select count(*) from newsfeed where id= '".$timeid."'";
	$db->DBQ();
	@$quantity = $db->result->fetch_row();
	if ( $quantity[0] == 0 ) {
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('가입한 회원이 아니거나 작성한 글이 하나도 없습니다');history.back()</script>";
	exit;
	}
	$limit=$onepage*$_GET['p']-$onepage;

	
		
	$db->query = "select no, id, date, time, content, image, allow from newsfeed where id= '".$timeid."' order by no desc limit ".$limit.", ".$onepage;

	$base->style='
	div.wrap {margin-bottom:10px;}
	div.wrap div { padding:8px }
	div.left {float:left;width:50%;}
	div.right {float:right;width:40%;width:43%;}
	div.header{border-top:3px solid #aaa;border-bottom:3px solid #aaa;}
	div.header > h2{margin:0;}
	div.content{border:1px solid #ddd;margin-top:10px;min-height:170px;}
	div.image {text-align:center;min-height:316px;}
	img{max-height:330px;}
	div#paging{text-align:center;}
	div#paging > a{padding:2px 5px 2px 5px;border:1px solid transparent;}
	div#paging > b{padding:2px 5px 2px 5px;border:1px solid transparent;}
	div#paging > a:hover{border:1px solid #ddd;}
	';

	$base->content = "
		<table style='margin:0; margin-top:5%;'>
			<tr>
				<form action='./' method='get'>
				<td><input type='text' name='id'size='16' placeholder='아이디'/></td>
				<td><input type='submit' value='검색' /></td>
				</form>
				<td width='1000'> </td>
				<form action='../imgboard/?id=".$timeid."' method='post'>
				<td>
				<input type='submit' value='이미지'/>
				</td>
				</form>
				";
				if($_SESSION['id'] != $timeid){
				$base->content = $base->content."
				<form action='../follow.php' method='post'>
				<td>
						<input type='hidden' name='id' value='".$_SESSION['id']."' />
						<input type='hidden' name='friends' value='".$timeid."' />
						<input type='submit' value='팔로우'/>
				</td>
				</form>
				";}
				$base->content = $base->content."
			</tr>
		</table>
	
	";


	$base->content = $base->content."
	<div style='width:99%;margin-bottom:10px'>".$timeid."님의 타임라인</div>
	";

	
	
	/*if($timeid == $data[1]){
	$base->content = $base->content."
	<div style='width:99%;margin-bottom:10px'>
	<form action='../writing.php' method='post' enctype='multipart/form-data'>
		<input type='hidden' name='MAX_FILE_SIZE' value='5000000' />
		<input type='hidden' name='bn' value='newsfeed' />
		<div><input type='file' name='userfile' id='userfile'/></div>
		<div style='width:100%'><textarea placeholder='타임라인에 글을 남겨보세요.' style='width:100%;padding:5px' name='content' cols='90' rows='20'></textarea></div>
		<input style='width:100%;height:40px;color:white;font-weight:bold;border:none;border-top: 1px solid #56dd05;border-bottom: 1px solid #289a07;background-color:#23c604;background: -webkit-gradient(linear,0 0,0 100%,from(#23c604),to(#1eb400));text-align:center;font:bold 9pt Dotum;' type='submit' value='글 등록하기'/>
	</form>
	</div>
	";}*/
	
	
	
	$db->DBQ();
	while($data = $db->result->fetch_row())
	{
		while (list($key, $value) = each($base->pmenu))
		{
			if($data[4] == $value)
			{
				$cate = $key;
			}
		}
		if($data[1] == $_SESSION['id'] || $data[6] == 0){
		$base->content = $base->content."
		<div class='wrap'>
			<div style='border:1px solid #cfd9db;width:99%;border-radius:5px;background-color:#cfd9db;padding:0 !important'>
				<div style='font:normal 9pt Dotum'>
					<a href='../timeline/?id=".$data[1]."'>".$data[1]."</a>
					<p style='padding:0;margin:0;margin-top:10px'>".$data[2]." ".$data[3]."</p>
				</div>
				<div style='padding:10px 30px;background:white'><a href='./view.php?v=".$data[0]."' style='cursor:normal;font:normal 9pt dotum !important;color:black !important'>
		";
		if( $data[5] ) {
		$base->content = $base->content."
		<img class='maxwidth' src='.".$data[5]."'/><BR />
		";
		}
		$base->content = $base->content."
				".nl2br($data[4])."
				</a></div>
			</div>
		</div>";
		}
	}
	
	
	/*
	function lastPostFunc() { 
		$('div#lastPostsLoader').html('<img src="bigLoader.gif">'); 
		$.post("scroll.asp?action=getLastPosts&lastID=" + $(".wrdLatest:last").attr("id"),    


		function(data){ 
			if (data != "") { 
			$(".wrdLatest:last").after(data);            
			} 
			$('div#lastPostsLoader').empty(); 
		}); 
	}; 


	$(window).scroll(function(){ 
			if  ($(window).scrollTop() == $(document).height() - $(window).height()){ 
			  lastPostFunc(); 
			} 
	});
	*/
	
	$base->content = $base->content."<div id='paging'>".$paging."</div>";
	
	
		//사이드
			$db = new DBC;
			$db->DBI();
			$db->query = "select no, id, friends, relation from friends";
			$db->DBQ();
			$data = $db->result->fetch_row();

			while($data = $db->result->fetch_row())
			{
			if($data[1] == $_SESSION['id'] && $data[3] == '1'){
			$base->sidecontent = $base->sidecontent."
				<div style='width:99%;margin-bottom:10px;color:green;text-align:center;'><a href='../timeline/?id=".$data[2]."'> ".$data[2]."</a></div><p>
			";
			}
			}
			

$base->LayoutMain();
}else{
header("Content-Type: text/html; charset=UTF-8");
echo "<script>alert('로그인 하지 않으면 볼 수 없습니다.');location.replace('/');</script>";
exit;
}
?>