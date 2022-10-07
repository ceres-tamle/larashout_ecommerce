<?php

namespace App\Contracts;

/**
 * Interface ProductContract
 * @package App\Contracts
 */
interface ProductContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listProducts(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findProductById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createProduct(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateProduct(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteProduct($id);

    /**
     * @param $slug
     * @return mixed
     */
    public function findProductBySlug($slug);

    public function findProductByFeatured();

    public function filterProductByDescPrice();

    public function filterProductByAscPrice();

    public function findIdByProductIdAndValue($product, $key);

    public function concatenateAttributesWithId($key);

    public function concatenateAllAttributes($request, $product, $ca_val, $ma_val, $co_val, $si_val);

    public function findPriceByProductIdAndValue($product, $key);

    public function productAttributesPrice($product, $ca_val, $ma_val, $co_val, $si_val);
}
