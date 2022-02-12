<?php 
require 'check_account.php';
$receipt_id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="menu.css">

    <title></title>
</head>
<body>
    <?php 
    require 'connect.php';
    ?>
    <div id="div_tong">
        <?php 
        require 'menu.php';
        ?>
        <div id="div_tren">
            <h1 style="text-align: center; ">
                Đơn hàng chi tiết
            </h1>
            <form>
                <input type="search" name="tim_kiem" value="" placeholder="tìm kiếm">
            </form>
        </div>
        <div id="div_giua" class="center">
            <?php
            $sql = "select customer_id, receiver_id from receipts where id = '$receipt_id'";
            $result = mysqli_query($connect,$sql);
            $receipt = mysqli_fetch_array($result);
            $receiver_id = $receipt['receiver_id'];
            $id = $receipt['customer_id'];
            if ($customer_id != $id) {
                header('location:index.php');
            }
            $sql = "select * from receivers where customer_id= '$customer_id' and id = '$receiver_id'";
            $result = mysqli_query($connect,$sql);
            $receiver = mysqli_fetch_array($result);

            $sql = "select note
            from receipts
            where
            receipts.id = '$receipt_id' and receipts.receiver_id = '$receiver_id'";
            $result = mysqli_query($connect,$sql);
            $note = mysqli_fetch_array($result);


            

            ?>
            <table width="700px" height="300px" class="border left">
                <tr>
                    <th colspan="2" class="border">
                        Người nhận:
                    </th>
                </tr>
                <tr>
                    <td colspan="2" class="border">


                        Họ và Tên:
                        <?php echo $receiver['name'] ?>
                        <br>
                        Số điện thoại:
                        <?php echo $receiver['phone'] ?>
                        <br>  
                        Địa chỉ:
                        <?php echo $receiver['address'] ?>
                        <br>
                        Note:
                        <?php echo $note['note'];
                        ?>
                    </td>
                </tr>
                <tr>
                    <th class="border" colspan="2">
                        Sản phẩm:
                    </th>
                </tr>
                <?php 
                $sql = "select
                receipts.*,
                receipt_detail.quantity,
                products.name as product_name,
                products.price as product_price,
                products.image as product_image
                from receipts
                join receipt_detail on receipts.id = receipt_detail.receipt_id
                join products on products.id = receipt_detail.product_id
                where
                receipts.id = '$receipt_id'";

                $result = mysqli_query($connect,$sql);
                $receipt = mysqli_fetch_array($result);
                foreach ($result as $each) {
                    $sum = $each['quantity'] * $each['product_price'];
                    ?>
                    <tr>
                        <td class="border" style=" vertical-align: text-top; text-align: left;">
                            <?php echo $each['product_name'] ?>
                            <br>
                            <img width="100px" height="50px" src="admin/products/<?php echo $each['product_image']; ?>">
                        </td>
                        <td class="border" style=" vertical-align: text-top; text-align: right;">
                            <?php echo number_format($each['product_price']) ?> VNĐ
                            <br>
                            x
                            <?php echo $each['quantity'] ?>
                            <br>
                            <?php echo number_format($sum) ?> VNĐ
                        </td>
                    </tr>
                    <?php  
                }
                ?>
                <tr>
                    <th class="border" >
                        Tổng tiền
                    </th>
                    <td class="border right">
                        <?php echo number_format($receipt['total']) ?> VNĐ
                    </td>
                </tr>
            </table>
        </div>
        <div id="div_duoi">
            <?php 
            require 'footer.php';
            ?>
        </div>
    </div>
</body>
</html>