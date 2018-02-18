<?php $this->layout('layout', ['title' => $title]) ?>


<h1 class="fdsport-category-title"><?= $this->e($match['name']) ?></h1>

<div class="fdsport-item-details fdsport-wrapper">

    <div class="fdsport-match-image-wrapper">
        <img src="<?= $this->e($match['image']) ?>" class="fdsport-match-image"
             alt="Image du match <?= $this->e($match['name']) ?>">
    </div>

    <div class="fdsport-line"></div>

    <div class="row">
        <div class="col-12 col-md-5 col-lg-4 fdsport-item-actions fdsport-wrapper">
            <div class="fdsport-item-attributes">
                <span class="fdsport-label">Emplacement</span>
                <select class="form-control fdsport-match-places">
                    <?php foreach ($match['places'] as $place): ?>
                        <option value="<?= $this->e($place) ?>"><?= $this->e($place) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="fdsport-item-price-promo">
                <span class="fdsport-item-price"><?= $this->e($match['price']) ?> €</span>
            </div>

            <div class="d-flex flex-row flex-wrap justify-content-end align-items-center">
                <div class="fdsport-item-addcart-wrapper">
                    <button class="btn fdsport-btn fdsport-btn-addcart">Ajouter au panier</button>
                </div>
            </div>
        </div>

        <div class="col-12 d-md-none">
            <div class="fdsport-line"></div>
        </div>

        <div class="col-12 col-md-7 col-lg-8 fdsport-item-description-wrapper">
            <div class="fdsport-item-description fdsport-wrapper">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                laborum.
            </div>

            <div class="fdsport-line"></div>

            <div class="fdsport-match-address-wrapper fdsport-wrapper">
                <div class="fdsport-match-stadium"><?= $this->e($match['stadium']['name']) ?></div>
                <div class="fdsport-match-address"><?= $this->e($match['stadium']['address']) ?></div>
                <div class="fdsport-match-city"><?= $this->e($match['stadium']['postal_code']) ?> <?= $this->e($match['stadium']['city']) ?></div>
                <div class="fdsport-match-telephone">
                    <a href="tel:<?= $this->e($match['stadium']['telephone']) ?>"><?= $this->e($match['stadium']['telephone']) ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="fdsport-line"></div>

    <!-- Carousel Next matches -->
    <div class="fdsport-wrapper">
        <h3 class="fdsport-list-title">Prochains matches</h3>

        <div id="carousel-next-matches" class="carousel slide fdsport-carousel fdsport-carousel-matches"
             data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel-next-matches" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-next-matches" data-slide-to="1"></li>
                <li data-target="#carousel-next-matches" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" data-src="holder.js/900x300?theme=sky&text=First slide" alt="First slide">
                    <button class="btn fdsport-btn fdsport-btn-all">Tous les matches</button>
                    <button class="btn fdsport-btn fdsport-btn-buy">Réserver</button>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="holder.js/900x300?theme=lava&text=Second slide" alt="Second slide">
                    <button class="btn fdsport-btn fdsport-btn-all">Tous les matches</button>
                    <button class="btn fdsport-btn fdsport-btn-buy">Réserver</button>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="holder.js/900x300?theme=vine&text=Third slide" alt="Third slide">
                    <button class="btn fdsport-btn fdsport-btn-all">Tous les matches</button>
                    <button class="btn fdsport-btn fdsport-btn-buy">Réserver</button>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carousel-next-matches" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-next-matches" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <div class="fdsport-line"></div>
    
    <?php
        $this->insert('partials/productHList', [
            'id'            => 'recommended-products',
            'title'         => 'Pourraient vous intéresser',
            'btnAllAction'  => BASE_URL . '/product/allRecommended',
            'products'      => $recommended
        ]);
    ?>

</div>