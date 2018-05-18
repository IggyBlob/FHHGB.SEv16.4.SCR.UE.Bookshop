<ul class="nav navbar-nav">
<?php if(!isset($model)): ?>
    <li><?php self::actionLink('Login', 'LogIn', 'User'); ?></li>
<?php else: ?>
    <li class="navbar-text">Welcome, <?php self::htmlOut($model->getUserName()); ?></li>
    <li>
        <?php self::beginActionForm('LogOut', 'User', null, 'post', 'navbar-form'); ?>
            <button class="btn btn-link">Log out</button>
        <?php self::endActionForm(); ?>
    </li>
<?php endif; ?>
</ul>