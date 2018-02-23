<?php
require_once 'controller.php';
require_once 'geoloc.php';

class indexCtrl extends Controller {
    function __construct($plates) {
        parent::__construct($plates);
    }

    private function loadTeamByGeoloc() {
        $_SESSION['team_geoloc'] = null;
        $_SESSION['sport_geoloc'] = null;

        $geolocCtrl = new geolocCtrl($this->plates);

        $city = $geolocCtrl->getGeolocalizedCity();
        echo 'City: '; var_dump($city); echo '<br>';

        $team = $geolocCtrl->findNearestTeam($city);
        echo 'Team: '; var_dump($team); echo '<br>';

        if ($team != null) {
            $_SESSION['team_geoloc'] = $team->name;

            $sport = sportTable::getSportById($team->id_sport);
            echo 'Sport: '; var_dump($sport); echo '<br>';

            if ($sport != null) {
                $_SESSION['sport_geoloc'] = $sport->name;
            }
        }
    }

    public function index() {
        
        /*
        $sports = array('Football', 'Rugby', 'Handball');
        $teams = array('Olympique de Marseille', 'Olympique Lyonnais', 'Paris Saint-Germain');
        */
        
        $sportsInDB = sportTable::getSports();
        $sports = array();
        
        foreach ($sportsInDB as $sport)
        {
            
            $sports[] = ucfirst($sport->name);
            
        }
        
        $teamsInDB = teamTable::getTeams();
        $teams = array();
        
        foreach ($teams as $team)
        {
            
            $teams[] = $team->name;
            
        }


        // Search team and sport by geolocalization
        $sport_geoloc = 'Football';
        $team_geoloc = 'Olympique Lyonnais';

        $this->loadTeamByGeoloc();
        
        //$context = context::getInstance();
        
        //$sportInContext = $context->getSessionAttribute('sport_geoloc');
        $sportInContext = $_SESSION['sport_geoloc'];
        
        if ($sportInContext != null)
        {
        
            $sport_geoloc = $sportInContext;
        
        }
        
        //$teamInContext = $context->getSessionAttribute('team_geoloc');
        $teamInContext = $_SESSION['team_geoloc'];
        
        if ($teamInContext != null)
        {
        
            $team_geoloc = $teamInContext;
        
        }

        /*
        $products = array();
        for ($i = 1; $i <= 10; $i++) {
            $products[] = array(
                'id' => $i,
                'name' => 'Product '.$i,
                'price' => $i,
                'discount' => $i
            );
        }
        */

        // Load index products
        $productsInDB = productTable::getProducts();
        
        $littlePrice = array();
        $forHer = array();
        $ourBrend = array();
        $products = array();
        
        foreach ($productsInDB as $productInDB)
        {
            
            $product = array(
                'id'        =>  $productInDB->id,
                'name'      =>  $productInDB->name,
                'price'     =>  $productInDB->price,
                'discount'  =>  $productInDB->promotion
            );
            
            if ($productInDB->price < 50)
            {
                
                $littlePrice[] = $product;
                
            }
            
            if ($productInDB->gender == 'F')
            {
                
                $forHer[] = $product;
                
            }
            
            if ($productInDB->brand != '')
            {
                
                $ourBrend[] = $product;
                
            }
            
            $products[] = $product;
            
        }

        /*
        $cats = array();
        $catsNames = array('Petits prix', 'Pour elles', 'Nos marques', '');
        for ($i = 1; $i <= 3; $i++) {
            $cats[] = array(
                'id' => $i,
                'title' => $catsNames[$i-1],
                'btnAllAction' => BASE_URL . '/category/show/' . $i,
                'products' => $products
            );
        }
        */
        
        $cats = [
            array(
                'id'            =>  1,
                'title'         =>  'Petit prix',
                'btnAllAction'  =>  BASE_URL . '/category/show/1',
                'products'      =>  $littlePrice
            ),
            array(
                'id'            =>  2,
                'title'         =>  'Pour elles',
                'btnAllAction'  =>  BASE_URL . '/category/show/2',
                'products'      =>  $forHer
            ),
            array(
                'id'            =>  3,
                'title'         =>  'Nos Marques',
                'btnAllAction'  =>  BASE_URL . '/category/show/3',
                'products'      =>  $ourBrend
            ),
            array(
                'id'            =>  4,
                'title'         =>  '',
                'btnAllAction'  =>  BASE_URL . '/category/show/4',
                'products'      =>  $products
            )
        ];
        
        // Render a template
        echo $this->plates->render('index', [
            'title' => 'Accueil',
            'sport_geoloc' => $sport_geoloc,
            'team_geoloc' => $team_geoloc,
            'sports' => $sports,
            'teams' => $teams,
            'categories' => $cats
        ]);
    }
}