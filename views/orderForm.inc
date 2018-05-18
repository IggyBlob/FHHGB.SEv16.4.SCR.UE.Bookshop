<?php self::renderView('partial/header', $model); ?>
<div class="container">
    <h1>Order Form</h1>
    <p>You have <?php self::htmlOut($model['cartSize']); ?> item(s) in your cart.</p>
    <p>Please provide your credit card details for payment:</p>
    
    <?php self::beginActionForm('Create', 'Order', null, 'post'); ?>
        <div class="form-group">
            <label for="nameOnCard">Name on card</label>
            <input class="form-control" id="nameOnCard" name="noc" value="<?php self::htmlOut($model['nameOnCard']); ?>">
        </div>
        <div class="form-group">
            <label for="cardNumber">Card number</label>
            <input class="form-control" id="cardNumber" name="cn" value="<?php self::htmlOut($model['cardNumber']); ?>">
        </div>
        <button class="btn btn-primary">Place order</button>
    <?php self::endActionForm(); ?> 
</div>
<?php self::renderView('partial/footer', $model); ?>