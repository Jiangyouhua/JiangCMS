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
<script type="text/javascript" src="../ui/jcms/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../ui/jcms/js/jcms.js"></script>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
	<?php include("../autoload.php"); defined('LANG') || define('LANG', 'cn_ZH');?>
	
	<div class="span12 back">
		<div class="span">
			<span class="textlogo">Jcms</span> <span> <?php Block::format(1,"Part_Navbar")?>
			</span> <span class="right"><?php Block::format(2,"Part_Logout");Block::format(3,'Part_Copyright')?>
			</span>
		</div>
	</div>
	<div class='span12'>
		<div class='span'>
			<span class='config'><?php Block::format(0,'Admin_Part_Config')?> </span>
		</div>
	</div>
	</div>
</body>
</html>
