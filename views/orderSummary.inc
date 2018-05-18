<?php self::renderView('partial/header', $model); ?>
<div class="container">
    <h1>Order Summary</h1>
    <p>Thank you for your purchase!</p>
    <p>Your order number is #<?php self::htmlOut($model['orderId']); ?></p>
</div>
<?php self::renderView('partial/footer', $model); ?>