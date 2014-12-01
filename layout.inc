<?php
// 세션 시작. 로그인 용
session_start();
ini_set("session.gc_maxlifetime", 3600);

if(!isset($_SESSION['id']) && isset($_SESSION['permit']) )
{
	echo "<script>location.replace('/logout.php');</script>";
}
// class 이용
class Layout
{
	public $title="WEBsSNS";
	private $menu = array('Newsfeed'=>'newsfeed', 'Timeline'=>'timeline');
	public $pmenu = array('최신'=>'latest');
	public	 $bmenu = array('최신'=>'latest');
	public $link; 
	public $style; 
	public $content; 

	public $board;
	private $sub; 
	private $login; 


	public function LayoutMain()
	{
		echo $this->ThisBoard(); // 현재 게시판 확인
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
	
	// 현재 게시판 확인
	public function ThisBoard()
	{
		$this->board = explode('/', $_SERVER['PHP_SELF']);
	}
	
	// 스타일
	public function LayoutStyle()
	{
		echo "<link rel='stylesheet' type='text/css' href='".$this->link."'/> ";
		echo "<style>".$this->style."</style>";
	}
	
	// 헤더
	public function LayoutHeader()
	{
		$this->LayoutLogin();
		echo "<header>
			<div id='logo'><h1><a href='/'>WEBsSNS</a></h1></div>
				<div id='navset'>
					<nav id='menu'>
						";
		$this->LayoutMenu($this->menu, 0); // $menu 배열로 메뉴 호출
		echo "	</nav>
					<nav id='login'>".$this->login."</nav>
				</div>
			<div class='a'>
				<script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
				<!-- Speeds_728x90 -->
				<ins class=\"adsbygoogle\"
					 style=\"display:inline-block;width:728px;height:90px\"
					 data-ad-client=\"ca-pub-4805042826277102\"
					 data-ad-slot=\"7788772676\"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		</header>";
	}
	public function LayoutMenu($menu, $side) // 메뉴 호출
	{
		while (list($key, $value) = each($menu))
		{
			$this->ThisMenu($key, $value, $side);
        }
	}
	public function ThisMenu($key, $value ,$side)
	{
		if($side=='1')
		{
			if(strpos($_SERVER['REQUEST_URI'], $value)==false)
			{
				$thismenu = $thismenu."<li><a href='./?tn=".$value."'>".$key."</a></li>";
			} else
			{
				$thismenu = $thismenu."<li><b style='border-bottom:4px solid green;'>".$key."</b></li>";
			}
		} else
		{		
			if(strpos($_SERVER['PHP_SELF'], $value)==false)
			{
				$thismenu = $thismenu."<li><a href='/".$value."'>".$key."</a></li>";
			} else
			{
				$thismenu = $thismenu."<li><b style='border-bottom:4px solid green;'>".$key."</b></li>";
			}
		}
		echo $thismenu;
	}
	public function LayoutLogin()
	{
		if($_SESSION['id']=="")
		{
			if(strpos($_SERVER['PHP_SELF'], "login.php"))
			{
				$this->login="<b style='border-bottom:3px solid #90bbff;'>Login</b>";
			} else
			{
				$this->login="<a href='/registi.php'>Join </a> <a href='/login.php'>Login</a>";
			}
		} else
		{
			$this->login="<a href='/logout.php'>Logout</a>";
		}
	}
	// 내용
	public function LayoutContent()
	{
		echo "<section><article>".$this->content."</article>";
	}
	// 사이드바
	public function SideMenu()
	{
		$this->board=explode('/', $_SERVER['PHP_SELF']);
		switch($this->board[1])
		{
			

			case timeline : 
			if(isset($_SESSION['id']) && isset($_SESSION['permit']))
			{
				echo "<div style='margin-top:20px;text-align:center;padding:15px;border:1px solid #ddd;'><b	style='padding:20px;'>";
				switch($_SESSION['permit'])
				{
					case 1 : echo "일반회원";
					break;
					case 2 : echo "회원";
						break;
					case 3 : echo "관리자";
						break;
				}
				echo "</b><b style='padding:20px;'>".$_SESSION['id']."</b></div>";
			}
			echo "<h3 style='margin: 5px 0 10px 0;text-align:center;'><a href='./'>친구목록</a></h3>";
			$this->LayoutMenu($this->pmenu, 1);
			if($_SESSION['permit']==1)
			{
				echo "<div style='margin-top:20px;text-align:center;padding:15px;border:1px solid #ddd;'><a href='../write.php?bn=".$this->board[1]."' style='padding:20px;'>글</a> <a href='../admin.php' style='padding:20px;'>관리</a></div>";
			}
				break;

			case newsfeed : 
			if(isset($_SESSION['id']) && isset($_SESSION['permit']))
			{
				echo "<div style='margin-top:20px;text-align:center;padding:15px;border:1px solid #ddd;'><b	style='padding:20px;'>";
				switch($_SESSION['permit'])
				{
					case 1 : echo "일반회원";
					break;
					case 2 : echo "회원";
						break;
					case 3 : echo "관리자";
						break;
				}
				echo "</b><b style='padding:20px;'>".$_SESSION['id']."</b></div>";
			}
			echo "<h3 style='margin: 5px 0 10px 0;text-align:center;'><a href='./'>알림</a></h3>";
			$this->LayoutMenu($this->bmenu, 1);
			break;
			
		}
	}
	public function LayoutSide()
	{		
		echo "<aside>";
		$this->SideMenu();
		echo "</aside></section>";
	}
		public function LayoutFooter(){}
}
?>