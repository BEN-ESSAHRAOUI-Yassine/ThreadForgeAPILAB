<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlueprintRequest;
use App\Http\Resources\BlueprintResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blueprint;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlueprintController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $blueprints = Blueprint::where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return BlueprintResource::collection($blueprints);
    }

    public function store(BlueprintRequest $request): JsonResponse
    {
        $blueprint = Blueprint::create(
            $request->validated() + ['user_id' => auth()->id()]
        );

        return BlueprintResource::make($blueprint)
            ->response()
            ->setStatusCode(201);
    }

    public function show(Blueprint $blueprint): BlueprintResource
    {
        $this->authorize('view', $blueprint);

        return new BlueprintResource($blueprint);
    }

    public function update(BlueprintRequest $request, Blueprint $blueprint): BlueprintResource
    {
        $this->authorize('update', $blueprint);

        $blueprint->update($request->validated());

        return new BlueprintResource($blueprint);
    }

    public function destroy(Blueprint $blueprint): JsonResponse
    {
        $this->authorize('delete', $blueprint);

        $blueprint->delete();

        return response()->json(null, 204);
    }
}
