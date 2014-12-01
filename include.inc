<?php
// 세션을 시작. 로그인 용
session_start();

// class 이용
class Layout
{
	public $link; 
	public $style; 
	public $content;
	public $board;
	public $sub;
	public $title="Need Programs";
	
	
	public function LayoutMain()
	{
		echo "<!DOCTYPE html>\n<html lang='ko'>";
		echo "<head>\n<meta charset='utf-8'/>";
		echo "<title>".$this->title."</title>";
		echo $this->LayoutStyle(); 
		echo "</head>\n<body>\n<div id='container'>";
		echo	$this->LayoutHeader(); 
		echo	$this->LayoutContent(); 
		echo	$this->LayoutSide(); 
		echo	$this->LayoutFooter(); 
		echo "</div></body>\n</html>";
	}
	
	// 스타일
/	public function LayoutStyle()
	{
		echo "<link rel='stylesheet' type='text/css' href='".$this->link."'/> ";
		echo "<style>".$this->style."</style>";
	}
	
	// 헤더
	public function LayoutHeader()
	{
		echo "<header>
			<div id='logo'><h1><a href='./'>Need Programs</a></h1></div>
			<nav></nav>
		</header>
			<div class='ad_1'>

			</div>";
	}
	
	// 내용
	public function LayoutContent()
	{
		echo "<section><article>".$this->content."</article>";
	}
	// 사이드바
	public function LayoutSide()
	{
		$this->board=explode('/', $_SERVER['PHP_SELF']);
		switch($this->board[1])
		{
			case setup : 
				$this->sub="@@@@";
				break;
			default : 
				$this->sub="@@@";
		}
		echo "<aside>".$this->sub."</aside></section>";
	}
	
	// 푸터
		public function LayoutFooter()
	{

	}
}
?>