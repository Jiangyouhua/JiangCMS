<?php include ("../library/Include.php")?>
<!DOCTYP html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin login</title>
<meta name="description" content="Jiang CMS">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="Jiang youhua">
<meta name="Copyright"
	content="Copyright © Jiang youhua All Rights Reserved.">
<link rel="stylesheet" type="text/css" href="../ui/jcms/css/jcms.css">
</head>
<body>
	<div class=login>
		<div class="span0 back">
			<div class=span>
				<span class="textlogo"><?php echo Admin_Config_Admin::$name?></span>
				</span>
			</div>
		</div>
		<div class='span12'>
			<div class='span span_center'>
				<span class='adminlogin'>
			<?php Go::to('adminLogin')?>
			</span>
			</div>
		</div>
		<div class='span0 foot'>
			<div class='span'>
				<span class="right"><?php echo Admin_Config_Admin::$copyright?>
		
			
			</div>
		</div>
	</div>
</body>
</html>
