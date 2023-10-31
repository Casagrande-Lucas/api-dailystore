<?php

namespace App\Repository;

use App\Models\User;
use Carbon\Carbon;
use Throwable;

class UserRepository extends User
{
    protected $table = 'users';
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Create User with attributes.
     *
     * @throws Throwable
     */
    public function create(): void
    {
        $this->attributes['created_at'] = Carbon::now()->format('Y-m-d H:i');
        $this->attributes['updated_at'] = Carbon::now()->format('Y-m-d H:i');
        $this->saveOrFail();
    }
}
