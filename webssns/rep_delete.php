<?php
require_once './layout.inc';
require_once './db.php';

$db = new DBC;
$db->DBI();

$base = new Layout;
$base->link = './style.css';

$no = $_POST['no'];


$db->query = "delete from newsfeed_rep where no=".$no."";
$db->DBQ();

if(!$db->result)
{
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('댓글삭제를 실패하였습니다..');history.back();</script>";
	$db->DBO();
	exit;
	
} else
{
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('댓글을 삭제하였습니다.');history.back();</script>";
	$db->DBO();
	exit;
}


$base->content = "";

$base->LayoutMain();

?>