<?php
require_once '../layout.inc';
require_once '../db.php';

$base = new Layout;
$base->link = '../style.css';

$tn='newsfeed';
$onepage=10;

if($_GET['p']==false)
{
	$_GET['p']=1;
}

if($_SESSION['permit']==1){
			$db = new DBC;
			$db->DBI();
			$db->query = "select no, id, friends, relation from friends";
			$db->DBQ();
			$data = $db->result->fetch_row();
		


$db = new DBC;
$db->DBI();
	$db->query = "select count(*) from newsfeed";
	$db->DBQ();
	$quantity = $db->result->fetch_row();

	$limit=$onepage*$_GET['p']-$onepage;


		
	$db->query = "select no, id, date, time, content, image, allow from newsfeed order by no desc limit ".$limit.", ".$onepage;

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

	$base->content = $base->content."
	<div style='width:99%;margin-bottom:10px'>
	<form action='../writing.php' method='post' enctype='multipart/form-data'>
		<input type='hidden' name='MAX_FILE_SIZE' value='5000000' />
		<input type='hidden' name='bn' value='newsfeed' />
		<div><input type='file' name='userfile' id='userfile'/></div>
		<div><input type='text' name='tag'size='16' placeholder='태그'/>
		<input type='radio' name='allow' value='0'  checked='checked'/>공개
		<input type='radio' name='allow' value='1'/>비공개
		<div>
		<div style='width:100%'><textarea placeholder='글을 작성해보세요.' style='width:100%;padding:5px' name='content' cols='90' rows='20'></textarea></div>
		<input style='width:100%;height:40px;color:white;font-weight:bold;border:none;border-top: 1px solid #56dd05;border-bottom: 1px solid #289a07;background-color:#23c604;background: -webkit-gradient(linear,0 0,0 100%,from(#23c604),to(#1eb400));text-align:center;font:bold 9pt Dotum;' type='submit' value='글 등록하기'/>
	</form>
	</div>
	";
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
		$check = $data[1];
		

		

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
	
	
	$thispage = $_GET['p']; //현재 페이지
	$totalpage=(int)ceil ($quantity[0]/$onepage); //전체 페이지
	$oneblock = 5; //페이지 블록 한 페이지에 몇개 보일지.
	if($thispage>$totalpage)
	{
		//echo "<script>alert('존재하지 않는 페이지입니다.');location.replace('./');</script>";
	}


	$thisblock = (int)(ceil($thispage/$oneblock)-1);
	$lastblock = (int)(ceil($totalpage/$oneblock)-1);
	$startnum = (int)($thisblock*$oneblock+1);
	$endnum = (int)($thisblock*$oneblock+$oneblock+1);

	if($thispage!=1) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=1'><< </a>";
	if($thisblock!=0) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".($thisblock*$lastblock)."'>< </a>";
	for($i=$startnum; $i<$endnum; ++$i)
	{
		if($i>$totalpage) break;
		if($i==$thispage) $paging = $paging."<b>".$i."</b>";
		else $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".$i."'>".$i."</a>";
	}
	if($thisblock!=$lastblock) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".$endnum."'> ></a>";
	if($thispage!=$totalpage) $paging = $paging."<a href='".$_SERVER['PHP_SELF']."?tn=".$tn."&p=".$totalpage."'> >></a>";

	$base->content = $base->content."<div id='paging'>".$paging."</div>";
	
	
	
	//사이드
			$db = new DBC;
			$db->DBI();
			$db->query = "select no, id, friends, relation from friends";
			$db->DBQ();
			$data = $db->result->fetch_row();

			while($data = $db->result->fetch_row())
			{
			if($data[1] == $_SESSION['id'] && $data[3] == '0'){
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