<?php

namespace App\Contracts;

use Request;

interface UserContract
{
    public function retrieve();

    public function findById(int $id);

    // public function create();

    // public function update(int $id);

    // public function delete(int $id);
}
