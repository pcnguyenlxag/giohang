<?php
	$link = mysqli_connect("127.0.0.1", "root", "root");
	mysqli_select_db($link, "qlbh");
	mysqli_query($link, "SET NAMES 'utf8'");
?>