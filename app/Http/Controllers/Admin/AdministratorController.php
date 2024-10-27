<?php

namespace App\Http\Controllers\Admin;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\StoreAdministratorRequest;
use App\Services\Admin\AdministratorService;

class AdministratorController extends Controller
{
    public function __construct(protected AdministratorService $administratorService){}

    public function store(StoreAdministratorRequest $request){
        try{
            $data = $this->administratorService->store($request->validated());
            return ReturnApi::success($data, 'Administrador criado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao criar administrador.', $ex->getCode() ?? 500);
        }
    }

    public function index(){
        try{
            $data = $this->administratorService->index();
            return ReturnApi::success($data, 'Administradores listados com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao listar administradores.', $ex->getCode() ?? 500);
        }
    }
}
