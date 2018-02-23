<?php
require_once 'controller.php';

class geolocCtrl extends Controller {

    private $baseUrl	=	'https://maps.googleapis.com/maps/api/distancematrix/';
    private $format	    =	'json';
    private $apiKey     = 'AIzaSyClfgOKcDVmEb3Id7loq-Ekx30NA_t5TuU';

    function __construct($plates)
    {
        parent::__construct($plates);
    }

    public function getGeolocalizedCity()
    {

        $user_ip = getenv('REMOTE_ADDR');
        $url = 'http://www.geoplugin.net/php.gp?ip=' . $user_ip;

        $geo = unserialize(file_get_contents($url));

        echo 'getGeolocalizedCity: user_ip = ' . $user_ip . '; url = ' . $url . '; geo = '; var_dump($geo); echo '<br>';

        if ($geo['geoplugin_city'])
        {

            return $geo['geoplugin_city'];

        }

        return null;

    }

    public function findNearestTeam($city, $latitude = null, $longitude = null)
    {
        echo 'findNearestTeam: $city = ' . $city . '; url = ' . $latitude . '; $longitude = ' . $latitude; echo '<br>';


        $nearestTeam = array(
            'team'      =>  null,
            'distance'  =>  null
        );

        if ($city == null)
        {
            if ($latitude == null || $longitude == null)
            {
                return null;
            }
        }

        $teams = teamTable::getTeams();

        foreach ($teams as $team)
        {
            $result = $this->findFromCity($city, $team->city);

            if ($result)
            {
                if ($result < $nearestTeam['distance'] || $nearestTeam['distance'] == null)
                {
                    $nearestTeam = array(
                        'team'      =>  $team,
                        'distance'  =>  $result
                    );
                }
            }
        }

        return $nearestTeam['team'];

    }

    private function findFromCity($city, $destinations)
    {
        echo 'findFromCity: $city = ' . $city . '; $destinations = ' . $destinations; echo '<br>';

        if ($city == null)
        {

            return null;

        }

        $origins = strtolower($city);

        $data = [
            'origins'		=>	$origins,
            'destinations'	=>	$destinations,
            'key'			=>	$this->apiKey
        ];

        return $this->sendApiRequest($data);

    }

    private function sendApiRequest($data)
    {
        echo 'sendApiRequest: $data = '; var_dump($data); echo '<br>';


        $url = sprintf("%s?%s", $this->baseUrl.$this->format, http_build_query($data));

        $result = file_get_contents($url);

        $info = json_decode($result, true);

        echo 'sendApiRequest: $url = ' . $url . '; $result = ' . $result . '; $info = '; var_dump($info); echo '<br>';

        if ($info)
        {

            if ($info['rows'][0]['elements'][0]['distance']['value'])
            {

                return floatval($info['rows'][0]['elements'][0]['distance']['value']);

            }

        }

        return null;

    }

}