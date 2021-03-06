
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>91springboard Admin Portal</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />
<link rel="stylesheet" href="css/form-field-tooltip.css" type="text/css" media="screen,projection" />
<link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css">
<!--[if lte IE 6.5]>
<link rel="stylesheet" type="text/css" href="library/js_date/select-free.css"/>
<![endif]-->

</head>
<script src="library/js_date/date-functions.js" type="text/javascript"></script>
<script src="library/js_date/datechooser.js" type="text/javascript"></script>
<script src="library/javascript/pages_common.js" type="text/javascript"></script>
<script src="library/javascript/rounded-corners.js" type="text/javascript"></script>
<script src="library/javascript/form-field-tooltip.js" type="text/javascript"></script>
<script type="text/javascript" src="library/javascript/ajax.js"></script>
<script type="text/javascript" src="library/javascript/ajaxGeneric.js"></script>
<body>

<?php
    include_once ("lang/main.php");
?>

<div id="wrapper">
<div id="innerwrapper">

<?php
	$m_active = "Accounting";
        include_once ("include/menu/menu-items.php");
	include_once ("include/menu/accounting-subnav.php");
        include_once("include/management/autocomplete.php");
?>	

<div id="sidebar">

	<h2>Accounting</h2>
	
	<h3>Users Accounting</h3>
	<ul class="subnav">
	
		<li><a href="javascript:document.acctusername.submit();"><b>&raquo;</b><?php echo $l['button']['UserAccounting'] ?></a>
			<form name="acctusername" action="acct-username.php" method="get" class="sidebar">
			<input name="username" type="text" id="usernameAcct" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
                                onClick='javascript:__displayTooltip();'
                                tooltipText='<?php echo $l['Tooltip']['Username']; ?>'
				value="<?php if (isset($accounting_username)) echo $accounting_username; ?>">
			</form></li>

		<li><a href="javascript:document.acctipaddress.submit();"><b>&raquo;</b><?php echo $l['button']['IPAccounting'] ?></a>
			<form name="acctipaddress" action="acct-ipaddress.php" method="get" class="sidebar">
			<input name="ipaddress" type="text" 
                                onClick='javascript:__displayTooltip();'
                                tooltipText='<?php echo $l['Tooltip']['IPAddress']; ?>'
				value="<?php if (isset($accounting_ipaddress)) echo $accounting_ipaddress; ?>">
			</form></li>

		<li><a href="javascript:document.acctnasipaddress.submit();"><b>&raquo;</b><?php echo $l['button']['NASIPAccounting'] ?></a>
			<form name="acctnasipaddress" action="acct-nasipaddress.php" method="get" class="sidebar">
			<input name="nasipaddress" type="text" 
                                onClick='javascript:__displayTooltip();'
                                tooltipText='<?php echo $l['Tooltip']['IPAddress']; ?>'
				value="<?php if (isset($accounting_nasipaddress)) echo $accounting_nasipaddress; ?>">
			</form></li>

		<li><a href="javascript:document.acctdate.submit();"><b>&raquo;</b><?php echo $l['button']['DateAccounting'] ?></a>
			<form name="acctdate" action="acct-date.php" method="get" class="sidebar">
			<input name="username" type="text" id="usernameDate" <?php if ($autoComplete) echo "autocomplete='off'"; ?>
                                onClick='javascript:__displayTooltip();'
                                tooltipText='<?php echo $l['Tooltip']['Username']; ?>'
				value="<?php if (isset($accounting_date_username)) echo $accounting_date_username;  ?>">
			<input name="startdate" type="text" id="startdate" 
                                onClick='javascript:__displayTooltip();'
                                tooltipText='<?php echo $l['Tooltip']['Date']; ?>'
				value="<?php if (isset($accounting_date_startdate)) echo $accounting_date_startdate;
			else echo date("Y-m-01"); ?>">
			
			<img src="library/js_date/calendar.gif" 
				onclick="showChooser(this, 'startdate', 'chooserSpan', 1950, <?= date('Y', time());?>, 'Y-m-d', false);">
			<div id="chooserSpan" class="dateChooser select-free" 
				style="display: none; visibility: hidden; 	width: 160px;"></div>

			<input name="enddate" type="text" id="enddate" 
                                onClick='javascript:__displayTooltip();'
                                tooltipText='<?php echo $l['Tooltip']['Date']; ?>'
				value="<?php if (isset($accounting_date_enddate)){ echo $accounting_date_enddate;}
				else { echo date("Y-m-t");} ?>">
			<img src="library/js_date/calendar.gif" 
				onclick="showChooser(this, 'enddate', 'chooserSpan', 1950, <?= date('Y', time());?>, 'Y-m-d', false);">
			<div id="chooserSpan" class="dateChooser select-free" 
				style="display: none; visibility: hidden; width: 160px;"></div>

			</form></li>

		<li><a href="acct-all.php"><b>&raquo;</b><?php echo $l['button']['AllRecords'] ?></a></li>
		<li><a href="acct-active.php"><b>&raquo;</b><?php echo $l['button']['ActiveRecords'] ?></a></li>

	</ul>

	<br/><br/>
	<h2>Search</h2>
	<input name="" type="text" value="Search" />

</div>

<?php
        include_once("include/management/autocomplete.php");

        if ($autoComplete) {
                echo "<script type=\"text/javascript\">
                      autoComEdit = new DHTMLSuite.autoComplete();
                      autoComEdit.add('usernameDate','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');

                      autoComEdit = new DHTMLSuite.autoComplete();
                      autoComEdit.add('usernameAcct','include/management/dynamicAutocomplete.php','_small','getAjaxAutocompleteUsernames');
                      </script>";
        }
?>

<script type="text/javascript">
        var tooltipObj = new DHTMLgoodies_formTooltip();
        tooltipObj.setTooltipPosition('right');
        tooltipObj.setPageBgColor('#EEEEEE');
        tooltipObj.setTooltipCornerSize(15);
        tooltipObj.initFormFieldTooltip();
</script>
