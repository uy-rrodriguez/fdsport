<?php

/** 
 * @Entity
 * @Table(name="uapv1604137.profiling")
 */
class profiling
{

    /** @Id @Column(type="integer")
	 *  @GeneratedValue
	 */
    public $id;
    
    /**
	* @OneToOne(targetEntity="product")
	* @JoinColumn(name="id_product", referencedColumnName ="id")
	*/
    public $id_product;
    
    /** @Column(type="string", length=2000) */
    public $profil;

}

?>