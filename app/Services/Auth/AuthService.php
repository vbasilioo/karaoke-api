<?php

namespace App\Services\Auth;

use App\Exceptions\ApiException;
use App\Models\Show;
use App\Models\User;

class AuthService{
    public function login(array $data){
        if (!$token = auth('api')->attempt(['email' => $data['email'], 'password' => $data['password']]))
            throw new ApiException('Não autorizado.');


        return $this->respondWithToken($token);
    }

    public function temporaryLogin(array $data): array{
        $code = Show::find($data['code_access']);

        if(!$code)
            throw new ApiException('Código de acesso inválido.');

        $user = User::create($data);

        if(!$user)
            throw new ApiException('Falha ao criar um usuário temporário.');

        return $user->toArray();
    }

    public function me(){
        return response()->json(auth()->user());
    }

    public function logout(){
        auth()->logout();
    }

    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 960,
            'admin' => auth()->user()
        ];
    }
}
