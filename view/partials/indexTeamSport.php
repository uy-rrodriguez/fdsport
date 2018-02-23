<div id="team-sport-home">

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
            <h4 class="fdsport-geoloc-team-name"><?= $team_geoloc ?></h4>
            <h4 class="fdsport-geoloc-sport-name"><?= $sport_geoloc ?></h4>
        </div>
    </div>

    <div id="team-products-change-wrapper" class="d-flex fdsport-wrapper">
        <h5 class="fdsport-flex-item-fill">
            <span class="fdsport-geoloc-team-name"><?= $team_geoloc ?></span>
            n'est pas votre club ?
        </h5>
        <button id="btn-changeteam-home" class="btn fdsport-btn fdsport-btn-change-team">Changer de club</button>
    </div>

</div>


<script>
    $(function () {
        var geolocContainer = $("#team-sport-home");
        var team = geolocContainer.find(".fdsport-geoloc-team-name");
        var sport = geolocContainer.find(".fdsport-geoloc-sport-name");

        function maPosition(position) {
            var data = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            $.ajax({
                method: "POST",
                url: "<?= BASE_URL ?>/geoloc/getTeamSportData/" + data.lat + "," + data.lng,

                beforeSend: function () {
                    team.html("Chargement...");
                    sport.html("Chargement...");
                },

                success: function (data, status, jqXHR) {
                    console.log(data);
                    var dataObj = JSON.parse(data);
                    console.log(dataObj);

                    if (dataObj) {
                        team.html(dataObj.team);
                        sport.html(dataObj.sport);
                    }
                    else {
                        team.html("");
                        sport.html("");
                    }
                },

                error: function () {
                    team.html("");
                    sport.html("");
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
            alert(infopos);
            //$("#geoloc").html(infopos);
        }

        if(navigator.geolocation) {
            // Le paramètre maximumAge met en cache la position
            // pour une durée de 600000 millisecondes (10 minutes),
            // ainsi la position est mise à jour toutes les 10 minutes au maximum.
            navigator.geolocation.getCurrentPosition(maPosition, erreurPosition, {maximumAge: 600000});
        }
    });
</script>