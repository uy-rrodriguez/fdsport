<?php $this->layout('layout', ['title' => $title]) ?>


<h1 class="fdsport-category-title"><?= $title ?></h1>

<!-- Carousel Next matches -->
<div id="carousel-custom-products" class="carousel slide fdsport-carousel fdsport-carousel-products fdsport-wrapper"
     data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carousel-custom-products" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-custom-products" data-slide-to="1"></li>
        <li data-target="#carousel-custom-products" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" data-src="holder.js/900x300?theme=sky&text=First custom product" alt="First custom product">
            <button class="btn fdsport-btn fdsport-btn-addcart">Ajouter au panier</button>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="holder.js/900x300?theme=lava&text=Second custom product" alt="Second custom product">
            <button class="btn fdsport-btn fdsport-btn-addcart">Ajouter au panier</button>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="holder.js/900x300?theme=vine&text=Third custom product" alt="Third custom product">
            <button class="btn fdsport-btn fdsport-btn-addcart">Ajouter au panier</button>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carousel-custom-products" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel-custom-products" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


<?php foreach ($subcategories as $subcat): ?>

<div class="fdsport-line"></div>

<div id="subcategory-<?= $this->e($subcat['id']) ?>" class="fdsport-products-h-list fdsport-wrapper">
    <h3 class="fdsport-list-title"><?= $this->e($subcat['name']) ?></h3>
    <ul class="fdsport-list">
    
        <?php foreach ($subcat['products'] as $product): ?>
        
        <li class="d-inline-flex flex-column justify-content-between fdsport-item">
            <span class="fdsport-item-title"><?= $this->e($product['name']) ?></span>
            <span class="fdsport-item-price"><?= $this->e($product['price']) ?> €</span>
            <span class="fdsport-item-promo"><?= $this->e($product['discount']) ?>%</span>
        </li>
        
        <?php endforeach; ?>

    </ul>
    <a href="<?= $this->e($subcat['btnAllAction']) ?>" class="btn fdsport-btn fdsport-btn-all">Voir tout</a>
</div>

<?php endforeach; ?>