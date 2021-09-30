<?php

namespace App\Services\Pages;

use Carbon\Carbon;

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
    abstract public function getPage();
    /**
     * @return AbstractPage
     */
    public function setFilters(): AbstractPage
    {
        $filters['year'] = $this->years();
        $filters['month'] = $this->months();
        $filters['type'] = [
            '_0' => 'Privat',
            '_1' => 'Public'
        ];

        $this->filters = $filters;
        return $this;
    }

    private function years(): array
    {
        $years = [];
        for ($i = Carbon::now()->year; $i >= 2009; $i--) {
            $years[$i] = $i;
        }
        return $years;
    }

    private function months(): array
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = self::$months[$i];
        }
        return $months;
    }

    public function getSection(string $name, string $type, $items = [], array $config = []): array
    {
        $this->setFilters();
        return [
            'name' => $name,
            'type' => $type,
            'data' => $items,
            'filters' => $this->filters,
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
}