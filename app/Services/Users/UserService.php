<?php

namespace App\Services\Users;

use App\Exceptions\ApiException;
use App\Models\Show;
use App\Models\User;

class UserService{
    public function store(array $data): array{
        $show = Show::where('code_access', $data['code_access'])->first();

        if(!$show)
            throw new ApiException('Código de acesso inválido.');

        $data['show_id'] = $show->id;
        $user = User::create($data);

        if(!$user)
            throw new ApiException('Erro ao cadastrar usuário temporário.');

        return $user->toArray();
    }

    public function index(array $data): object{
        return User::with('show')->paginate($data['per_page'], ['*'], 'page', $data['page']);
    }

    public function show(array $data): array{
        $user = User::where('show_id', $data['show_id'])->get();

        if(!$user)
            throw new ApiException('Nenhum usuário vinculado a este show.');

        return $user->toArray();
    }
}
