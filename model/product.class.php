<?php

/** 
 * @Entity
 * @Table(name="uapv1604137.product")
 */
class product
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

	/**
	* @OneToOne(targetEntity="team")
	* @JoinColumn(name="id_team", referencedColumnName ="id")
	*/
	public $id_team;

	/** @Column(type="string", length=2000) */
	public $name;

	/** @Column(type="string", length=2000) */
	public $description;

	/** @Column(type="string", length=2000) */
	public $gender;

	/** @Column(type="string", length=2000) */
	public $size;

	/** @Column(type="float") */
	public $price;

	/** @Column(type="integer") */
	public $promotion;

	/** @Column(type="string", length=2000) */
	public $type;

	/** @Column(type="string", length=2000) */
	public $brand;

	/** @Column(type="integer") */
	public $stock;

	/** @Column(type="string", length=2000) */
	public $image;

}

?>