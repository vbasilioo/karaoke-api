<?php

namespace App\Http\Controllers\Music;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Music\GetDetailsChannelMusicRequest;
use App\Http\Requests\Music\GetDetailsMusicRequest;
use App\Http\Requests\Music\SearchMusicRequest;
use App\Http\Requests\Music\StoreMusicRequest;
use App\Services\Music\MusicService;

class MusicController extends Controller
{
    public function __construct(protected MusicService $musicService){}

    public function store(StoreMusicRequest $request){
        try{
            $data = $this->musicService->store($request->validated());
            return ReturnApi::success($data, 'Música adicionada a fila com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao adicionar música a fila.', $ex->getCode() ?? 500);
        }
    }

    public function index(){
        try{
            $data = $this->musicService->index();
            return ReturnApi::success($data, 'Músicas listadas com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao listar músicas da fila'. $ex->getCode() ?? 500);
        }
    }

    public function search(SearchMusicRequest $request){
        try{
            $data = $this->musicService->search($request->validated());
            return ReturnApi::success($data, 'Música pesquisada com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao pesquisar música.', $ex->getCode() ?? 500);
        }
    }

    public function getDetails(GetDetailsMusicRequest $request){
        try{
            $data = $this->musicService->getDetails($request->validated());
            return ReturnApi::success($data, 'Detalhes da música listados com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao pesquisar detalhes da música.', $ex->getCode() ?? 500);
        }
    }

    public function getDetailsChannel(GetDetailsChannelMusicRequest $request){
        try{
            $data = $this->musicService->getDetailsChannel($request->validated());
            return ReturnApi::success($data, 'Detalhes do canal listados com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao pesquisar detalhes do canal.', $ex->getCode() ?? 500);
        }
    }

    public function nextMusic(){
        try{
            $data = $this->musicService->nextMusic();
            return ReturnApi::success($data, 'Próxima música listada com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao buscar próxima música.', $ex->getCode()?? 500);
        }
    }

    public function adjustMusicQueue(){
        try{
            $data = $this->musicService->adjustMusicQueue();
            return ReturnApi::success($data, 'Ajuste feito com sucesso na fila.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao ajustar a fila.', $ex->getCode() ?? 500);
        }
    }
}
