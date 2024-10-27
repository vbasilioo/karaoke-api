<?php

namespace App\Http\Controllers\Auth;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LoginTemporaryRequest;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService){}

    public function login(LoginRequest $request){
        try{
            $data = $this->authService->login($request->validated());
            return ReturnApi::success($data, 'Login realizado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao realizar autenticação.', $ex->getCode() ?? 500);
        }
    }

    public function temporaryLogin(LoginTemporaryRequest $request){
        try{
            $data = $this->authService->temporaryLogin($request->validated());
            return ReturnApi::success($data, 'Login temporário realizado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao realizar autenticação temporária.', $ex->getCode() ?? 500);
        }
    }

    public function me(){
        try{
            $data = $this->authService->me();
            return ReturnApi::success($data, 'Dados pessoais listados com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao listar dados pessoais.', $ex->getCode() ?? 500);
        }
    }

    public function logout(){
        try{
            $data = $this->authService->logout();
            return ReturnApi::success($data, 'Logout realizado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao realizar logout.', $ex->getCode() ?? 500);
        }
    }

    public function refresh(){
        try{
            $data = $this->authService->refresh();
            return ReturnApi::success($data, 'Refresh realizado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao realizar refresh', $ex->getCode() ?? 500);
        }
    }
}
