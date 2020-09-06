<?php

namespace App\Widgets;

use App\Page;
use Illuminate\Support\Str;
use TCG\Voyager\Widgets\BaseDimmer;

class PageWidget extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Page::query()->count();
        $string = trans_choice('voyager::dimmer.page', $count);

        return view('widgets.page_widget', array_merge($this->config, [
            'icon' => 'voyager-news',
            'title' => "{$count} {$string}",
            'text' => __('voyager::dimmer.page_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => __('voyager::dimmer.page_link_text'),
                'link' => route('voyager.pages.index'),
            ],
            'image' => voyager_asset('images/widget-backgrounds/03.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return true;
    }
}
