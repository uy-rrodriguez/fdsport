<?php $this->layout('layout', ['title' => $title]) ?>


<h1 class="fdsport-category-title"><?= $title ?></h1>

<div class="fdsport-product fdsport-wrapper">

    <!-- Carousel Product images -->
    <div id="carousel-product-images" class="carousel slide fdsport-carousel fdsport-carousel-product-images">
        <ol class="carousel-indicators">
            <li data-target="#carousel-product-images" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-product-images" data-slide-to="1"></li>
            <li data-target="#carousel-product-images" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block" data-src="holder.js/900x300?theme=sky&text=First event" alt="First event">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="holder.js/900x300?theme=lava&text=Second event" alt="Second event">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="holder.js/900x300?theme=vine&text=Third event" alt="Third event">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carousel-events-home" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-events-home" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <img src="<?= BASE_URL . '/assets/img/200x200.png' ?>" class="img-fluid fdsport-product-image"
         alt="Image du produit <?= $this->e($product['name']) ?>">

    <ul class="fdsport-images-list">

        <?php foreach ($product['images'] as $img): ?>
        
        <li class="col-sm-12 col-md-6 col-lg-4 col-xl-3 d-inline-flex flex-column justify-content-between fdsport-item">
            <div class="d-md-none fdsport-line"></div>

            <div class="fdsport-product-item">
                <div class="d-none d-md-block fdsport-item-title-top"><?= $this->e($product['name']) ?></div>



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