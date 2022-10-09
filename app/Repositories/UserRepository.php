<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductRepository
 *
 * @package \App\Repositories
 */
class UserRepository extends BaseRepository implements UserContract
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function retrieve()
    {
        $users = DB::table('users')->get();

        return $users;
    }

    public function findById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
}
