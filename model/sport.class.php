<?php

/** 
 * @Entity
 * @Table(name="uapv1604137.sport")
 */
class sport
{

	/** @Id @Column(type="integer")
	 *  @GeneratedValue
	 */
	public $id;

	/** @Column(type="string", length=2000) */
	public $name;

}

?>