<?php

/** 
 * @Entity
 * @Table(name="uapv1604137.ticket")
 */
class ticket
{

	/** @Id @Column(type="integer")
	 *  @GeneratedValue
	 */
	public $id;

	/**
	* @OneToOne(targetEntity="match")
	* @JoinColumn(name="id_match", referencedColumnName ="id")
	*/
	public $id_match;

	/** @Column(type="float") */
	public $price;

	/** @Column(type="integer") */
	public $stock;

}

?>