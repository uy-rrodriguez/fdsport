<?php

class teamTable
{

	public static function getTeams()
	{

		$em = dbconnection::getInstance()->getEntityManager();

		$teamRepository = $em->getRepository('team');

		$teams = $teamRepository->findAll();

		if ($teams == false)
		{

			return null;

		}

		return $teams;

	}

	public static function getTeamById($id)
	{

		$em = dbconnection::getInstance()->getEntityManager();

		$teamRepository = $em->getRepository('team');

		$team = $teamRepository->findOneBy(array(
			'id'	=>	$id
		));

		if ($team == false)
		{

			return null;

		}

		return $team;

	}

}

?>