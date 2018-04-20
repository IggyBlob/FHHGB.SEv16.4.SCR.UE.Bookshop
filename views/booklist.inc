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
        <?php if(sizeof($model['books']) > 0) { ?>
            <table class="table">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th></th>
                </tr>
                <?php foreach($model['books'] as $book): ?>
                    <tr>
                        <td><?php self::htmlOut(($book->getTitle())) ?></td>
                        <td><?php self::htmlOut($book->getAuthor()) ?></td>
                        <td><?php self::htmlOut($book->getPrice()) ?></td>
                        <td><?php self::htmlOut("") ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>    
        <?php } else { ?>
            <p>No books in this category.</p>
        <?php } ?>
    <?php else: ?>
        <p>Please select a category.</p>
    <?php endif; ?>

</div>
<?php self::renderView('partial/footer', $model); ?>