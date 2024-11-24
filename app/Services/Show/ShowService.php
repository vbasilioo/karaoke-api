<?php

namespace App\Services\Show;

use App\Exceptions\ApiException;
use App\Models\Show;

class ShowService{
    public function store(array $data): array{
        $data['code_access'] = rand(1, 10000);

        $show = Show::create($data);

        if(!$show)
            throw new ApiException('Erro ao criar um show.');

        return $show->toArray();
    }

    public function index(array $data): array{
        $show = Show::where('admin_id', $data['admin_id'])->withTrashed()->get();

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

    public function update(array $data): array{
        Show::where('id', $data['id'])->update($data);
        return Show::find($data['id']);
    }

    public function destroy(array $data): array{
        $show = Show::find($data['id']);

        if($show)
            $show->delete();
        
        return Show::onlyTrashed()->find($data['id'])->toArray();
    }
    
    public function restore(array $data): array{
        $show = Show::withTrashed()->find($data['id']);

        if($show)
            $show->restore();
        
        return Show::find($data['id'])->toArray();
    }

}
