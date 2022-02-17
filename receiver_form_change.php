<?php 
require 'connect.php';
$customer_id = $_SESSION['customer_id'];
?>
<div class="modal fade" id="modal-receiver-form-change">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<?php 
				$num = $_GET['id'];
				$sql = "select * from receivers where id = '$num' and customer_id = '$customer_id'";
				$result = mysqli_query($connect,$sql);
				$each = mysqli_fetch_array($result);
				?>
				<h3 style="text-align: center; ">
					Sửa thông tin người nhận hàng
				</h3>
			</div>
			<div class="modal-body" id="div-body">
				
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-danger btn-default pull-right" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>
					Cancel
				</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#form-receiver-change').submit(function(event) {
			event.preventDefault();
			$.ajax({
				url: 'receiver_update.php',
				type: 'POST',
				dataType: 'html',
				data: $(this).serializeArray(),
			})
			.done(function(response) {
				$("#modal-receiver").toggle();
			})
		});
	});
</script>