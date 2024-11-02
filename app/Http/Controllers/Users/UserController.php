<?php

namespace App\Http\Controllers\Users;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\IndexUserRequest;
use App\Http\Requests\User\ShowUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Services\Users\UserService;

class UserController extends Controller
{
    public function __construct(protected UserService $userService){}

    public function store(StoreUserRequest $request){
        try{
            $data = $this->userService->store($request->validated());
            return ReturnApi::success($data, 'Usuário temporário cadastrado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao criar usuário temporário.', $ex->getCode() ?? 500);
        }
    }

    public function index(IndexUserRequest $request){
        try{
            $data = $this->userService->index($request->validated());
            return ReturnApi::success($data, 'Usuários listados com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao listar usuários temporários.', $ex->getCode() ?? 500);
        }
    }

    public function show(ShowUserRequest $request){
        try{
            $data = $this->userService->show($request->validated());
            return ReturnApi::success($data, 'Dados dos usuários listados com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao listar dados dos usuários.', $ex->getCode()?? 500);
        }
    }
}
