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

    <?php if($model['selectedCategoryId'] != null): ?>
        <?php if(sizeof($model['books']) > 0) {
            self::renderView('partial/books', array('books' => $model['books'], 'cart' => $model['cart'], 'context' => $model['context']));
        } else { ?>
            <p>No books in this category.</p>
        <?php } ?>
    <?php else: ?>
        <p>Please select a category.</p>
    <?php endif; ?>

</div>
<?php self::renderView('partial/footer', $model); ?>