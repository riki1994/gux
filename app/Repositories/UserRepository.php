<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function find(int $id): User
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data): User
    {
        $user = $this->model->find($id);
        $user->update($data);

        return $user;
    }

    public function delete(int $id): void
    {
        $this->model->destroy($id);
    }

    public function all(): array
    {
        return Cache::remember(
            'users',
            now()->addMinutes(5),
            function () {
                return DB::table('users')->get()->toArray();
            }
        );
    }
}
