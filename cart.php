<?php 
require 'check_account.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<style type="text/css">
		th, td {
			border:  1px solid black;
			text-align: center;
		}
	</style>
</head>
<body>
	<?php 

	$total = 0;
	require 'announce.php';

	require 'connect.php';
	$status = '1';
	$sql = "select
	products.id as id,
	products.name as name,
	products.image as image,
	manufacturers.name as manufacturer_name,
	products.price as price,
	receipt_detail.quantity as quantity,
	receipts.customer_id as customer_id,
	receipts.id as receipt_id,
	receipts.status as status	
	from receipt_detail
	join receipts on receipts.id = receipt_detail.receipt_id
	join products on products.id = receipt_detail.product_id
	join manufacturers on products.manufacturer_id = manufacturers.id
	where receipts.customer_id = $customer_id and receipts.status = '$status'";
	$result = mysqli_query($connect,$sql);
	
	$rows = mysqli_num_rows($result);
	?>

	<div id="div_tong">
		<?php require 'menu.php'; ?>
		<div id="div_tren">
			<h3>
				Đây là giỏ hàng cá nhân
			</h3>
		</div>
		<div id="div_giua" >
			<?php if ($rows == 0) { ?>
				<h4 class="center">
					Giỏ hàng không có gì !!!
				</h4>
				<?php	
			} else {
				$cart = mysqli_fetch_array($result);
				$receipt_id = $cart['receipt_id'];
				?>
				<table class="border" width="100%">
					<tr>
						<th width="20%">
							Tên sản phẩm
						</th>
						<th>
							Hình ảnh
						</th>
						<th>
							Nhà sản xuất
						</th>
						<th>
							Giá
						</th>
						<th>
							Số lượng
						</th>
						<th>
							Sửa
						</th>
						<th>
							Xoá
						</th>
						<th width="15%">
							Thành tiền
						</th>
					</tr>
					<?php foreach ($result as $each): ?>
						<?php 
						$sum = $each['price'] * $each['quantity'];
						?>
						<tr>
							<td>
								<a href="product_detail.php?id=<?php echo $each['id'] ?>">
									<?php echo $each['name'] ?>
								</a>
							</td>
							<td>
								<img width="200px" height="150px" src="admin/products/<?php echo $each['image']; ?>">
							</td>
							<td>
								<?php echo $each['manufacturer_name'] ?>
							</td>
							<td>
								<?php echo number_format($each['price']) ?> VNĐ
							</td>		
							<td>
								<?php echo $each['quantity'] ?>
							</td>
							<td width=10%>
								<button>
									<a href="cart_process.php?id=<?php echo $each['id'] ?>&type=decrease&page=cart" class="no_decor">
										-
									</a>
								</button>
								<span class="center">
									&nbsp <?php echo $each['quantity'] ?> &nbsp
								</span>
								<button >
									<a href="cart_process.php?id=<?php echo $each['id'] ?>&type=increase&page=cart" class="no_decor">
										+
									</a>
								</button>
							</td>
							<td>
								<a href="cart_process.php?id=<?php echo $each['id'] ?>&type=delete&page=cart">
									Xoá
								</a>
							</td>
							<td>
								<?php echo number_format($sum)?> VNĐ
							</td> 
						</tr>
						<?php 
						$total +=  $sum;
						$sql = "update receipts set total = '$total' where id = '$receipt_id'";
						mysqli_query($connect,$sql);
						?>
					<?php endforeach ?>
					<tr>
						<td colspan="7" class="left" >
							Tổng cộng:
						</td>
						<td>
							<?php 
							echo number_format($total ) . " VNĐ";
							?>
						</td>
					</tr>
					<tr>
						<td colspan="7" class="right" >

						</td>
						<td>
							<button>
								<a href="order_form.php">
									Đặt hàng
								</a>
							</button>
						</td>
					</tr>
				</table>
				<?php 
			}
			?>
		</div>
		<div id="div_duoi">
			<?php 
			require 'footer.php';
			mysqli_close($connect);
			?>
		</div>
	</div>
</body>
</html>