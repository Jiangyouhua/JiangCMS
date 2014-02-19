<?php include ("../library/Include.php") ?>
<!DOCTYP html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin:<?php echo Lang::to(PAGE)?></title>
<meta name="description" content="Jiang CMS">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="Jiang youhua">
<meta name="Copyright"
	content="Copyright © Jiang youhua All Rights Reserved.">
<link rel="stylesheet" type="text/css" href="../ui/jcms/css/jcms.css">
<link rel="stylesheet" type="text/css" href="../ui/jcms/css/drag.css">
<link rel="stylesheet" type="text/css"
	href="../plug/um/themes/default/css/umeditor.min.css">
<script type="text/javascript" src="../ui/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="../ui/jcms/js/cn_ZH.js"></script>
<script type="text/javascript" src="../plug/um/umeditor.config.js"></script>
<script type="text/javascript" src="../plug/um/umeditor.min.js"></script>
<script type="text/javascript" src="../ui/jcms/js/jcms.js"></script>
<script type="text/javascript" src="../ui/jcms/js/drag.js"></script>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
</head>
<body style="width:<?php echo Admin_Config_Admin::$width?>">
	<div class="span0 back">
		<div class=span>
			<span class="textlogo"><?php echo Admin_Config_Admin::$name?></span> 
			<span> <?php Go::to('adminNavbar')?></span>
			<span class="right"><?php
			
			Go::to ('adminLogout' );
			echo Admin_Config_Admin::$copyright?>
			</span>
		</div>
	</div>
	<div class='span12'>
		<div class='span'>
			<span class='config'>
			<?php Go::to('adminConfig')?>
			<?php Go::to('adminDesign')?> 
			<?php Go::to('adminPublication')?> 
			<?php Go::to('adminAccess')?> 
			</span>
		</div>
	</div>
</body>
</html>
