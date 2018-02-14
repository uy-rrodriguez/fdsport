<?php

class FootballDataApi
{

	function __construct()
	{

		$this->baseUrl	=	'http://api.football-data.org/v1/';
		$this->apiKey	=	'5c5aeda9509743c0986277c6ee7c63c0';

	}

	function getCompetitions()
	{

		$schemeUrl = 'competitions/';

		$data = [
			'season'	=>	date('Y')
		];

		return $this->sendApiRequest($schemeUrl, $data);

	}

	function getTeams($competitionId)
	{

		$schemeUrl = 'competitions/'.$competitionId.'/teams';

		return $this->sendApiRequest($schemeUrl);

	}

	private function sendApiRequest($schemeUrl, $data = null)
	{

		$url = $this->baseUrl.$schemeUrl;

		if ($data != null)
		{

			$url = sprintf("%s?%s", $url, http_build_query($data));

		}
		
		$options = array(
			'http'	=>	array(
				'header'	=>	"Content-Type: application/json\r\n".
								"X-Auth-Token: ".$this->apiKey."\r\n".
								"X-Response-Control: minified"
			)
		);

		$context = stream_context_create($options);

		$result = file_get_contents($url, false, $context);

		return json_decode($result, true);

	}

}

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

		$result = sendApiRequest($data);

		if ($result == null)
		{

			return null;

		}

		return null;

	}

	private function sendApiRequest($data)
	{

		$url = sprintf("%s?%s", $this->baseUrl.$this->format, http_build_query($data));

		$result = file_get_contents($url);

	    $info = json_decode($result, true);

	    if ($info)
	    {

			if ($info["rows"][0]["elements"][0]["distance"]["value"] <= 50000)
			{

				// OK

			}
			else
			{

				// NOT OK

			}

	    }

	}

}

$api = new FootballDataApi();

$competitions = $api->getCompetitions();

var_dump($competitions);

?>