<!DOCTYP html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin login</title>
<meta name="description" content="Jiang CMS">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="Jiang youhua">
<meta name="Copyright"
	content="Copyright Jiang youhua All Rights Reserved.">
<link rel="stylesheet" type="text/css"
	href="ui/jquery/css/jquery-ui-1.10.3.css">
<link rel="stylesheet" type="text/css" href="ui/jquery/css/layout.css">
<script type="text/javascript" src="ui/jquery/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="ui/jquery/js/jquery-ui-1.10.3.js"></script>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<?php 
	include("./lab/AutoLoad.php");
	?>
</head>
<body>
	
	<div class="top">
		<span class="adminlogo"> <?php Block::format("logo",1)?>
		</span> <span class="adminMenu"> <?php Block::format("menu",2)?>
		</span> <span class="adminLogout"> <?php Block::format("logout",2)?>
		</span>
	</div>
	<div >
		<span class="span12"><?php Block::format("from",3)?>
		</span><span class="span12"><?php Block::format("layout",4)?></span>
	</div>
</body>
</html>