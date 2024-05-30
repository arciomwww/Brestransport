<?php

namespace App\Http\Controllers\API;

use App\Actions\API\DeleteUserAction;
use App\Contracts\Actions\ExportActionContract;
use App\Contracts\Actions\ImportActionContract;
use App\Contracts\Actions\ShowUserActionContract;
use App\Contracts\Actions\StoreUserActionContract;
use App\Contracts\Repositories\BusStopRepositoryContract;
use App\Contracts\Services\ExcelServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\ImportRequest;
use App\Http\Requests\API\User\ShowRequest;
use App\Http\Requests\API\User\StoreRequest;
use App\Http\Resources\API\BusStop\IndexResource;
use Illuminate\Http\JsonResponse;

class BusStopController extends Controller
{
    public function index(BusStopRepositoryContract $repository): JsonResponse
    {
        $busStops = $repository->all();
        $busStops = IndexResource::collection($busStops);
        return response()->json($busStops);
    }
}
