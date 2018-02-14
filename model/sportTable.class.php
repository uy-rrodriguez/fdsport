<?php

class sportTable
{

	public static function getSports()
	{

		$em = dbconnection::getInstance()->getEntityManager();

		$sportRepository = $em->getRepository('sport');

		$sports = $sportRepository->findAll();

		if ($sports == false)
		{

			return null;

		}

		return $sports;

	}

	public static function getSportById($id)
	{

		$em = dbconnection::getInstance()->getEntityManager();

		$sportRepository = $em->getRepository('sport');

		$sport = $sportRepository->findOneBy(array(
			'id'	=>	$id
		));

		if ($sport == false)
		{

			return null;

		}

		return $sport;

	}

}

?>