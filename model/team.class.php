<?php

/** 
 * @Entity
 * @Table(name="uapv1604137.team")
 */
class team
{

	/** @Id @Column(type="integer")
	 *  @GeneratedValue
	 */
	public $id;

	/**
	* @OneToOne(targetEntity="sport")
	* @JoinColumn(name="id_sport", referencedColumnName ="id")
	*/
	public $id_sport;

	/** @Column(type="string", length=2000) */
	public $code;

	/** @Column(type="string", length=2000) */
	public $name;

	/** @Column(type="string", length=2000) */
	public $city;

	/** @Column(type="string", length=2000) */
	public $logo;

}

?>