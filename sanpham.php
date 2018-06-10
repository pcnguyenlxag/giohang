<?php
	include_once "cauhinh.php";
	$sql = "SELECT * FROM `sanpham` WHERE 1";
	$danhsach = mysqli_query($link, $sql);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Quản lý bán hàng</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<h3>Danh sách sản phẩm</h3>
		<?php
			while($dong = mysqli_fetch_array($danhsach))
			{
				echo "<div class='SanPham'>";
					echo "<p class='HinhAnh'><img src='products/" . $dong['HinhAnh'] . "' height='100' /></p>";
					echo "<p class='TenSanPham'>" . $dong['TenSanPham'] . "</p>";
					echo "<p class='GiaBan'>" . number_format($dong['GiaBan']) . " đ</p>";
					echo "<p><a href='giohang.php?id=" . $dong['ID'] . "'>Thêm vào giỏ hàng</a></p>";
				echo "</div>";
			}
		?>
	</body>
</html>