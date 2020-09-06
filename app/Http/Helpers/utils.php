<?php

use App\Post;
use Carbon\Carbon;

function sidebarCalendar()
{
    #todo de razberit ce se intimpla aici, vrode lucreaza )
    $posts = Post::published()->get();
//    data_seminar
    $postArray = [];
    foreach ($posts as $key => $post) {
        $dateArray = $post->event_date;
        $date = $post->event_date;
        if ($date) $dateArray = date('Y-m-d', strtotime($date));

        $postArray[$dateArray][$post->id]['title'] = $post->title;
        $postArray[$dateArray][$post->id]['url'] = $post->post_url;
    }

    $html = "<script>  var dates = [];";


    if (isset($postArray)) {
        foreach ($postArray as $date => $events) {
            $html .= "dates['" . $date . "'] = \"";
            foreach ($events as $event) {
                $html .= "<li><a href='" . $event['url'] . "'>" . $event['title'] . "</a></li>";
            }
            $html .= "\";";
        }
        $html .= 'var eventData =[';
        foreach ($postArray as $date => $events) {
            foreach ($events as $event) {
                $html .= "{
                    \"date\": \"$date\",
                    \"badge\": true,
                    \"title\": \"" . $event["title"] . "\",
                    \"classname\": \"purple-event\"
                },";
            }
        }
        $html .= '];';
    }


    $html .= "console.log(dates);</script>";
    $html .= "<div id='my-calendar-2'></div>";
    return $html;
}

function format_date($date, $format = 'd.m.Y')
{
    return Carbon::parse($date)->format($format);
}

function apply_discount($amount)
{
    $discount = setting('prices.discount', 0);

    if ($discount == 0) return $amount;

    return ($amount * $discount) / 100;
}

function replace_price($string, $model)
{
    preg_match_all('/({{.*?}})/', $string, $matches);
    $res = preg_replace("/[^a-zA-Z]/", "", $matches[0]);

    if (!empty($res)) {
        foreach ($res as $re) {
            if ($re == 'price') {
                return preg_replace("/({{{$re}}})/", apply_discount($model->$re), $string);
            }
            return preg_replace("/({{{$re}}})/", $model->$re, $string);
        }
    }

    return $string;
}

function find_glossary_terms($string)
{
    $keywords = \App\Glosary::query()->get();

    $allDefinition = [];

    if ($keywords->isNotEmpty()) {
        foreach ($keywords as $item) {
            $allDefinition[$item->keyword.'.'] = "<span style='position:relative;color: #3c5a98; text-decoration: underline;'     data-toggle-tooltip2    data-title='".strip_tags($item->description)."'>".$item->keyword."</span>.";

            $allDefinition[' '.$item->keyword.' '] = " <span style='position:relative;color: #3c5a98; text-decoration: underline;'     data-toggle-tooltip2    data-title='".strip_tags($item->description)."'>".$item->keyword."</span> ";

            $allDefinition['. '.$item->keyword] = ". <span style='position:relative;color: #3c5a98; text-decoration: underline;'     data-toggle-tooltip2    data-title='".strip_tags($item->description)."'>".$item->keyword."</span>";

            $allDefinition[mb_strtolower($item->keyword).'. '] = "<span style='position:relative;color: #3c5a98; text-decoration: underline;'     data-toggle-tooltip2    data-title='".strip_tags($item->description)."'>".mb_strtolower($item->keyword)."</span>.";

            $allDefinition[' '.mb_strtolower($item->keyword).' '] = " <span style='position:relative;color: #3c5a98; text-decoration: underline;'     data-toggle-tooltip2    data-title='".strip_tags($item->description)."'>".mb_strtolower($item->keyword)."</span> ";

            $allDefinition['. '.mb_strtolower($item->keyword)] = "<span style='position:relative;color: #3c5a98; text-decoration: underline;'     data-toggle-tooltip2    data-title='".strip_tags($item->description)."'>".mb_strtolower($item->keyword)."</span>.";
        }
    }
    $content = (strtr($string,$allDefinition));
    $content = str_replace('FONT-FAMILY', 'FONT-FAMILY-2131' ,$content);
    $content = str_replace('<a ','<a target="_blank" ',$content);
    $content = str_replace('<table ','<div class="container-table"><table ',$content);
    $content = str_replace('</table>','</table></div>',$content);

    return $content;
}
