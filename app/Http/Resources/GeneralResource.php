<?php

namespace App\Http\Resources;

use App\Post;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class GeneralResource extends JsonResource
{
    /**
     * @var mixed|null
     */
    private $user;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->user = getAuthUser();
        return [
            'id' => $this->resource->id,
            'title' => $this->getTitle(),
            'seo_title' => $this->getSeoTitle(),
            'excerpt' => $this->getExcerpt(150),
            'external_link' => $this->getExternalLink(),
            'content' => $this->getContent(),
            'created_at' => $this->getCreatedAt(),
            'external_author' => $this->getExternalAuthor(),
            'views' => $this->getViews(),
            'privacy' => $this->getPrivacy(),
            'slug' => $this->getSlug(),
            'image' => $this->getImage(),
            'meta_description' => $this->getMetaDescription(),
            'meta_keywords' => $this->getMetaKeywords(),
            'category_id' => $this->getCategoryId(),
            'is_new' => $this->getIsNew(),
            'category_slug' => $this->getCategorySlug(),
            'state' => $this->getState(),
            'event_date' => $this->getEventDate()
        ];
    }

    private function getTitle()
    {
        return $this->resource->title ?? $this->resource->name;
    }

    private function getSeoTitle()
    {
        return $this->resource->seo_title ?? $this->getTitle();
    }

    private function getExcerpt($length): string
    {
        $body = preg_replace('/(<(script|style)\b[^>]*>).*?(<\/\2>)/is', "$1$3", $this->resource->excerpt ?: $this->getContent());
        $short = mb_substr(strip_tags($body), 0, $length);
        if (strlen(strip_tags($body)) > $length) {
            $short .= '...';
        }
        return $short;
    }

    private function getExternalLink()
    {
        return $this->resource->external_link ?? null;
    }

    private function getContent()
    {
        $body = $this->resource->body ?: "";
        if ($this->resource instanceof Post) {
            $body = $this->resource->canBeSeen($this->user) ? $body : $this->resource->getShort(200);
        }
        return find_glossary_terms($body);
    }

    private function getCreatedAt()
    {
        return $this->resource->created_at;
    }

    private function getExternalAuthor()
    {
        return $this->resource->external_author ?? null;
    }

    private function getViews()
    {
        return $this->resource->views ?? 0;
    }

    private function getSlug()
    {
        return $this->resource->slug ?? null;
    }

    private function getPrivacy(): int
    {
        return $this->resource->privacy ?? 1;
    }

    private function getImage()
    {
        return $this->resource->thumbnail_url ?? null;
    }

    private function getMetaDescription(): string
    {
        return $this->resource->meta_description ?? "";
    }

    private function getMetaKeywords(): string
    {
        return $this->resource->meta_keywords ?? "";
    }

    private function getCategoryId()
    {
        return ($this->resource->category_id ?? $this->resource->parent_id) ?? null;
    }

    protected function getIsNew(): bool
    {
        $diff = Carbon::now()->diffInDays(Carbon::parse($this->resource->created_at));

        return $diff <= 5;
    }

    private function getCategorySlug()
    {
        return ($this->resource->category->slug ?? $this->resource->slug) ?? null;
    }

    private function getState()
    {
        if (!$this->resource instanceof Post) {
            return [
                'status' => 'free',
                'meta' => []
            ];
        }

        $canBeSeen = $this->resource->canBeSeen($this->user);

        if (!$canBeSeen) {
            if ($this->resource->subscriptionServices()->exists()) {
                return [
                    'status' => 'not_free',
                    'meta' => $this->resource->getPostSubscriptionServicesJson()
                ];
            } else {
                return [
                    'status' => 'free_just_login',
                    'meta' => []
                ];
            }
        }

        return [
            'status' => 'free',
            'meta' => []
        ];
    }

    private function getEventDate()
    {
        return $this->resource->event_date ? $this->resource->event_date->format('Y-m-d') : null;
    }
}
