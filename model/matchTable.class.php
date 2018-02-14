<?php

class matchTable
{

	public static function getMatches()
	{

		$em = dbconnection::getInstance()->getEntityManager();

		$matchRepository = $em->getRepository('match');

		$matches = $matchRepository->findAll();

		if ($matches == false)
		{

			return null;

		}

		return $matches;

	}

	public static function getMatchById($id)
	{

		$em = dbconnection::getInstance()->getEntityManager();

		$matchRepository = $em->getRepository('match');

		$match = $matchRepository->findOneBy(array(
			'id'	=>	$id
		));

		if ($match == false;)
		{

			return null;

		}

		return $match;

	}

}

?>