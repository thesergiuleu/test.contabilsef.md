<?php

namespace App\Services\Pages;

use App\Category;
use App\Http\Resources\GeneralCollection;
use App\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

abstract class AbstractPage
{
    private static $months = [
        1 => 'Jan.',
        2 => 'Feb.',
        3 => 'Mar.',
        4 => 'Apr.',
        5 => 'Mai',
        6 => 'Iun.',
        7 => 'Iul.',
        8 => 'Aug.',
        9 => 'Sep.',
        10 => 'Oct.',
        11 => 'Noi.',
        12 => 'Dec.',
    ];
    private $filters = [
        'year' => [
            2009 => 2009
        ],
        'month' => [
            1 => 'Jan.'
        ],
        'type' => [
            '_0' => 'Public'
        ],
        'categories' => [
            '#' => '#'
        ]
    ];
    private $meta;

    abstract public function getPage();
    /**
     * @return AbstractPage
     */
    public function setFilters(): AbstractPage
    {
        $filters['year'] = $this->years();
        $filters['month'] = $this->months();
        $filters['type'] = [
            [
                'key' => '_0',
                'value' => 'Privat'
            ],
            [
                'key' => '_1',
                'value' => 'Public'
            ]
        ];

        $this->filters = $filters;
        return $this;
    }

    private function years(): array
    {
        $years = [];
        for ($i = Carbon::now()->year; $i >= 2009; $i--) {
            $years[] = [
                'key' => $i,
                'value' => $i
            ];
        }
        return $years;
    }

    private function months(): array
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = [
                'key' => $i,
                'value' => self::$months[$i]
            ];
        }
        return $months;
    }

    public function getSection(string $name, string $type, $items = [], array $config = [], $meta = []): array
    {
        $this->setFilters();
        return [
            'name' => $name,
            'type' => $type,
            'data' => $items,
            'filters' => $this->filters,
            'meta' => $meta,
            'config' => array_merge([
                'is_name_displayed' => false,
                'grid' => false,
                'with_header' => false,
                'with_images' => false,
                'with_date' => false,
                'with_external_author' => false,
                'with_views' => false,
                'with_comments_count' => false,
                'with_privacy' => false,
                'with_category' => false,
                'with_excerpt' => false,
                'with_see_more' => false,
                'with_filters' => false,
            ], $config)
        ];
    }

    /**
     * @param $category
     * @return LengthAwarePaginator
     */
    protected function getPosts($category): LengthAwarePaginator
    {
        if ($category) {
            /** @var Category $category */
            return $category->posts()->union($category->subPosts())->orderBy('created_at', 'desc')->paginate(15);
        }

        return new LengthAwarePaginator([], 0, 15);
    }

    protected function getGeneralListLayout($category): array
    {
        /** @var Category $parent */
        $parent = Category::with(['posts', 'subPosts'])->where('slug', $category)->first();
        $articleCategories =  $parent ? new GeneralCollection(Category::whereParentId($parent->id)->get()) : [];
        $posts = new GeneralCollection($this->getPosts($parent));

        $meta['paginator'] = buildPaginatorMeta($this->getPosts($parent));

        return [
            'sidebar' => [
                'sections' => [
                    $this->getSection($parent->name ?? 'Categorii', 'categories', $articleCategories, [
                        'is_name_displayed' => true,
                    ]),
                    $this->getSection('Calendar', 'calendar', $this->getCalendarData()),
                ]
            ],
            'main' => [
                'sections' => [
                    $this->getSection($parent->name ?? "Postări", 'posts', $posts, [
                        'is_name_displayed' => true,
                        'with_filters' => true,
                        'with_images' => true,
                        'with_header' => true,
                        'with_privacy' => true,
                        'with_date' => true,
                    ],$meta)
                ]
            ]
        ];
    }

    protected function getCalendarData(): GeneralCollection
    {
        if (Cache::has('seminare')) {
            return json_decode(Cache::get('seminare'));
        }
        return new GeneralCollection(Post::instruire()->limit(5)->get());
    }
}
