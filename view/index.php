<?php $this->layout('layout', ['title' => $title]) ?>


<div id="logo-mobile-wrapper" class="d-md-none fdsport-wrapper">
    <div id="logo-mobile"></div>
</div>

<div class="d-md-none fdsport-line"></div>

<!-- Carousel Next matches -->
<div id="carousel-matches-home" class="carousel slide fdsport-carousel fdsport-carousel-matches fdsport-wrapper"
     data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carousel-matches-home" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-matches-home" data-slide-to="1"></li>
        <li data-target="#carousel-matches-home" data-slide-to="2"></li>
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
    <a class="carousel-control-prev" href="#carousel-matches-home" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel-matches-home" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


<div id="team-products-wrapper" class="fdsport-wrapper">
    <div id="team-products-banner">
        <h3>Supporter mon club</h3>
    </div>
</div>

<div id="team-products-change-wrapper" class="d-flex fdsport-wrapper">
    <h5 class="fdsport-flex-item-fill">L'OM n'est pas votre club ?</h5>
    <button class="btn fdsport-btn fdsport-btn-change-team">Changer de club</button>
</div>

<div class="fdsport-line"></div>

<!-- Carousel Next events -->
<div id="carousel-events-home" class="carousel slide fdsport-carousel fdsport-carousel-events fdsport-wrapper"
     data-ride="carousel" data-interval="7000">
    <ol class="carousel-indicators">
        <li data-target="#carousel-events-home" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-events-home" data-slide-to="1"></li>
        <li data-target="#carousel-events-home" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" data-src="holder.js/900x300?theme=sky&text=First event" alt="First event">
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


<?php foreach ($categories as $category): ?>

    <div class="fdsport-line"></div>

    <?php
        $this->insert('partials/productHList', [
            'id'            => 'home-category-' . $category['id'],
            'title'         => $category['title'],
            'btnAllAction'  => $category['btnAllAction'],
            'products'      => $category['products']
        ]);
    ?>

<?php endforeach; ?>