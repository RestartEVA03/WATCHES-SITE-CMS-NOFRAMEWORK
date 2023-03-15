<?php if (!empty($products)): ?>
    <?php $curr = \watchesshop\App::$app->getProperty('currency'); ?>
    <?php foreach ($products as $product): ?>
        <div class="col-md-4 product-left p-left">
            <div class="product-main simpleCart_shelfItem">
                <a href="product/<?= $product->alias; ?>" class="mask"><img class="img-responsive zoom-img"
                                                                            src="images/<?= $product->img; ?>"
                                                                            alt=""/></a>
                <div class="product-bottom">
                    <h3><?= $product->title; ?></h3>
                    <p>Explore Now</p>
                    <h4>
                        <a data-id="<?= $product->id; ?>" class="add-to-cart-link"
                           href="cart/add?id=<?= $product->id; ?>"><i></i></a>
                        <span class=" item_price"><?= $curr['symbol_left'] ?><?= $product->price * $curr['value']; ?></span>
                        <?php if ($product->old_price): ?>
                            <small>
                                <del><?= $product->old_price * $curr['value']; ?></del>
                            </small>
                        <?php endif; ?>
                    </h4>
                </div>
                <?php if ($product->old_price && $product->old_price > $product->price): ?>
                    <div class="srch">
                        <span><?= round(($product->old_price - $product->price) / ($product->old_price / 100)); ?>%</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="clearfix"></div>
    <div class="text-center">
        <p>(<?= count($products); ?> товара(ов) из <?= $total; ?></p>
        <?php if ($pagination->countPages > 1): ?>
            <?php echo $pagination; ?>
        <?php endif; ?>
    </div>
<?php else: ?>
    <h3>Товары не найдены...</h3>
<?php endif; ?>
