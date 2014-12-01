<?php
include_once "./layout.inc";

$base = new Layout;

$base->link='./style.css';
$base->content="<a href='#'>링크</a>내용이 들어가는 부분입니다."; 

$base->LayoutMain();
?>