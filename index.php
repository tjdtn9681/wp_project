<?php
require_once './layout.inc';
require_once './db.php';
//include_once "./layout.inc";

$base = new Layout;
$base->link='./style.css';

if($_SESSION['id'] != null){
$base->content="<div style='width:99%;margin-bottom:10px;color:green'><h3>1주일 이내의 알람</div>";
 
$db = new DBC;
$db->DBI();
$db->query = "select no, id, friends, relation, date, time from friends  where date BETWEEN date_sub(now(),INTERVAL 1 WEEK) AND now() ";
$db->DBQ();
$data = $db->result->fetch_row();
	

while($data = $db->result->fetch_row())
{
//where id='".$_SESSION['id']."' and relation='1' and date BETWEEN date_sub(now(),INTERVAL 1 WEEK) AND now()

if($data[1] ==  $_SESSION['id'] && $data[3] == '1' ){
$base->content = $base->content."
	<a href='../timeline/?id=".$data[2]."'>	".$data[2]." </a> 님과 친구가 되었습니다! (".$data[4]."  ".$data[5].") <p>
	";	

}
}


$db = new DBC;
$db->DBI();
$db->query = "select no, id, date, time, tag from newsfeed where date BETWEEN date_sub(now(),INTERVAL 1 WEEK) AND now() ";
$db->DBQ();
$data = $db->result->fetch_row();

while($data = $db->result->fetch_row())
{
if($data[4] == $_SESSION['id']){
$base->content = $base->content."
	<a href='../timeline/?id=".$data[1]."'>".$data[1]."</a>님이 <a href='newsfeed/view.php?v=".$data[0]."'> 새 글 </a>에 당신을 태그하였습니다!(".$data[2]."  ".$data[3].") <p>
	";	
}
}




}else{
$base->content="<div style='width:99%;margin-bottom:10px;color:green'><h3>회원가입과 로그인을 통해 webssns를 이용해보세요</div>";
	
}

$base->LayoutMain();
?>