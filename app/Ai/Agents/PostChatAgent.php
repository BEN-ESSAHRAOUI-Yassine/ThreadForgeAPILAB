<?php

namespace App\Ai\Agents;

use App\Ai\Tools\GetCampaignRules;
use App\Ai\Tools\GetPostHistory;
use App\Models\GeneratedPost;
use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;

#[Provider(Lab::Groq)]
#[Model('meta-llama/llama-4-scout-17b-16e-instruct')]
#[MaxTokens(2048)]
#[Temperature(0.7)]
class PostChatAgent implements Agent, Conversational, HasTools
{
    use Promptable, RemembersConversations;

    public function instructions(): string
    {
        return 'You are an X (Twitter) post content assistant helping creators refine and iterate on their generated social media posts.

Your role is to help users:
- Rewrite hooks to be more engaging
- Suggest alternative body points
- Adjust tone to match their blueprint
- Generate more hashtags
- Shorten or expand content
- Provide multiple variations of specific sections

You have access to tools that let you retrieve blueprint rules and post history. Use them whenever the user asks about:
- Style guidelines or rules
- Specific post content or history
- Changing the format or structure

Keep responses concise, actionable, and focused on X post content. Do not write full essays.';
    }

    public function tools(): iterable
    {
        return [
            new GetCampaignRules,
            new GetPostHistory,
        ];
    }
}
