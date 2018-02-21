<?php
/*
 * This template needs to be passed this variables:
 *  - id: This id will be used to identify the div block containing the list
 *  - title: Title to be printed before the product list
 *  - btnAllAction: Action link for when the user will press the button under the list
 *  - products: List of products. each item must contain the following attributes:
 *      - id: Id of the product, used to generate the item action link
 *      - name: Name of this product
 *      - price: Current price
 *      - discount: An optional discount percentage value
 */
?>

<div id="<?= $this->e($id) ?>" class="fdsport-products-h-list fdsport-wrapper">
    <h3 class="fdsport-list-title"><?= $this->e($title) ?></h3>
    <ul class="fdsport-list">
        
        <?php foreach ($products as $product): ?>

        <li class="d-inline-flex flex-column justify-content-between fdsport-item">
            <span class="fdsport-item-title"><?= $this->e($product['name']) ?></span>
            <span class="fdsport-item-price"><?= $this->e($product['price']) ?> €</span>
            <span class="fdsport-item-promo"><?= $this->e($product['discount']) ?>%</span>
            <a href="<?= BASE_URL . '/product/show/' . $this->e($product['id']) ?>" class="fdsport-item-link"></a>
        </li>
        
        <?php endforeach; ?>
        
    </ul>
    <a href="<?= $this->e($btnAllAction) ?>" class="btn fdsport-btn fdsport-btn-all">Voir tout</a>
</div>
