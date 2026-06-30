<?php

namespace App\Jobs;

use App\Enums\RawContentStatus;
use App\Models\GeneratedPost;
use App\Models\RawContent;
use App\Services\AiGenerationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class TraiterRawContentJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public function __construct(
        public readonly int $rawContentId
    ) {}

    public function handle(AiGenerationService $service): void
    {
        $rawContent = RawContent::findOrFail($this->rawContentId);

        $rawContent->update(['statut' => RawContentStatus::Processing]);

        try {
            $generatedData = $service->generate($rawContent);

            GeneratedPost::create([
                'raw_content_id' => $rawContent->id,
                'hook_propose' => $generatedData['hook_propose'],
                'body_points' => $generatedData['body_points'],
                'technical_readability_score' => $generatedData['technical_readability_score'],
                'suggested_hashtags' => $generatedData['suggested_hashtags'],
                'tone_compliance_justification' => $generatedData['tone_compliance_justification'],
                'payload_brut' => $generatedData,
                'statut' => 'draft',
            ]);

            $rawContent->update(['statut' => RawContentStatus::Completed]);
        } catch (\Throwable $e) {
            $rawContent->update(['statut' => RawContentStatus::Failed]);

            throw $e;
        }
    }

    public function backoff(): array
    {
        return [10, 30, 60];
    }

    public function failed(\Throwable $e): void
    {
        Log::error('TraiterRawContentJob failed after all retries', [
            'raw_content_id' => $this->rawContentId,
            'error' => $e->getMessage(),
        ]);
    }
}
