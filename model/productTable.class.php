<?php

class productTable
{

	public static function getProducts()
	{

		$em = dbconnection::getInstance()->getEntityManager();

		$productRepository = $em->getRepository('product');

		$products = $productRepository->findAll();

		if ($products == false)
		{

			return null;

		}

		return $products;

	}

	public static function getProductById($id)
	{

		$em = dbconnection::getInstance()->getEntityManager();

		$productRepository = $em->getRepository('product');

		$product = $productRepository->findOneBy(array(
			'id'	=>	$id
		));

		if ($product == false)
		{

			return null;

		}

		return $product;

	}

    public static function getProductsByFilters($ignoreId, $team, $sport, $type, $gender, $brand)
    {

        $em = dbconnection::getInstance()->getEntityManager();

        $rsm = new \Doctrine\ORM\Query\ResultSetMappingBuilder($em);
        $rsm->addRootEntityFromClassMetadata('product', 'p');

        $generic = 'SELECT * FROM product p WHERE p.id != :ignoreId AND';
        $sql = $generic . ' 1 = 0';
        if ($team)      $sql .= ' UNION ALL ' . $generic . ' p.id_team = :team';
        if ($sport)     $sql .= ' UNION ALL ' . $generic . ' p.id_sport = :sport';
        if ($type)      $sql .= ' UNION ALL ' . $generic . ' p.type = :type';
        if ($gender)    $sql .= ' UNION ALL ' . $generic . ' p.gender = :gender';
        if ($brand)     $sql .= ' UNION ALL ' . $generic . ' p.brand = :brand';

        $q = $em->createNativeQuery($sql, $rsm);
        $q->setParameter('ignoreId', $ignoreId);
        if ($team)      $q->setParameter('team', $team);
        if ($sport)     $q->setParameter('sport', $sport);
        if ($type)      $q->setParameter('type', $type);
        if ($gender)    $q->setParameter('gender', $gender);
        if ($brand)     $q->setParameter('brand', $brand);

        try {
            $products = $q->getResult();

            if ($products == false) {
                return array();
            }
            return $products;
        }
        catch (Exception $e) {
            echo $e;
        }

        return array();
    }

}

?>