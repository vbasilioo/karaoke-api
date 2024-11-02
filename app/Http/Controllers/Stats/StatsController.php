<?php

namespace App\Http\Controllers\Stats;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Stats\IndexStatsRequest;
use App\Services\Stats\StatsService;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function __construct(protected StatsService $statsService){}

    public function index(IndexStatsRequest $request){
        try{
            $data = $this->statsService->index($request->validated());
            return ReturnApi::success($data, 'Estatísticas recuperadas com sucesso.');
        }catch(ApiException $ex){
            throw new ApiException($ex->getMessage() ?? 'Erro ao recuperar estatísticas.', $ex->getCode() ?? 500);
        }
    }
}
