<?php

function getGeolocalizedCity()
{
    
    $user_ip = getenv('REMOTE_ADDR');
    
    $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
    
    if ($geo['geoplugin_city'])
    {
        
        return $geo['geoplugin_city'];
        
    }
    
    return null;
    
}

class DistanceMatrixApi
{

	function __construct()
	{

		$this->baseUrl	=	'https://maps.googleapis.com/maps/api/distancematrix/';
		$this->format	=	'json';
		$this->apiKey	=	'AIzaSyClfgOKcDVmEb3Id7loq-Ekx30NA_t5TuU';

	}

	function findNearestTeam($city, $latitude = null, $longitude = null)
	{
        
        if ($city == null)
        {
            
            if ($latitude == null || $longitude == null)
            {
                
                return null;
                
            }
            
        }
        
        $nearestTeam = array(
            'team'      =>  null,
            'distance'  =>  null
        );

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
        
        return $nearestTeams['team'];

	}

	private function findFromCity($city, $destinations)
	{

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

		$url = sprintf("%s?%s", $this->baseUrl.$this->format, http_build_query($data));

		$result = file_get_contents($url);

	    $info = json_decode($result, true);

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

?>