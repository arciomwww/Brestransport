<?php

namespace App\Http\Controllers\API;

use App\Actions\API\DeleteUserAction;
use App\Contracts\Actions\DeleteAllUserActionContract;
use App\Contracts\Actions\ExportActionContract;
use App\Contracts\Actions\ImportActionContract;
use App\Contracts\Actions\ShowUserActionContract;
use App\Contracts\Actions\StoreUserActionContract;
use App\Contracts\Services\ExcelServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\ImportRequest;
use App\Http\Requests\API\User\ShowRequest;
use App\Http\Requests\API\User\StoreRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function store(StoreRequest $request, StoreUserActionContract $action): JsonResponse
    {
        $data = $request->validated();
        $action = $action($data);
        return response()
            ->json($action['response'], $action['status']);
    }

    public function import(ImportRequest $request, ImportActionContract $action): JsonResponse
    {
        $data = $request->validated();
        $action = $action($data);
        return response()
            ->json($action['response'], $action['status']);
    }

    public function export(ExportActionContract $action): \Illuminate\Foundation\Application|
    \Illuminate\Http\Response|
    \Illuminate\Contracts\Foundation\Application|
    \Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $action();
        return response(...$response);
    }

    public function show(ShowRequest $request, ShowUserActionContract $action): JsonResponse
    {
        $data = $request->validated();
        $action = $action($data);
        return response()
            ->json($action['response'], $action['status']);
    }

    public function destroy(int $id, DeleteUserAction $action): JsonResponse
    {
        $action = $action($id);
        return response()
            ->json($action['response'], $action['status']);
    }

    public function destroyAll(DeleteAllUserActionContract $action): JsonResponse
    {
        $action = $action();
        return response()
            ->json($action['response'], $action['status']);
    }
}
