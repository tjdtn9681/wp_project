<?php

require_once '../layout.inc';
require_once '../db.php';

$base = new Layout;
$base->link = '../style.css';

$no = (int) $_GET['v'];

if(!isset($no))
{
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('존재하지 않는 글입니다.'); location.replace('./');</script>";
	exit;
}

function ThisTable($cate, $pmenu)
{
	while (list($key, $value) = each($pmenu))
	{
		if($cate == $value)
		{
			$cate = $key;
		}
    }
	return $cate;
}
$base->style='
	div.wrap {border:1px solid #ddd;min-height:580px;padding:8px;}
	div.wrap div {padding:8px;}
	div.header{border-top:3px solid #aaa;border-bottom:3px solid #aaa;}
	div.header > h2{margin:0;}
	div.content{margin-top:20px;}
	div.image {border:1px solid #ddd;text-align:center;}
	div#paging{text-align:center;}
	div#paging > a{padding:2px 5px 2px 5px;border:1px solid transparent;}
	div#paging > b{padding:2px 5px 2px 5px;border:1px solid transparent;}
	div#paging > a:hover{border:1px solid #ddd;}
	';

$db = new DBC;
$db->DBI();



$db->query = "select no, id, date, time, content, image from newsfeed where no=".$no." limit 0, 1";
$db->DBQ();

$data = $db->result->fetch_row();
if(!isset($data))
{
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('존재하지 않는 글입니다.'); location.replace('./');</script>";
	exit;
}
$cate = ThisTable($data[4], $base->pmenu);
$data[5] = $data[5]?"<img class='maxwidth' style='width:100%' src='.".$data[5]."'/>":"";
	$base->content = $base->content."
		<div class='wrap'>
			<!--<div class='header'><h2>".$data[5]."a</h2></div>-->
			<div class='name'>아이디: <b>".$data[1]." <span style='float:right'>".$data[2]." ".$data[3]." </span></b></div>
			<div class='content'>".$data[5]."<br >".nl2br($data[4])."</div>
			<p margin-bottom:5px>
			댓글쓰기
			<span style='float:right'>
			
			
			
			</span>
			</p>
		</div>";

$base->LayoutMain();

			/*.if(isset($_SESSION['id'] == $data[1]){
			header("Content-Type: text/html; charset=UTF-8");
			echo "<script>글수정</script>";
			echo "<script>글삭제</script>";
			}*/
?>

