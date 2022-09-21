<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;
use Request;

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

    // public function create()
    // {
    // }

    // public function update(int $id)
    // {
    // }

    // public function delete(int $id)
    // {
    // }
}
