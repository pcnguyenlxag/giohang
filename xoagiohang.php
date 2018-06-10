<?php
	session_start();
	
	// Lấy mã sản phẩm từ thanh địa chỉ
	$MaSP = $_GET['id'];
	
	unset($_SESSION['GioHang'][$MaSP]);
	
	header("Location: giohang.php");
?>