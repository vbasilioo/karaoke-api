<?php

namespace App\Services\Show;

use App\Exceptions\ApiException;
use App\Models\Show;
use Faker\Core\Number;

class ShowService{
    public function store(array $data): array{
        $data['code_access'] = rand(1, 10000);

        $show = Show::create($data);

        if(!$show)
            throw new ApiException('Erro ao criar um show.');

        return $show->toArray();
    }

    public function index(): array{
        $show = Show::all();

        if(!$show)
            throw new ApiException('Nenhum show cadastrado.');

        return $show->toArray();
    }

    public function show(array $data): array{
        $show = Show::where('code_access', $data['code_access'])->first();

        if(!$show)
            throw new ApiException('Show não encontrado.');

        return $show->toArray();
    }
}
