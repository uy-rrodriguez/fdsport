<?php $this->layout('layout', ['title' => $title]) ?>


<h1 class="fdsport-category-title"><?= $this->e($product['name']) ?></h1>

<div class="fdsport-item-details fdsport-wrapper">

    <!-- Carousel Product images -->
    <div id="carousel-product-images" class="carousel slide fdsport-carousel fdsport-carousel-product-images">
        <div class="carousel-inner">

            <?php foreach ($product['images'] as $i => $img): ?>

            <div class="carousel-item <?= ($i == 0) ? 'active' : '' ?>">
                <img src="<?= $img ?>" alt="Image <?= $i ?> du produit">
            </div>

            <?php endforeach; ?>

        </div>

        <a class="carousel-control-prev" href="#carousel-product-images" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-product-images" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

        <ol class="carousel-indicators fdsport-carousel-images-indicators">
            <?php foreach ($product['images'] as $i => $img): ?>

                <li data-target="#carousel-product-images" data-slide-to="<?= $i ?>" class="<?= ($i == 0) ? 'active' : '' ?>">
                    <img class="" src="<?= BASE_URL . '/assets/img/200x200.png' ?>">
                </li>

            <?php endforeach; ?>
        </ol>
    </div>

    <div class="fdsport-line"></div>

    <div class="row">
        <div class="col-12 col-md-6 col-lg-5 fdsport-item-actions fdsport-wrapper">
            <div class="fdsport-item-attributes">
                <span class="fdsport-label">Taille</span>
                <select class="form-control fdsport-product-sizes">
                    <?php foreach ($product['sizes'] as $size): ?>
                        <option value="<?= $this->e($size) ?>"><?= $this->e($size) ?></option>
                    <?php endforeach; ?>
                </select>

                <span class="fdsport-label">Couleur</span>
                <div class="fdsport-item-colors">
                    <div class="fdsport-item-color fdsport-item-color-blue"></div>
                    <div class="fdsport-item-color fdsport-item-color-yellow"></div>
                    <div class="fdsport-item-color fdsport-item-color-red"></div>
                </div>
            </div>

            <div class="fdsport-item-price-promo">
                <span class="fdsport-item-promo"><?= $this->e($product['discount']) ?>%</span>
                <span class="fdsport-item-price"><?= $this->e($product['price']) ?> €</span>
            </div>

            <div class="d-flex flex-row flex-wrap justify-content-between align-items-center">
                <div class="fdsport-item-favorite-wrapper">
                    <button class="btn fdsport-btn fdsport-btn-favorite fdsport-btn-favorite-<?= ($product['isFavorite'] ? 'true' : 'false') ?>">
                        <i class="fas fa-star fdsport-favorite-star fdsport-favorite-iftrue"></i>
                        <i class="far fa-star fdsport-favorite-star fdsport-favorite-iffalse"></i>
                        <span><?= ($product['isFavorite'] ? 'En favoris' : 'Ajouter aux favoris') ?></span>
                    </button>
                </div>

                <div class="fdsport-item-addcart-wrapper">
                    <button class="btn fdsport-btn fdsport-btn-addcart">Ajouter au panier</button>
                </div>
            </div>
        </div>

        <div class="col-12 d-md-none">
            <div class="fdsport-line"></div>
        </div>

        <div class="col-12 col-md-6 col-lg-7 fdsport-item-description-wrapper fdsport-wrapper">
            <div class="fdsport-item-description">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                laborum.
            </div>
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


<!-- Profiling viewer -->
<div id="profiling-viewer" class="d-flex flex-row">
    <div class="fdsport-profiling-vars fdsport-flex-item-fill">
        <?php foreach ($profile as $attrib => $value): ?>

            <div class=" d-flex flex-column align-items-center fdsport-profiling-var-item">
                <span class="fdsport-profiling-var-name"><?= $attrib ?></span>
                <span class="fdsport-profiling-var-value fdsport-flex-item-fill"><?= number_format($value, 6) ?></span>
            </div>

        <?php endforeach; ?>
    </div>
    <div class="d-flex justify-content-around flex-column fdsport-profiling-btn-wrapper">
        <a href="<?= BASE_URL . '/profiler' ?>" target="_blank" class="btn btn-primary fdsport-btn-show-graph">Afficher le graphe</a>
        <button class="btn btn-secondary fdsport-btn-hide-viewer">Minimiser</button>
    </div>
</div>

<script>
    $(function () {
        var viewer = $("#profiling-viewer");

        viewer.find(".fdsport-btn-show-graph").click(function (evt) {
            evt.stopPropagation();
        });

        viewer.find(".fdsport-btn-hide-viewer").click(function (evt) {
            evt.preventDefault();
            viewer.addClass("minimized");
            evt.stopPropagation();
        });

        viewer.click(function (evt) {
            evt.preventDefault();
            if (viewer.hasClass("minimized"))
                viewer.removeClass("minimized");
        });
    });
</script>