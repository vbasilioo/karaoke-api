<?php

namespace App\Services\Users;

use App\Exceptions\ApiException;
use App\Models\Show;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{

    public function store(array $data, $photo = null): array
    {
        $show = Show::where('code_access', $data['code_access'])->first();

        if (!$show)
            throw new ApiException('Código de acesso inválido.');

        $data['show_id'] = $show->id;
        $data['admin_id'] = $show->admin_id;

        if ($photo) {
            $path = $photo->store('users', 'public');
            $data['photo'] = $path;
        } elseif (isset($data['avatarUrl'])) {
            $data['photo'] = str_replace(url('/'), '', $data['avatarUrl']);
        }

        if (isset($data['avatarUrl'])) {
            unset($data['avatarUrl']);
        }

        if (isset($data['code_access'])) {
            unset($data['code_access']);
        }

        $user = User::create($data);

        if (!$user)
            throw new ApiException('Erro ao cadastrar usuário temporário.');

        return $user->toArray();
    }

    public function index(array $data): object
    {
        $adminId = $data['admin_id'];

        return User::with('show')
            ->whereHas('show', function ($query) use ($adminId) {
                $query->where('admin_id', $adminId);
            })
            ->withTrashed()
            ->paginate($data['per_page'], ['*'], 'page', $data['page']);
    }

    public function show(array $data): array
    {
        $user = User::where('show_id', $data['show_id'])->get();

        if (!$user)
            throw new ApiException('Nenhum usuário vinculado a este show.');

        return $user->toArray();
    }

    public function me(array $data): array
    {
        return User::query()
            ->join('shows', 'users.show_id', 'shows.id')
            ->select('users.*', 'shows.id AS show_id')
            ->where('users.id', $data['id'])
            ->get()
            ->toArray();
    }
}
