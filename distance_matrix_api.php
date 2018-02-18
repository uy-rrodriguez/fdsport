<?php

error_reporting(E_ALL);
ini_set("display_errors", true);

require_once 'lib/core.php';
require_once 'configuration/constants.php';

if (!isset($_SESSION)) {
	session_start();
}

// Context initialisation
$nameApp = 'fdsport';
$context = context::getInstance();
$context->init($nameApp);

class DistanceMatrixApi
{

	function __construct($distance)
	{

		$this->distance	=	$distance;

		$this->baseUrl	=	'https://maps.googleapis.com/maps/api/distancematrix/';
		$this->format	=	'json';
		$this->apiKey	=	'AIzaSyClfgOKcDVmEb3Id7loq-Ekx30NA_t5TuU';

	}

	function checkCity($city, $latitude = null, $longitude = null)
	{
        
        $nearestTeams = array();

        $teams = teamTable::getTeams();
        
        foreach ($teams as $team)
        {
            
            $result = $this->findFromCity($city, $team->city);
            
            if ($result)
            {
                
                array_push($nearestTeams, $team);
                
            }
            
        }
        
        return $nearestTeams;

	}

	private function findFromCity($city, $destinations)
	{

		if ($city == null)
		{

			return null;

		}

		$origins = strtolower($city);

		$data = [
			"origins"		=>	$origins,
			"destinations"	=>	$destinations,
			"key"			=>	$this->apiKey
		];

		return $this->sendApiRequest($data);

	}

	private function sendApiRequest($data)
	{

		$url = sprintf("%s?%s", $this->baseUrl.$this->format, http_build_query($data));

		$result = file_get_contents($url);

	    $info = json_decode($result, true);

	    if ($info)
	    {

			if ($info["rows"][0]["elements"][0]["distance"]["value"] <= $this->distance)
			{

				return true;

			}
			else
			{

				return false;

			}

	    }

	}

}

$api = new DistanceMatrixApi(50000);

$teams = $api->checkCity('lunel');

var_dump($teams);

?>