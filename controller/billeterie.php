<?php
require_once 'controller.php';

class billeterieCtrl extends Controller {
    function __construct($plates) {
        parent::__construct($plates);
    }

    public function index() {
        $this->all();
    }

    public function show($id) {
        $sports = array('Football', 'Rugby', 'Handball');
        $teams = array('Olympique de Marseille', 'Olympique Lyonnais', 'Paris Saint-Germain');
        
        // Match data
        $match = array(
            'id' => $id,
            'name' => 'Match ' . $id . ' - OM vs OL',
            'price' => $id,
            'date' => '18/02/2018 15:30',
            
            'sport' => $sports[$id % 3],
            'team_home' => $teams[$id % 3],
            'team_visitor' => $teams[($id + 1) % 3],
            
            'places' => array('A', 'B', 'C', 'D'),
            'image' => 'holder.js/400x200?text=Match',
            'description' => 'Description du match ' . $id,
            
            'stadium' => array(
                'name' => 'Olympique de Marseille',
                'address' => '33 Traverse de la Martine',
                'postal_code' => '13011',
                'city' => 'Marseille',
                'telephone' => '+33 4 91 89 20 05'
            )   
        );

        // Associated products
        $products = array();
        for ($i = 1; $i <= 5; $i++) {
            $products[] = array(
                'id' => $i,
                'name' => 'Product '.$i,
                'price' => $i,
                'discount' => $i,
                'image' => 'holder.js/200x200?text=IMG'
            );
        }

        echo $this->plates->render('match', ['title' => 'Match OM vs OL', 'match' => $match, 'recommended' => $products]);
    }

    public function all() {
        $sports = array('Football', 'Rugby', 'Handball');
        $teams = array('Olympique de Marseille', 'Olympique Lyonnais', 'Paris Saint-Germain');
        
        // Get matches from DB
        $matches = array();
        for ($i = 1; $i <= 10; $i++) {
            $matches[] = array(
                'id' => $i,
                'name' => 'Match OM vs OL',
                'price' => $i,
                'date' => '25/02/2018 20:00',
                
                'sport' => $sports[$i % 3],
                'team_home' => $teams[$i % 3],
                'team_visitor' => $teams[($i + 1) % 3],
                
                'image' => 'holder.js/400x200?text=Match',
                'btnBuyAction' => BASE_URL . '/billeterie/show/' . $i
            );
        }

        echo $this->plates->render('match_list', [
            'title' => 'Billeterie',
            'sports' => $sports,
            'teams' => $teams,
            'matches' => $matches
        ]);
    }
}