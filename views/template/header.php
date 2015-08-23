<?php
	header("Content-Type:text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="KEVIN">
	<?php echo css_url("/bootstrap.css") ?>
	<?php echo css_url("/bootstrap.min.css") ?>
	<?php echo css_url("/bootstrap-fileupload.css") ?>
	<?php echo css_url("/jquery-ui.css") ?>
	<?php echo css_url("/dashboard.css") ?>


	<title><?=$title?></title>
	<style type="text/css">
		body{ 	
				padding-top: 70px;
				padding-bottom: 50px; 
			}
		.alert {
			margin-bottom: 0px;
		}
		.sidebar{
			padding-top: 60px;
		}
		.ui-dialog { z-index: 1500 !important ;}
	</style>
