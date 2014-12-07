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
$friends = $data[1];
if(!isset($data))
{
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('존재하지 않는 글입니다.'); location.replace('./');</script>";
	exit;
}
$cate = ThisTable($data[4], $base->pmenu);
$data[5] = $data[5]?"<img class='maxwidth' src='.".$data[5]."'/>":"";
	$base->content = $base->content."
		<div class='wrap'>
			<!--<div class='header'><h2>".$data[5]."a</h2></div>-->
			<div class='name'>아이디: <b>".$data[1]."</b></div>
			<div class='content'>".$data[5]."<br >".nl2br($data[4])."</div>
		</div>";
		
		

		if($_SESSION['id'] == $data[1]){
		$base->content = $base->content."
			<span style='float:right'>
			<form action='../modify.php' method='post'>
				<input type='hidden' name='data' value='".$data."' />
				<input type='hidden' name='no' value='".$no."' />
				<input type='hidden' name='id' value='".$id."' />
				<input type='hidden' name='date' value='".$date."' />
				<input type='hidden' name='time' value='".$time."' />				
				<input type='hidden' name='content' value='".$content."' />
				<input type='hidden' name='image' value='".$image."' />
				<input type='submit' value='글수정'/>
			</form>
			<form action='../delete.php' method='post'>
				<input type='hidden' name='no' value='".$no."' />
				<input type='submit' value='글삭제'/>
			</form>
			</span>
			<p>";
			}
		
		$tid = $data[1];
		$num = $no ; 
			
			
		//댓글
		$db = new DBC;
		$db->DBI();
		$db->query = "select relation, friends from friends where id='".$_SESSION['id']."' and friends='".$friends."'";
		$db->DBQ();
		$data = $db->result->fetch_row();
		
		if($data[0] == 1 || $friends== $_SESSION['id']){
		$base->content = $base->content."
			
			<div>
			<form action='../re_writing.php' method='post' enctype='multipart/form-data'>
				<input type='hidden' name='MAX_FILE_SIZE' value='5000000' />
				<input type='hidden' name='bn' value='newsfeed' />
				<input type='hidden' name='no' value='".$no."' />
				<div style='width:80%'><textarea placeholder='댓글을 작성해보세요' style='width:100%;padding:5px' name='content' cols='70' rows='3'></textarea>
				<input style='width:100%;height:40px;color:white;font-weight:bold;border:none;border-top: 1px solid #56dd05;border-bottom: 1px solid #289a07;background-color:#23c604;background: -webkit-gradient(linear,0 0,0 100%,from(#23c604),to(#1eb400));text-align:center;font:bold 9pt Dotum;' type='submit' value='댓글 등록하기'/>
				
			</form>
			</div>
			<p>
			";
		}


		$db = new DBC;
		$db->DBI();
		$db->query = "select no, board_no, id, date, time, content from newsfeed_rep";
		$db->DBQ();
		$data = $db->result->fetch_row();
		while($data = $db->result->fetch_row())
			{
			while (list($key, $value) = each($base->pmenu))
			{
				if($data[4] == $value)
				{
					$cate = $key;
				}
			}
		if($num == $data[1]){
		$base->content = $base->content."
		<div>
			<div style='border:1px solid #cfd9db;width:80%;border-radius:5px;background-color:#cfd9db;padding:0 !important'>
				<div style='font:normal 9pt Dotum' >
					<a href='../timeline/?id=".$data[2]."'>".$data[2]."</a>
					<style='padding:0;margin:0;margin-top:10px' style='float:right'>".$data[3]." ".$data[4]."</p>
				</div>
				<div style='padding:10px 30px;background:white'>
		";
		$base->content = $base->content."
				".nl2br($data[5])."
			</div>
		</div>";
		
		if($_SESSION['id'] == $data[2]){
		$base->content = $base->content."
		<form action='../rep_delete.php' method='post'>
				<input type='hidden' name='no' value='".$data[0]."' />
				<input type='submit' value='댓글삭제'/>
		</form>
		";
		}
		
		$base->content = $base->content."
		<p>";
		}
		}


		$base->content = $base->content."	
			<a href='../timeline/?id=".$tid."' style='color:black;'>목록</a>
			";
			
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
?>