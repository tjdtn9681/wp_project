<?php
require_once '../layout.inc';
require_once '../db.php';

$base = new Layout;
$base->link = '../style.css';

$tn='newsfeed';
$timeid = $_GET['id'];
$onepage=500;

if($_GET['p']==false)
{
	$_GET['p']=1;
}

$db = new DBC;
$db->DBI();
	$db->query = "select count(*) from newsfeed where id= '".$timeid."'";
	$db->DBQ();
	@$quantity = $db->result->fetch_row();
	if ( $quantity[0] == null ) {
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

	
	
	$base->content = $base->content."
	<div style='width:99%;margin-bottom:10px'>".$timeid."님의 앨범
	<form action='../timeline/?id=".$timeid."' method='post'>
				<input type='hidden' name='no' value='".$no."' />
				<input type='submit' value='목록'/>
	</form></div>
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
		if($data[1] == $_SESSION['id'] || $data[6] == 0){
		if( $data[5] ) {
		
		if( $data[5] ) {
		$base->content = $base->content."
		
		<a href='./view.php?v=".$data[0]."' style='cursor:normal;font:normal 9pt dotum !important;color:black !important'>
		<img class='maxwidth' src='.".$data[5]."'/>
		";
		}
		$base->content = $base->content."
				</a>
		";
		}
		}
	}


$base->LayoutMain();
?>