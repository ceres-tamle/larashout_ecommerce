<?php

namespace App\Repositories;

use App\Models\Product;
use App\Traits\UploadAble;
use App\Contracts\ProductContract;
use App\Models\ProductAttribute;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductRepository
 *
 * @package \App\Repositories
 */
class ProductRepository extends BaseRepository implements ProductContract
{
    use UploadAble;

    /**
     * ProductRepository constructor.
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listProducts(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findProductById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Product|mixed
     */
    public function createProduct(array $params)
    {
        try {
            $collection = collect($params);

            $featured = $collection->has('featured') ? 1 : 0;
            $status = $collection->has('status') ? 1 : 0;

            $merge = $collection->merge(compact('status', 'featured'));

            $product = new Product($merge->all());

            $product->save();

            if ($collection->has('categories')) {
                $product->categories()->sync($params['categories']);
            }
            return $product;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateProduct(array $params)
    {
        $product = $this->findProductById($params['product_id']);

        $collection = collect($params)->except('_token');

        $featured = $collection->has('featured') ? 1 : 0;
        $status = $collection->has('status') ? 1 : 0;

        $merge = $collection->merge(compact('status', 'featured'));

        $product->update($merge->all());

        if ($collection->has('categories')) {
            $product->categories()->sync($params['categories']);
        }

        return $product;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteProduct($id)
    {
        $product = $this->findProductById($id);

        $product->delete();

        return $product;
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function findProductBySlug($slug)
    {
        $product = Product::where('slug', $slug)->first();

        return $product;
    }

    public function findProductByFeatured()
    {
        $featured = Product::where('featured', 1)->get();

        return $featured;
    }

    public function filterProductByDescPrice()
    {
        $descPrice = DB::table('products')->orderBy('price', 'desc')->get();
        return $descPrice;
    }

    public function filterProductByAscPrice()
    {
        $ascPrice = DB::table('products')->orderBy('price', 'asc')->get();
        return $ascPrice;
    }

    public function findIdByProductIdAndValue($product, $key)
    {
        $value = ProductAttribute::select('id')
            ->where('product_id', $product->id)
            ->where('value', $key)->first();

        return $value;
    }

    public function concatenateAttributesWithId($key)
    {
        if (isset($key->id)) {
            $value = $key->id;
        } else {
            $value = '00';
        }

        return $value;
    }

    public function concatenateAllAttributes($request, $product, $ca_val, $ma_val, $co_val, $si_val)
    {
        // find id by product id and attributes value in product attributes table
        $capacity_id = $this->findIdByProductIdAndValue($product, $ca_val);
        $materials_id = $this->findIdByProductIdAndValue($product, $ma_val);
        $color_id = $this->findIdByProductIdAndValue($product, $co_val);
        $size_id = $this->findIdByProductIdAndValue($product, $si_val);

        // concatenate attributes with id
        $capacity_idd = $this->concatenateAttributesWithId($capacity_id);
        $materials_idd = $this->concatenateAttributesWithId($materials_id);
        $color_idd = $this->concatenateAttributesWithId($color_id);
        $size_idd = $this->concatenateAttributesWithId($size_id);

        // concatenate all attributes
        if (isset($capacity_idd) || isset($materials_idd) || isset($color_idd) || isset($size_idd)) {
            $product_id = $product->id
                . ('-ca' . $capacity_idd)
                . ('-ma' . $materials_idd)
                . ('-co' . $color_idd)
                . ('-si' . $size_idd);
        } else {
            $product_id = $product->id . '-no';
        }

        return $product_id;
    }

    public function findPriceByProductIdAndValue($product, $key)
    {
        $value = ProductAttribute::select('price')
            ->where('product_id', $product->id)
            ->where('value', $key)->first();

        return $value;
    }

    public function productAttributesPrice($product, $ca_val, $ma_val, $co_val, $si_val)
    {
        $capacity_price = $this->findPriceByProductIdAndValue($product, $ca_val);
        $materials_price = $this->findPriceByProductIdAndValue($product, $ma_val);
        $color_price = $this->findPriceByProductIdAndValue($product, $co_val);
        $size_price = $this->findPriceByProductIdAndValue($product, $si_val);

        if ($ca_val !== null || $ma_val !== null || $co_val !== null || $si_val !== null) { // if product has variant

            if ($product->sale_price !== null) { // if product has sale_price
                $total_unit_price = $product->sale_price
                    + ($capacity_price ? $capacity_price->price : 0)
                    + ($materials_price ? $materials_price->price : 0)
                    + ($color_price ? $color_price->price : 0)
                    + ($size_price ? $size_price->price : 0);
            } else { // if product has no sale_price
                $total_unit_price = $product->price
                    + ($capacity_price ? $capacity_price->price : 0)
                    + ($materials_price ? $materials_price->price : 0)
                    + ($color_price ? $color_price->price : 0)
                    + ($size_price ? $size_price->price : 0);
            }
        } elseif ($ca_val === null && $ma_val === null && $co_val === null && $si_val === null) { // if product has no variant
            $total_unit_price = $product->sale_price != '' ? $product->sale_price : $product->price;
        }

        return $total_unit_price;
    }
}
