<?php

/** 
 * @Entity
 * @Table(name="uapv1604137.match")
 */
class match
{

	/** @Id @Column(type="integer")
	 *  @GeneratedValue
	 */
	public $id;

	/**
	* @OneToOne(targetEntity="team")
	* @JoinColumn(name="id_team_home", referencedColumnName ="id")
	*/
	public $id_team_home;

	/**
	* @OneToOne(targetEntity="team")
	* @JoinColumn(name="id_team_visitor", referencedColumnName ="id")
	*/
	public $id_team_visitor;

	/** @Column(type="string", length=2000) */
	public $date;

}

?>