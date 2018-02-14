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

}

?>