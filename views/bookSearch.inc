<?php self::renderView('partial/header', $model); ?>
<div class="container">
    <h1>Search</h1>
    <p>
        <?php self::beginActionForm('Search', 'Books', null, 'get', 'form-inline'); ?>
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" id="title" name="title">
            </div>
            <button class="btn btn-primary">Search</button>
        <?php self::endActionForm(); ?>
    </p>
    <?php if ($model['books'] !== null): ?>
        <?php if(sizeof($model['books']) > 0) {
            self::renderView('partial/books', array('books' => $model['books']));
        } else { ?>
            <p>No matching books found.</p>
        <?php } ?>
    <?php endif; ?>
</div>
<?php self::renderView('partial/footer', $model); ?>