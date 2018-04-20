<?php self::renderView('partial/header', $model); ?>
<div class="container">
    <h1>List of Books</h1>
    <p>
        <ul class="nav nav-pills" role="tablist">
            <?php foreach ($model['categories'] as $cat) { ?>
                <li role="presentation">
                    <?php self::actionLink($cat->getName(), 'Index', 'Books', array('cid' => $cat->getId())); ?>
                </li>
            <?php } ?>
        </ul>
    </p>
</div>
<?php self::renderView('partial/footer', $model); ?>