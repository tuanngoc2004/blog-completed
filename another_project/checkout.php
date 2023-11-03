<?php

include('functions/userfunctions.php');
include('includes/header.php'); 

include('authenticate.php');

$cartItems = getCartItems();

if(mysqli_num_rows($cartItems) == 0)
{
    header('Location: index.php');
}
?>

<div class="py-3 bg-primary">
    <div class="container">
        <h6 class="text-white">
            <a href="index.php" class="text-white">
                Home /
            </a>
            <a href="checkout.php" class="text-white">
                Checkout
            </a>     
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="card">
            <div class="card-body shadow">
                <form action="functions/placeorder.php" method="POST">
                    <div class="row">
                        <div class="col-md-7">
                            <h5>Basic Details</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold">Name</label>
                                    <input type="text" name="name" id="name" required placeholder="Enter your fullname" class="form-control">
                                    <small class="text-danger name"></small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold">Email</label>
                                    <input type="email" name="email" id="email" required placeholder="Enter your email" class="form-control">
                                    <small class="text-danger email"></small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold">Phone</label>
                                    <input type="text" name="phone" id="phone" required placeholder="Enter your phone" class="form-control">
                                    <small class="text-danger phone"></small></div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold">Pin code</label>
                                    <input type="text" name="pincode" id="pincode" required placeholder="Enter your pin code" class="form-control">
                                    <small class="text-danger pincode"></small>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="fw-bold">Address</label>
                                    <textarea name="address" id="address" required class="form-control" rows="5"></textarea>
                                    <small class="text-danger address"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <h5>Order Details</h5>
                            <hr>
                            <?php $items = getCartItems();
                                $totalPrice = 0;
                                foreach ($items as $citem)
                                {
                                    ?>
                                    
                                        <div class="card product_data shadow-sm mb-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                    <img src="uploads/<?= $citem['image'] ?>" alt="Image" width="80px">
                                                </div>
                                                <div class="col-md-4">
                                                    <label><?= $citem['name'] ?></label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label><?= $citem['selling_price'] ?></label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>x <?= $citem['prod_qty'] ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    $totalPrice += $citem['selling_price'] * $citem['prod_qty'];
                                }
                            ?>
                            <hr>
                            <h5>Total Price: <span class="float-end fw-bold"><?= $totalPrice ?></span> </h5>
                            <div class="">
                                <input type="hidden" name="payment_mode" value="COD">
                                <button type="submit" name="placeOrderBtn" class="btn btn-primary w-100">Confirm and place order | COD</button>
                                <div id="paypal-button-container" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>    
        </div>    
    </div>
</div>
    

<?php include('includes/footer.php'); ?>   


<!-- paypal script -->
<script src="https://www.paypal.com/sdk/js?client-id=AS7pNgDv9BC-Bh5x4VlMtxREV7d6rgMeW0ZtDhRRLTjVvmxZAyLGEq6QW7OUyRfIDkrz5JjUOtqI4D2R&currency=USD"></script>
<script>
    

        // Khởi tạo PayPal SDK với Client ID của bạn
        paypal.Buttons({
            onClick(){
                var name = $('#name').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                var pincode = $('#pincode').val();
                var address = $('#address').val();

                if(name.length == 0){
                    $('.name').text("*This field is required");
                }else{
                    $('.name').text("");
                }
                if(email.length == 0){
                    $('.email').text("*This field is required");
                }else{
                    $('.email').text("");
                }
                if(phone.length == 0){
                    $('.phone').text("*This field is required");
                }else{
                    $('.phone').text("");
                }
                if(pincode.length == 0){
                    $('.pincode').text("*This field is required");
                }else{
                    $('.pincode').text("");
                }
                if(address.length == 0){
                    $('.address').text("*This field is required");
                }else{
                    $('.address').text("");
                }

                if(name.length == 0 || email.length == 0 || phone.length == 0 || pincode.length == 0 || address.length == 0 || email.length == 0 || phone.length == 0){
                    return false;
                }
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '0.1' //'<?= $totalPrice ?>'  // Số tiền thanh toán
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    const transaction = orderData.purchase_units[0].payments.captures[0];
                    // alert('Thanh toán thành công!'); // Hiển thị thông báo khi thanh toán thành công

                    var name = $('#name').val();
                    var email = $('#email').val();
                    var phone = $('#phone').val();
                    var pincode = $('#pincode').val();
                    var address = $('#address').val();

                    var data = {
                        'name' : name,
                        'email' : email,
                        'phone' : phone,
                        'pincode' :pincode,
                        'address' : address,
                        'payment_mode' : "Paid by PayPal",
                        'payment_id' : transaction.id,
                        'placeOrderBtn' : true
                    };

                    $.ajax({
                        method: "POST",
                        url: "functions/placeorder.php",
                        data: data,
                        success: function(response)
                        {
                            if(response == 201){
                                alertify.success("Order Placed Succesfully");
                                window.location.href = 'my-orders.php';
                            }
                        }
                    });
                });
            },
            onError: function(err) {
                console.log(err);
                alert('Đã xảy ra lỗi trong quá trình thanh toán.');
            }
        }).render('#paypal-button-container');
    </script>