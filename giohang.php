<?php
	session_start();
	include_once "cauhinh.php";
	
	// Thêm sản phẩm vào giỏ
	if(isset($_GET['id']))
	{
		// Đăng ký SESSION nếu chưa tồn tại
		if(!isset($_SESSION['GioHang']))
			$_SESSION['GioHang'] = "";
		
		// Lấy mã sản phẩm từ thanh địa chỉ
		$MaSP = $_GET['id'];
		
		$SoLuongTrongGio = 0;
		if(isset($_SESSION['GioHang'][$MaSP])) // Nếu trong giỏ đã có sản phẩm cùng mã
			$SoLuongTrongGio = $_SESSION['GioHang'][$MaSP] + 1;
		else // Nếu trong giỏ chưa có sản phẩm
			$SoLuongTrongGio =  + 1;
		
		// Cập nhật lại số lượng
		$_SESSION['GioHang'][$MaSP] = $SoLuongTrongGio;
		
		header("giohang.php");
	}
	
	// Cập nhật giỏ hàng
	if(isset($_POST['SoLuong']))
	{
		foreach($_POST['SoLuong'] as $masp => $soluong)
		{
			if($soluong <= 0)
				unset($_SESSION['GioHang'][$masp]);
			else
				$_SESSION['GioHang'][$masp] = $soluong;
		}
		
		header("giohang.php");
	}
	
	$GioRong = 1; // Giả sử giỏ đang rỗng
	$SanPhamTrongGio = array();
	if(isset($_SESSION['GioHang']))
	{
		foreach($_SESSION['GioHang'] as $masp => $soluong)
		{
			if(isset($masp))
			{
				$GioRong = 0; // Giỏ đang có sản phẩm
				$SanPhamTrongGio[] = $masp;
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Quản lý bán hàng</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<h3>Giỏ hàng của tôi</h3>
		<?php
			if($GioRong == 1)
			{
				echo "Giỏ hàng chưa có sản phẩm. Xin vui lòng <a href='sanpham.php'>mua sản phẩm</a>.";
			}
			else
			{
				$strMaSanPham = implode(",", $SanPhamTrongGio);
				$sql = "SELECT * FROM `sanpham` WHERE ID IN($strMaSanPham)";
				$danhsach = mysqli_query($link, $sql);
		?>
				<form action="giohang.php" method="post">
				<table border="1" width="700">
					<tr>
						<th>Xóa</th>
						<th colspan="2">Sản phẩm</th>
						<th>Số lượng</th>
						<th>Đơn giá</th>
						<th>Thành tiền</th>
					</tr>
					<?php
						$TongTien = 0;
						while($dong = mysqli_fetch_array($danhsach))
						{
							echo "<tr>";
								echo "<td align='center'><a href='xoagiohang.php?id=" . $dong['ID'] . "'>Xóa</a></td>";
								echo "<td><img src='products/" . $dong['HinhAnh'] . "' height='100' /></td>";
								echo "<td>" . $dong['TenSanPham'] . "</td>";
								echo "<td align='center'><input type='text' size='3' name='SoLuong[" . $dong['ID'] . "]' value='" . $_SESSION['GioHang'][$dong['ID']] . "' /></td>";
								echo "<td align='right'>" . number_format($dong['GiaBan']) . " đ</td>";
								echo "<td align='right'>" . number_format($_SESSION['GioHang'][$dong['ID']] * $dong['GiaBan']) . " đ</td>";
							echo "</tr>";
							
							$TongTien += $_SESSION['GioHang'][$dong['ID']] * $dong['GiaBan'];
						}
					?>
					<tr>
						<td colspan="3"><b>Tổng tiền</b></td>
						<td colspan="3" align="right"><b><?php echo number_format($TongTien); ?> đ</b></td>
					</tr>
				</table>
				<p>
					<input type="submit" value="Cập nhật giỏ hàng" />
					hoặc <a href="sanpham.php">Mua tiếp sản phẩm</a>
					hoặc <a href="thanhtoan.php">Thanh toán</a>
				</p>
				</form>
		<?php
			}
		?>
	</body>
</html>