<?php $this->layout('layout', ['title' => $title]) ?>


<h1 class="fdsport-category-title"><?= $title ?></h1>

<div class="fdsport-products-grid fdsport-wrapper">
    <ul class="row fdsport-list">

        <?php foreach ($products as $product): ?>
        
        <li class="col-sm-12 col-md-6 col-lg-4 col-xl-3 d-inline-flex flex-column justify-content-between fdsport-item">
            <div class="d-md-none fdsport-line"></div>

            <div class="fdsport-product-item">
                <div class="d-none d-md-block fdsport-item-title-top"><?= $this->e($product['name']) ?></div>

                <img src="<?= BASE_URL . '/assets/img/200x200.png' ?>" class="img-fluid fdsport-product-image"
                     alt="Image du produit <?= $this->e($product['name']) ?>">

                <div class="fdsport-product-resume">
                    <div class="d-md-none fdsport-item-title"><?= $this->e($product['name']) ?></div>
                    <div class="fdsport-item-category"><?= $this->e($product['category']) ?></div>

                    <div class="fdsport-item-price-promo">
                        <span class="fdsport-item-price"><?= $this->e($product['price']) ?> €</span>
                        <span class="fdsport-item-promo"><?= $this->e($product['discount']) ?>%</span>
                    </div>

                    <span class="fdsport-item-sizes"><?= $this->e($product['sizes']) ?></span>
                    <div class="fdsport-item-colors">
                        <div class="fdsport-item-color fdsport-item-color-blue"></div>
                        <div class="fdsport-item-color fdsport-item-color-yellow"></div>
                        <div class="fdsport-item-color fdsport-item-color-red"></div>
                    </div>
                </div>

                <div class="fdsport-product-favorite-wrapper">
                    <button class="btn fdsport-btn fdsport-btn-favorite fdsport-btn-favorite-<?= ($product['isFavorite'] ? 'true' : 'false') ?>">
                        <i class="fas fa-star fdsport-favorite-star fdsport-favorite-iftrue"></i>
                        <i class="far fa-star fdsport-favorite-star fdsport-favorite-iffalse"></i>
                        <span><?= ($product['isFavorite'] ? 'En favoris' : 'Ajouter aux favoris') ?></span>
                    </button>
                </div>

                <div class="fdsport-product-show-wrapper">
                    <a href="<?= BASE_URL . '/product/show/' . $this->e($product['id']) ?>"
                          class="btn fdsport-btn fdsport-btn-show">Détails</a>
                </div>

                <div class="fdsport-product-addcart-wrapper">
                    <button class="btn fdsport-btn fdsport-btn-addcart">Ajouter au panier</button>
                </div>
            </div>
        </li>

        <?php endforeach; ?>

    </ul>
</div>