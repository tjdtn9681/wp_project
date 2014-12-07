<?php
require_once './layout.inc';
require_once './db.php';

$db = new DBC;
$db->DBI();

$base = new Layout;
$base->link = './style.css';

$fid = $_POST['id'];
$ffriends = $_POST['friends'];


$db->query = "select id, friends from friends where id='".$fid."' and friends='".$ffriends."'";
$db->DBQ();
$data = $db->result->fetch_row();


if($data[0] == $fid && $data[1] == $ffriends){
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('이미 신청했습니다.');history.back();</script>";
	$db->DBO();
	exit;
} else{

	$db->query = "insert into friends values(null, '".$fid."', '".$ffriends."', '0', '".date('Y-m-d')."', '".date('H:i:s')."')";
	$db->DBQ();

	if(!$db->result)
	{
		header("Content-Type: text/html; charset=UTF-8");
		echo "<script>alert('팔로우 신청을 실패하였습니다.');history.back();</script>";
		$db->DBO();
		exit;
		
	} else
	{	
		$db->query = "select id, friends from friends where id='".$ffriends."' and friends='".$fid."'";
		$db->DBQ();
		$data = $db->result->fetch_row();
		if($data[0] == $ffriends && $data[1] == $fid){
		$db->query = "UPDATE friends SET relation = '1', date='".date('Y-m-d')."', time='".date('H:i:s')."' WHERE id='".$fid."' and friends='".$ffriends."'"; 
		$db->DBQ();
		$db->query = "UPDATE friends SET relation = '1', date='".date('Y-m-d')."', time='".date('H:i:s')."' WHERE id='".$ffriends."' and friends='".$fid."'";
		$db->DBQ();
		}
	
		header("Content-Type: text/html; charset=UTF-8");
		echo "<script>alert('팔로우 신청하였습니다.');history.back();</script>";
		$db->DBO();
		exit;
	}
}

$base->content = "";

$base->LayoutMain();

?>