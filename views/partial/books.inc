<table class="table">
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Price</th>
        <th></th>
    </tr>
    <?php foreach($model['books'] as $book): 
        $inCart = in_array($book->getId(), $model['cart'])?>
        <tr <?php if($inCart) { ?> class="info" <?php } ?> >
            <td><?php self::htmlOut(($book->getTitle())) ?></td>
            <td><?php self::htmlOut($book->getAuthor()) ?></td>
            <td><?php self::htmlOut($book->getPrice()) ?></td>
            <td>
                <?php if($inCart): ?>
                    <?php self::beginActionForm('Remove', 'Cart', array('bid' => $book->getId(), 'ctx' => $model['context']), 'post'); // action not implemented yet ?>
                        <button class="btn btn-link">Remove from cart</button>
                    <?php self::endActionForm(); ?>
                <?php else: ?>
                    <?php self::beginActionForm('Add', 'Cart', array('bid' => $book->getId(), 'ctx' => $model['context']), 'post'); // action not implemented yet ?>
                        <button class="btn btn-link">Add to cart</button>
                    <?php self::endActionForm(); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>    