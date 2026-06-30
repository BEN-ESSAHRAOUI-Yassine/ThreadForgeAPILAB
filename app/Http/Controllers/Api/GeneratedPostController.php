<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdateGeneratedPostStatusRequest;
use App\Policies\GeneratedPostPolicy;
use App\Http\Resources\GeneratedPostResource;
use App\Http\Controllers\Controller;
use App\Models\GeneratedPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GeneratedPostController extends Controller
{
    
    public function index(): AnonymousResourceCollection
    {
        $generatedPosts = GeneratedPost::whereHas('rawContent', function ($query) {
            $query->where('user_id', auth()->id());
        })
            ->latest()
            ->paginate(15);

        return GeneratedPostResource::collection($generatedPosts);
    }

    public function show(GeneratedPost $generatedPost): GeneratedPostResource
    {
        $this->authorize('view', $generatedPost);

        return new GeneratedPostResource($generatedPost);
    }

    public function update(UpdateGeneratedPostStatusRequest $request, GeneratedPost $generatedPost): JsonResponse
    {
        $this->authorize('update', $generatedPost);

        $newStatus = $request->validated()['statut'];

        $data = ['statut' => $newStatus];

        if ($newStatus === 'posted') {
            $data['posted_at'] = now();
        } elseif ($generatedPost->statut?->value === 'posted' && $newStatus !== 'posted') {
            $data['posted_at'] = null;
        }

        $generatedPost->update($data);

        return response()->json([
            'data' => new GeneratedPostResource($generatedPost->fresh()),
        ]);
    }
}
