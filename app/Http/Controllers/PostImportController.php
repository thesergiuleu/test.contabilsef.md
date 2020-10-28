<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PostImportController extends Controller
{
    private $database;

    public function __construct()
    {
        $this->database = DB::connection('mysql-2');
    }

    public function posts()
    {
        $wpPosts = $this->database->table('wp_posts')->whereDate('post_date', '>', '2020-08-30')->where('post_type', 'post')->get();

        $wpPosts = $wpPosts->each(function (&$wpPost) {
            $wpPost->post_meta = $this->database->table('wp_postmeta')->where('post_id', $wpPost->ID)->get();
            $wpPost->comments = $this->database->table('wp_comments')->where('comment_post_ID', $wpPost->ID)->get();

            $wpPost->category = $this->database
                ->table('wp_term_taxonomy')
                ->where('wp_term_relationships.object_id', $wpPost->ID)
                ->select(['wp_term_relationships.term_taxonomy_id', 'wp_term_taxonomy.term_id', 'wp_term_taxonomy.taxonomy', 'wp_terms.name as wp_term_name', 'wp_terms.slug as wp_term_slug'])
                ->leftJoin('wp_term_relationships', 'wp_term_relationships.term_taxonomy_id', 'wp_term_taxonomy.term_taxonomy_id')
                ->leftJoin('wp_terms', 'wp_terms.term_id', 'wp_term_taxonomy.term_id')
                ->where('wp_term_taxonomy.taxonomy', 'category')
                ->get();
        });

        $wpPosts = $wpPosts->filter(function ($item) {
            return $item->category->isNotEmpty();
        });


        $this->savePostsToLaravel($wpPosts);
        return response()->json($wpPosts->values());
    }

    private function savePostsToLaravel(Collection $wpPosts)
    {
        foreach ($wpPosts as $wpPost) {
            $wpCategorySlug = $wpPost->category->first()->wp_term_slug;
            if (!Post::whereSlug($wpPost->post_name)->first() && $category = Category::whereSlug($wpCategorySlug == 'seminare' ? Category::INSTRUIRE_CATEGORY : $wpCategorySlug)->first()) {
                $post = new Post();
                $post->category_id = $category->id;
                $post->author_id = User::first()->id;
                $post->title = $wpPost->post_title;
                $post->seo_title = $wpPost->post_title;
                $post->body = $wpPost->post_content;
                $post->slug = $wpPost->post_name;
                $post->status = $this->handleWpPostStatus($wpPost->post_status);
                $post->privacy = $this->getWpPrivacy($wpPost);
                $post->emails = $this->getWpEmail($wpPost);
                $post->views = $this->getWpViews($wpPost);
                $post->event_date = $this->getWpEventDate($wpPost);
                $post->external_author = $this->getWpExternalAuthor($wpPost);
                $post->created_at = Carbon::make($wpPost->post_date);
                $post->updated_at = Carbon::make($wpPost->post_modified);
                $post->external_link = $this->getWpExternalLink($wpPost);

                $post->save();
            }
        }
    }

    private function handleWpPostStatus($status)
    {
        switch ($status) {
            case 'publish':
                return Post::PUBLISHED;
            case 'future':
            case 'pending':
                return Post::PENDING;
            default:
                return Post::DRAFT;
        }
    }

    private function getWpPrivacy($wpPost)
    {
        return $wpPost->post_meta->where('meta_key', 'rol_postare')->first()->meta_value ?? 0;
    }

    private function getWpEmail($wpPost)
    {
        $emails = $wpPost->post_meta->whereIn('meta_key', ['email_one', 'email_two']);
        $emailsToStr = null;
        if ($emails->isNotEmpty()) {
            $emailsToStr = '';
            foreach ($emails as $item) {
                $emailsToStr .= $item->meta_value . ',';
            }
            $emailsToStr = rtrim($emailsToStr, ',');
        }
        return $emailsToStr;
    }

    private function getWpViews($wpPost)
    {
        return $wpPost->post_meta->where('meta_key', 'views')->first()->meta_value ?? 0;
    }

    private function getWpEventDate($wpPost)
    {
        $eventDate = $wpPost->post_meta->where('meta_key', 'date_in_calendar')->first()->meta_value;
        if (trim($eventDate) != "") {
            return Carbon::make($eventDate);
        }
        return null;
    }

    private function getWpExternalAuthor($wpPost)
    {
        $value = $wpPost->post_meta->where('meta_key', 'req_link')->first()->meta_value;
        if (trim($value) != "") {
            return $value;
        }
        return null;
    }

    private function getWpExternalLink($wpPost)
    {
        $metaValue = $wpPost->post_meta->where('meta_key', 'type')->first()->meta_value;

        if ($metaValue == '2') {
            preg_match('/\].*?\[/', $wpPost->post_content, $matches);
            $content = isset($matches[0]) ? str_replace(']', '', str_replace('[', '', $matches[0])) : $wpPost->post_content;
            return trim(strip_tags($content));
        }
        return null;
    }

    public function categories()
    {
        $wpParentCategories = $this->database->table('wp_posts')
            ->whereIn('post_name', array_keys(Category::PARENT_CATEGORIES))
            ->orderBy('post_parent')
            ->get()
            ->each(function (&$wpPost) {
//                $wpPost->children = $this->getChildren($wpPost);
                $wpPost->parent = $this->getParentPost($wpPost);
            });

        $wpCategories = $this->database->table('wp_terms')
            ->leftJoin('wp_term_taxonomy', 'wp_term_taxonomy.term_id', 'wp_terms.term_id')
            ->where('wp_term_taxonomy.taxonomy', 'category')
            ->get()->keyBy('term_id')->except(['662', '663', '664', '666']);


        $this->saveParentCategoriesToLaravel($wpParentCategories->values());

        $this->saveCategoriesToLaravel($wpCategories->values());


        return response()->json([
            'parent_categories' => $wpParentCategories->values(),
            'categories' => $wpCategories->values()
        ]);
    }

    private function getParentPost($post)
    {
        $wpParentPost = $this->database->table('wp_posts')->where('ID', $post->post_parent)->first();

        if ($wpParentPost && $wpParentPost->post_parent > 0) {
            $wpParentPost->parent = $this->getParentPost($wpParentPost);
        }
        return $wpParentPost;
    }

    private function saveParentCategoriesToLaravel($wpParentCategories)
    {
        foreach ($wpParentCategories as $key => $wpParentCategory) {
            preg_match('/\].*?\[/', $wpParentCategory->post_title, $matches);
            $title = isset($matches[0]) ? str_replace(']', '', str_replace('[', '', $matches[0])) : $wpParentCategory->post_title;

            if ($wpParentCategory->post_parent > 0) {

                $parent = $wpParentCategories->where('ID', $wpParentCategory->post_parent)->first();

                $parentCategory = Category::whereSlug(Category::PARENT_CATEGORIES[$parent->post_name])->first();
            }

            if (!Category::whereSlug(Category::PARENT_CATEGORIES[$wpParentCategory->post_name])->first()) {
                $category = new Category();
                $category->parent_id = $parentCategory->id ?? null;
                $category->name = $title;
                $category->slug = Category::PARENT_CATEGORIES[$wpParentCategory->post_name];

                $category->save();
            }
        }
    }

    private function saveCategoriesToLaravel(Collection $wpCategories)
    {
        foreach ($wpCategories as $wpCategory) {
            if (!Category::whereSlug($wpCategory->slug)->first()) {
                $category = new Category();
                $category->name = $wpCategory->name;
                $category->slug = $wpCategory->slug == 'seminare' ? Category::INSTRUIRE_CATEGORY : $wpCategory->slug;

                $category->save();
            }
        }
    }

    private function getChildren($wpPost)
    {
        return $this->database->table('wp_posts')->where('post_parent', $wpPost->ID)->get();
    }
}
