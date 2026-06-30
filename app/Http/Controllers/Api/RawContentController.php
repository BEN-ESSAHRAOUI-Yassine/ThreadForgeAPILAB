<?php

namespace App\Http\Controllers\Api;

use App\Enums\RawContentStatus;
use App\Http\Requests\RawContentRequest;
use App\Policies\RawContentPolicy;
use App\Http\Resources\RawContentResource;
use App\Http\Controllers\Controller;
use App\Jobs\TraiterRawContentJob;
use App\Models\RawContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RawContentController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $rawContents = RawContent::where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return RawContentResource::collection($rawContents);
    }

    public function store(RawContentRequest $request): JsonResponse
    {
        $rawContent = RawContent::create(
            $request->validated() + [
                'user_id' => auth()->id(),
                'statut' => RawContentStatus::Pending,
            ]
        );

        dispatch(new TraiterRawContentJob ($rawContent->id));

        return RawContentResource::make($rawContent)
            ->response()
            ->setStatusCode(202);
    }

    public function show(RawContent $rawContent): RawContentResource
    {
        $this->authorize('view', $rawContent);

        return new RawContentResource($rawContent);
    }

    public function retry(RawContent $rawContent): JsonResponse
    {
        $this->authorize('update', $rawContent);

        abort_if($rawContent->statut !== RawContentStatus::Failed, 422, 'Only failed posts can be retried.');

        $rawContent->update(['statut' => RawContentStatus::Pending]);

        dispatch(new TraiterRawContentJob($rawContent->id));

        return RawContentResource::make($rawContent->fresh())
            ->response()
            ->setStatusCode(202);
    }
}
