<?php
require_once 'controller.php';

class geolocCtrl extends Controller {

    private $distanceUrl	        =	'https://maps.googleapis.com/maps/api/distancematrix/';
    private $geocodingUrl	        =	'https://maps.googleapis.com/maps/api/geocode/json?latlng=[lat],[lng]&key=[key]';
    private $distanceFormat	        =	'json';
    private $distanceApiKey         =   'AIzaSyClfgOKcDVmEb3Id7loq-Ekx30NA_t5TuU';
    private $geocodingApiKey        =   'AIzaSyBVKC8oUa2z1HnWPOTo9T89NAbx6U8LygA';

    function __construct($plates)
    {
        parent::__construct($plates);
    }

    public function getTeamSportData($latlng) {
        $data = array(
            'team' => '',
            'sport' => ''
        );

        $team = $this->findNearestTeam($latlng);

        if ($team) {
            $_SESSION['team_geoloc'] = $team;
            $data['team'] = $team->name;

            $sport = sportTable::getSportById($team->id_sport);

            if ($sport) {
                $_SESSION['sport_geoloc'] = $sport;
                $data['sport'] = $sport->name;
            }
        }

        return json_encode($data);
    }

    public function findNearestTeam($latlng)
    {
        //echo 'findNearestTeam: $latlng = '; var_dump($latlng); echo '<br>';
        $latlngArray = explode(',', $latlng);
        $lat = $latlngArray[0];
        $lng = $latlngArray[1];

        $nearestTeam = null;
        $minDistance = null;


        $address = $this->getGeolocalizedAddress($lat, $lng);

        if ($address == null)
        {
            return null;
        }

        $teams = teamTable::getTeams();

        foreach ($teams as $team)
        {
            $distance = $this->getDistanceAddressCity($address, $team->city);

            if ($distance && ($nearestTeam == null || $distance < $minDistance))
            {
                $nearestTeam = $team;
                $minDistance = $distance;
            }
        }

        return $nearestTeam;

    }


    public function getGeolocalizedAddress($lat, $lng)
    {

        //echo 'getGeolocalizedAddress: $lat = ' . $lat . '; $lng = ' . $lng; echo '<br>';

        $url = str_replace(array('[lat]', '[lng]', '[key]'), array($lat, $lng, $this->geocodingApiKey), $this->geocodingUrl);

        $result = file_get_contents($url);

        $info = json_decode($result, true);

        //echo 'getGeolocalizedAddress: $url = ' . $url . '; $result = ' . $result . '; $info = '; var_dump($info); echo '<br>';

        if ($info)
        {

            if (isset($info['results'][0]['formatted_address']))
            {

                return $info['results'][0]['formatted_address'];

            }

        }

        return null;

        /*
        $user_ip = getenv('REMOTE_ADDR');
        $url = 'http://www.geoplugin.net/php.gp?ip=' . $user_ip;

        $geo = unserialize(file_get_contents($url));

        echo 'getGeolocalizedCity: user_ip = ' . $user_ip . '; url = ' . $url . '; geo = '; var_dump($geo); echo '<br>';

        if ($geo['geoplugin_city'])
        {

            return $geo['geoplugin_city'];

        }

        return null;
        */
    }

    private function getDistanceAddressCity($address, $destination)
    {
        //echo 'findFromCity: $address = ' . $address . '; $destination = ' . $destination; echo '<br>';

        if ($address == null)
        {

            return null;

        }

        $origin = $address; // strtolower($address);

        $data = [
            'origins'		=>	$origin,
            'destinations'	=>	$destination,
            'key'			=>	$this->distanceApiKey
        ];

        return $this->sendDistanceRequest($data);

    }

    private function sendDistanceRequest($data)
    {
        //echo 'sendDistanceRequest: $data = '; var_dump($data); echo '<br>';


        $url = sprintf("%s?%s", $this->distanceUrl.$this->distanceFormat, http_build_query($data));

        $result = file_get_contents($url);

        $info = json_decode($result, true);

        //echo 'sendDistanceRequest: $url = ' . $url . '; $result = ' . $result . '; $info = '; var_dump($info); echo '<br>';

        if ($info && isset($info['rows'][0]['elements'][0]['distance']['value']))
        {
            return $info['rows'][0]['elements'][0]['distance']['value']; //floatval($info['rows'][0]['elements'][0]['distance']['value']);
        }

        return null;

    }

}