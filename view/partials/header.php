<!DOCTYPE html>
<html lang="fr">

<head>
    <title>FD Sport - <?= $this->e($title) ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/fontawesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/fdsport.css">
</head>

<body>

<!-- Header -->
<div id="header" class="d-flex">
    <div id="logo-desktop" class="d-none d-md-block"></div>

    <nav class="navbar navbar-expand-md flex-column navbar-dark bg-dark fdsport-flex-item-fill">
        <div id="menu-top" class="d-flex flex-column flex-md-row-reverse fdsport-flex-item-fill">
            <div class="d-flex justify-content-between">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#menu-dropdown" aria-controls="menu-dropdown" aria-expanded="false"
                        aria-label="Afficher menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div id="account-cart-wrapper" class="d-flex">
                    <button id="account-icon" class="btn fdsport-btn-icon">
                        <i class="fas fa-user" aria-hidden="true"></i>
                    </button>
                    <button id="cart-icon" class="btn fdsport-btn-icon">
                        <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <form id="search-form" class="d-flex flex-nowrap align-items-center fdsport-flex-item-fill">
                <input class="form-control" type="search" placeholder="Recherche" aria-label="Recherche">
                <button class="btn fdsport-btn-icon" type="submit">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </button>
            </form>
        </div>

        <div id="menu-dropdown" class="collapse navbar-collapse">
            <ul class="navbar-nav nav-fill">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Billeterie</a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link" href="#">Supporter mon club</a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link" href="#">Petits prix</a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link" href="#">Pour elles</a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link" href="#">Nos marques</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Trouver un magasin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Nous contacter</a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<!-- Content -->
<div id="content" class="container-fluid">
