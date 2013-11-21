<!DOCTYP html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin login</title>
<meta name="description" content="Jiang CMS">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="Jiang youhua">
<meta name="Copyright"
	content="Copyright Jiang youhua All Rights Reserved.">
<link rel="stylesheet" type="text/css" href="../ui/jcms/css/jcms.css">
<link rel="stylesheet" type="text/css" href="../ui/jcms/css/drag.css">
<script type="text/javascript" src="../ui/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="../ui/jcms/js/jcms.js"></script>
<script type="text/javascript" src="../ui/jcms/js/drag.js"></script>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
	<?php include("../autoload.php"); defined('LANG') || define('LANG', 'cn_ZH');?>
	
	<div class="span12 back">
		<div class="span">
			<span class="textlogo"><?php echo Admin_Config_Back::$name?></span> 
			<span> <?php Block::format(1,"Part_Navbar")?></span> 
			<span class="right"><?php Block::format(2,"Part_Logout");
			echo Admin_Config_Back::$copyright?>
			</span>
		</div>
	</div>
	<div class='span12'>
		<div class='span'>
			<span class='config'>
			<?php Block::format(4,'Admin_Part_Config')?>
			<?php Block::format(5,'Admin_Part_Design')?> 
			</span>
		</div>
	</div>
</body>
</html>
