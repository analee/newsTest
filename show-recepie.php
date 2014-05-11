<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Recepie Maker - Recepies</title>
<link href="css/reset.css" type="text/css" rel="stylesheet"/>
<link href="css/jquery-ui-1.10.4.custom.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styles.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="scripts/jquery.1.11.1.js"></script>
<script type="text/javascript" src="scripts/jquery-ui-1.10.4.custom.min.js"></script>
<?php
	include_once("classes/Recepies.php");
	$recepies = new Recepies();	
	$recepies->getFridgeContent($_POST);
	$recepies->getRecepie();
?>
</head>

<body>
	<h1>Recepie maker</h1>
    <p>According to to the ingridientes you have the best recepie is: <span><?php echo $recepies->result; ?></span></p>
    <a href="index.html">Try new recepie</a>
</body>
</html>