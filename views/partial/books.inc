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