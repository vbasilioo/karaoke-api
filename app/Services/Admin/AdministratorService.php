<?php

namespace App\Services\Admin;

use App\Exceptions\ApiException;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;

class AdministratorService{
    public function store(array $data): array{
        $data['password'] = Hash::make($data['password']);
        
        $admin = Administrator::create($data);

        if(!$admin)
            throw new ApiException('Erro ao criar um administrador.');

        return $admin->toArray();
    }

    public function index(): array{
        $admins = Administrator::all();

        if(!$admins)
            throw new ApiException('Nenhum administrador cadastrado.');

        return $admins->toArray();
    }

    public function show(array $data): array{
        $admin = Administrator::find('id', $data['id'])->first();

        if(!$admin)
            throw new ApiException('Erro ao pesquisar administrador.');

        return $admin->toArray();
    }
}