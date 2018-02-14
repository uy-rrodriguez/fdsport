<?php

class ticketTable
{

	public static function getTickets()
	{

		$em = dbconnection::getInstance()->getEntityManager();

		$ticketRepository = $em->getRepository('ticket');

		$tickets = $ticketRepository->findAll();

		if ($tickets == false)
		{

			return null;

		}

		return $tickets;

	}

	public static function getTicketById($id)
	{

		$em = dbconnection::getInstance()->getEntityManager();

		$ticketRepository = $em->getRepository('ticket');

		$ticket = $ticketRepository->findOneBy(array(
			'id'	=>	$id
		));

		if ($ticket == false)
		{

			return null;

		}

		return $ticket;

	}

}

?>