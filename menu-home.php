
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>91springboard Admin Portal</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />

</head>
 
<body>

<?php
        include_once ("lang/main.php");
?>

<div id="wrapper">
<div id="innerwrapper">
		
<?php
	$m_active = "Home";
	include_once ("include/menu/menu-items.php");
	include_once ("include/menu/home-subnav.php");
?>      

<div id="sidebar">

	<h2>Home</h2>

	<h3>Status</h3>

	<ul class="subnav">

		<li><a href="rep-stat-server.php"><b>&raquo;</b><?php echo $l['button']['ServerStatus'] ?></a></li>
		<li><a href="rep-stat-services.php"><b>&raquo;</b><?php echo $l['button']['ServicesStatus'] ?></a></li>
		<li><a href="rep-lastconnect.php"><b>&raquo;</b><?php echo $l['button']['LastConnectionAttempts'] ?></a></li>

	<h3>Logs</h3>

	        <li><a href="rep-logs-radius.php"><b>&raquo;</b><?php echo $l['button']['RadiusLog'] ?></a></li>
	        <li><a href="rep-logs-system.php"><b>&raquo;</b><?php echo $l['button']['SystemLog'] ?></a></li>

	</ul>


	<h2>Search</h2>

	<input name="" type="text" value="Search" />

</div>

