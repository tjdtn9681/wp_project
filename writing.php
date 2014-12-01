<?php
require_once "./layout.inc";
require_once "./db.php";

$base = new Layout;
$base->link='./style.css';

$bn = $_POST['bn'];

/**/

if(($bn == 'newsfeed' || $bn == 'timeline') && $_SESSION['permit']!=1) 
{
header("Content-Type: text/html; charset=UTF-8");
echo "<script>alert('로그인 하지 않으면 글을 쓸 수 없습니다.');location.replace('/');</script>";
exit;
} else if ($bn=='newsfeed') // 프로그램
{

// 프로그램 부분에 필요한 각각의 변수 생성
$content = $_POST['content'];

if($content =='') // 비어있는 변수 있으면 오류 출력
{
header("Content-Type: text/html; charset=UTF-8");
echo "<script>alert('글을 입력하세요');history.back();</script>";
exit;
}
if ($_FILES['userfile']['error']>0) // 파일 업로드에 에러코드(1,2,3,4,6,7)가 0보다 크다면 관련 내용을 출력
{
header("Content-Type: text/html; charset=UTF-8");
switch ($_FILES['userfile']['error'])
{
case 1:
echo "<script>alert('파일의 크기가 최대 업로드 크기를 넘었습니다.');history.back()</script>";
exit;
break;
case 2:
echo "<script>alert('파일의 크기가 최대 파일 크기를 넘었습니다.');history.back()</script>";
exit;
break;
case 3:
echo "<script>alert('파일이 불완전하게 업로드 되었습니다.');history.back()</script>";
exit;
break;
case 4:
//echo "<script>alert('파일이 업로드 되지 않았습니다.');history.back()</script>";
$nofile = true;
break;
case 6:
echo "<script>alert('파일을 업로드 할 수 없습니다.');history.back()</script>";
exit;
break;
case 7:
echo "<script>alert('업로드에 실패하였습니다.');history.back()</script>";
exit;
break;
}
}
if ( !$nofile ){
	if ($_FILES['userfile']['type'] !='image/jpeg' && $_FILES['userfile']['type'] !='image/png')
	// 이미지 확장자가 jpeg혹은 png가 아니라면 오류 출력
	{
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('JPG 혹은 PNG 파일만 업로드 가능합니다.');history.back()</script>";
	exit;
	}

	$upfile = './images/'.$_FILES['userfile']['name']; // upfile 변수에 ./images/파일명으로 저장
	if (is_uploaded_file($_FILES['userfile']['tmp_name']))
	{
	if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $upfile))
	// 임시 저장 공간에 자료가 있다면 임시 공간에서 $upfile의 경로로 자료 이동을 해보고 실패하면 오류 출력
	{
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('파일을 업로드 하지 못했습니다.');history.back()</script>";
	exit;
	}
	} else //자료가 없다면 오류 출력
	{
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('파일 업로드 공격의 가능성이 있습니다. 파일명 : ".$_FILES['userfile']['name']."');history.back()</script>";
	exit;
	}
}

$db = new DBC;
$db->DBI();
// query로 세션 값, id, permit 이 테이블에 존재하는지 확인
$db->query = "select id, pass, permit from member where id='".$_SESSION['id']."' and permit=".$_SESSION['permit'];
$db->DBQ();
$pass = $db->result->fetch_row();

if ( $nofile ) {
$db->query = "insert into ".$bn." values(null, '".$_SESSION['id']."', '".$pass[1]."', '".date('Y-m-d')."', '".date('H:i:s')."', '".$content."', '')";
}else{
$db->query = "insert into ".$bn." values(null, '".$_SESSION['id']."', '".$pass[1]."', '".date('Y-m-d')."', '".date('H:i:s')."', '".$content."', '".$upfile."')";
}
$db->DBQ();
if(!$db->result)
{
echo "<script>alert('DB 전송에 실패했습니다.')</script>";
} else
{
echo "<script>alert('글이 정상적으로 업로드 되었습니다.');location.replace('/".$bn."')</script>";
}
$db->DBO();
}

$base->LayoutMain();
?>