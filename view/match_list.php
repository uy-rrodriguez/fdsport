<?php $this->layout('layout', ['title' => $title]) ?>


<h1 class="fdsport-category-title"><?= $this->e($title) ?></h1>

<div class="fdsport-matches-grid fdsport-wrapper">

    <div class="d-flex flex-column flex-md-row fdsport-matches-filters fdsport-wrapper">
        <select name="match-sport" class="form-control fdsport-flex-item-fill">
            <option value="">Sélectionner un sport</option>
            
            <?php foreach ($sports as $sport): ?>
                <option value="<?= $this->e($sport) ?>"><?= $this->e($sport) ?></option>
            <?php endforeach; ?>
        </select>
        
        <select name="match-team" class="form-control fdsport-flex-item-fill">
            <option value="">Sélectionner un club</option>
            
            <?php foreach ($teams as $team): ?>
                <option value="<?= $this->e($team) ?>"><?= $this->e($team) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <ul class="row fdsport-list">

        <?php foreach ($matches as $match): ?>
        
        <li class="col-sm-12 col-md-6 col-xl-4 fdsport-item">
            <div class="fdsport-match-item">
                <img src="<?= $this->e($match['image']) ?>" class="img-fluid fdsport-match-image"
                     alt="Image du match <?= $this->e($match['name']) ?>">

                <div class="fdsport-match-date"><?= $this->e($match['date']) ?></div>
                
                <div class="d-flex flex-column justify-content-end fdsport-match-price">
                    <span class="fdsport-match-price-label">À partir de</span>
                    <span class="fdsport-match-price-price"><?= $this->e($match['price']) ?> €</span>
                </div>

                <div class="d-flex justify-content-end align-items-end fdsport-match-buy-wrapper">
                    <a href="<?= $this->e($match['btnBuyAction']) ?>" class="btn fdsport-btn fdsport-btn-buy">Réserver</a>
                </div>
            </div>
        </li>

        <?php endforeach; ?>

    </ul>
</div>