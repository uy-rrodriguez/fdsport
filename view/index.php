<?php $this->layout('layout', ['title' => $title]) ?>


<div id="logo-mobile-wrapper" class="d-md-none fdsport-wrapper">
    <div id="logo-mobile"></div>
</div>


<pre id="geoloc"></pre>
<script>
    $(function () {
        function maPosition(position) {
            var infopos = "Position déterminée :\n";
            infopos += "Latitude : "+position.coords.latitude +"\n";
            infopos += "Longitude: "+position.coords.longitude+"\n";
            infopos += "Altitude : "+position.coords.altitude +"\n";
            $("#geoloc").html(infopos);


            var data = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            $.ajax({
                method: "POST",
                url: "<?= BASE_URL . '/geoloc/findNearestTeam/' ?>" + JSON.stringify(data),
                success: function (data, status, jqXHR) {
                    $("#geoloc").html(data);
                }
            });
        }

        // Fonction de callback en cas d’erreur
        function erreurPosition(error) {
            var info = "Erreur lors de la géolocalisation : ";
            switch(error.code) {
                case error.TIMEOUT:
                    info += "Timeout !";
                    break;
                case error.PERMISSION_DENIED:
                    info += "Vous n’avez pas donné la permission";
                    break;
                case error.POSITION_UNAVAILABLE:
                    info += "La position n’a pu être déterminée";
                    break;
                case error.UNKNOWN_ERROR:
                    info += "Erreur inconnue";
                    break;
            }
            $("#geoloc").html(infopos);
        }

        if(navigator.geolocation) {
            // Le paramètre maximumAge met en cache la position
            // pour une durée de 600000 millisecondes (10 minutes),
            // ainsi la position est mise à jour toutes les 10 minutes au maximum.
            navigator.geolocation.getCurrentPosition(maPosition, erreurPosition, {maximumAge: 600000});
        }
    });
</script>



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
            <a href="<?= BASE_URL . '/billeterie' ?>" class="btn fdsport-btn fdsport-btn-all">Tous les matches</a>
            <a href="<?= BASE_URL . '/billeterie/show/1' ?>" class="btn fdsport-btn fdsport-btn-buy">Réserver</a>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="holder.js/900x300?theme=lava&text=Second slide" alt="Second slide">
            <a href="<?= BASE_URL . '/billeterie' ?>" class="btn fdsport-btn fdsport-btn-all">Tous les matches</a>
            <a href="<?= BASE_URL . '/billeterie/show/1' ?>" class="btn fdsport-btn fdsport-btn-buy">Réserver</a>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="holder.js/900x300?theme=vine&text=Third slide" alt="Third slide">
            <a href="<?= BASE_URL . '/billeterie' ?>" class="btn fdsport-btn fdsport-btn-all">Tous les matches</a>
            <a href="<?= BASE_URL . '/billeterie/show/1' ?>" class="btn fdsport-btn fdsport-btn-buy">Réserver</a>
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
    <h5 class="fdsport-flex-item-fill"><?= $team_geoloc ?> n'est pas votre club ?</h5>
    <button id="btn-changeteam-home" class="btn fdsport-btn fdsport-btn-change-team">Changer de club</button>
</div>

<!-- Change team modal -->
<div id="modal-changeteam-home" class="modal fade fdsport-modal fdsport-modal-changeteam">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sélectionnez votre club</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Annuler">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <select name="home-sport" class="form-control">
                        <?php foreach ($sports as $sport): ?>

                            <option value="<?= $sport ?>" <?= ($sport_geoloc == $sport ? 'selected' : '') ?> >
                                <?= $sport ?>
                            </option>

                        <?php endforeach; ?>
                    </select>

                    <select name="home-team" class="form-control">
                    <?php foreach ($teams as $team): ?>

                        <option value="<?= $team ?>" <?= ($team_geoloc == $team ? 'selected' : '') ?> >
                            <?= $team ?>
                        </option>

                    <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Valider</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div>
<script language="JavaScript">
    $(function () {
        $("#btn-changeteam-home").click(function () {
            $("#modal-changeteam-home").modal();
        });
    })
</script>


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
