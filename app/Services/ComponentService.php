<?php


namespace App\Services;


use App\Offer;
use Carbon\Carbon;

class ComponentService
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
    private $name;
    private $data;
    private $title = null;
    private $viewMore = true;
    private $addNew = false;
    private $route;
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

    /**
     * @param string $name
     * @return ComponentService
     */
    public function setName(string $name): ComponentService
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $data
     * @return ComponentService
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string|null $title
     * @return ComponentService
     */
    public function setTitle(?string $title): ComponentService
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param bool $viewMore
     * @return ComponentService
     */
    public function setViewMore(bool $viewMore): ComponentService
    {
        $this->viewMore = $viewMore;
        return $this;
    }

    /**
     * @param bool $addNew
     * @return ComponentService
     */
    public function setAddNew(bool $addNew): ComponentService
    {
        $this->addNew = $addNew;
        return $this;
    }


    /**
     * @param string $route
     * @return ComponentService
     */
    public function setRoute(string $route): ComponentService
    {
        $this->route = $route;
        return $this;
    }

    public function build(array $options = [])
    {
        $this->setFilters();
        return [
            'title' => $this->title,
            'name' => $this->name,
            'data' => $this->data,
            'view_more' => $this->viewMore,
            'add_new' => $this->addNew,
            'options' => $options,
            'route' => $this->route ?? config('app.url'),
            'filters' => $this->filters
        ];
    }

    /**
     * @return ComponentService
     */
    public function setFilters(): ComponentService
    {
        $filters['year'] = $this->years();
        $filters['month'] = $this->months();
        $filters['type'] = [
            '_0' => 'Privat',
            '_1' => 'Public'
        ];
        $filters['vacancies'] = $this->vacancies();
        $this->filters = $filters;
        return $this;
    }

    private function years()
    {
        $years = [];
        for ($i = Carbon::now()->year; $i >= 2009; $i--) {
            $years[$i] = $i;
        }
        return $years;
    }

    private function months()
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = self::$months[$i];
        }
        return $months;
    }

    private function vacancies()
    {
        $vacancies = Offer::pluck('vacancy')->toArray();
        $data = [];
        foreach (array_unique($vacancies) as $vacancy) {
            $data[$vacancy] = $vacancy;
        }
        return $data;
    }
}
