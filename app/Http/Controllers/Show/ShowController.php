<?php

namespace App\Http\Controllers\Show;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Show\CodeAccessShowRequest;
use App\Http\Requests\Show\IndexShowRequest;
use App\Http\Requests\Show\StoreShowRequest;
use App\Services\Show\ShowService;

class ShowController extends Controller
{
    public function __construct(protected ShowService $showService){}

    public function store(StoreShowRequest $request){
        try{
            $data = $this->showService->store($request->validated());
            return ReturnApi::success($data, 'Show criado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao criar show.', $ex->getCode() ?? 500);
        }
    }

    public function index(IndexShowRequest $request){
        try{
            $data = $this->showService->index($request->validated());
            return ReturnApi::success($data, 'Shows listados com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao listar shows.', $ex->getCode() ?? 500);
        }
    }

    public function show(CodeAccessShowRequest $request){
        try{
            $data = $this->showService->show($request->validated());
            return ReturnApi::success($data, 'Show mostrado com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao mostrar show.', $ex->getCode()?? 500);
        }
    }
}
