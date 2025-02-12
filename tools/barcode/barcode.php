<html>
<head>
<title>Print Barcode</title>
<style>
p.inline {display: inline-block;}
span { font-size: 13px;}
</style>

<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */

    }
</style>
<link rel="icon" href="../../dist/img/AdminLTELogo.png" type="image/ico">
</head>
<body onload="window.print();">
	<div style="margin-left: 5%">
		<?php
		include 'barcode128.php';
		$tools_name = $_POST['tools_name'];
		$barcode = $_POST['barcode'];
		$price = $_POST['price'];

		for($i=1;$i<=$_POST['print_qty'];$i++){
			echo "<p class='inline'><span ><b>Item: $tools_name</b></span>".bar128(stripcslashes($_POST['barcode']))."<span ><span></p>&nbsp&nbsp&nbsp&nbsp";
		}

		?>
	</div>
</body>
</html>