<?php

use App\Builder\ReturnApi;
use App\Http\Middleware\JWTMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api/index.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('auth.api', [JWTMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (NotFoundHttpException $ex) {
            return ReturnApi::error('Rota não encontrada.', $ex->getMessage());
        });
        $exceptions->renderable(function (ValidationException $ex, $request) {
            return ReturnApi::error($ex->validator->errors()->first(), $ex->validator->errors()->toArray());
        });
        $exceptions->renderable(function (MethodNotAllowedException $ex) {
            return ReturnApi::error('Método não permitido.' . $ex->getMessage());
        });
        $exceptions->renderable(function (BadMethodCallException $ex) {
            return ReturnApi::error('Método não permitido.' . $ex->getMessage());
        });
        $exceptions->renderable(function (AccessDeniedHttpException $ex) {
            return ReturnApi::error('Acesso negado.', $ex->getMessage(), $ex->getStatusCode());
        });
        $exceptions->render(function (Throwable $ex) {
            return ReturnApi::error('Erro inesperado na API.', $ex->getMessage());
        });
    })->create();
