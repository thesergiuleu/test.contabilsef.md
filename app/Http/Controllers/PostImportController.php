<?php

namespace App\Http\Controllers;

use App\Category;
use App\Page;
use App\Post;
use App\Subscription;
use App\SubscriptionService;
use App\User;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Models\Role;

class PostImportController extends Controller
{
    private $database;

    public function __construct()
    {
        $this->database = DB::connection('mysql-2');
    }

    public function posts()
    {
        $wpPosts = $this->database->table('wp_posts')->whereDate('post_date', '>', '2018-01-01')->where('post_type', 'post')->get();

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


        $this->savePostsToLaravel($wpPosts->unique('ID'));
        return response()->json($wpPosts->values());
    }

    private function savePostsToLaravel(Collection $wpPosts)
    {
        foreach ($wpPosts as $wpPost) {
            $this->savePost($wpPost);
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
            if (Carbon::canBeCreatedFromFormat($eventDate, 'Ymd')) {
                return Carbon::make($eventDate);
            }
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
        $categories = collect(json_decode(file_get_contents(database_path('imports/categories.json')), true))->values();
        $wpParentCategories = $categories->where('menu_item_parent', 0)->values();
        $this->saveParentCategoriesToLaravel($wpParentCategories);
        $wpCategories = $categories->where('menu_item_parent', '>', 0)->values();
        $this->saveCategoriesToLaravel($wpCategories, $categories);

        return response()->json([
            'parent_categories' => $wpParentCategories->values(),
            'categories' => $wpCategories->values()
        ]);
    }

    private function saveParentCategoriesToLaravel($wpParentCategories)
    {
        foreach ($wpParentCategories as $key => $wpParentCategory) {
            preg_match('/\].*?\[/', $wpParentCategory['title'], $matches);
            $title = isset($matches[0]) ? str_replace(']', '', str_replace('[', '', $matches[0])) : $wpParentCategory['title'];
            $slug = rtrim($wpParentCategory['url'], '/');
            $slug = explode('/', $slug);
            $slug = last($slug);

            if (!Category::whereSlug(Category::PARENT_CATEGORIES[$slug])->first()) {
                $category = new Category();
                $category->name = $title;
                $category->slug = Category::PARENT_CATEGORIES[$slug];

                $category->save();
            }
        }
    }

    private function saveCategoriesToLaravel(Collection $wpCategories, Collection  $allCategories)
    {
        foreach ($wpCategories as $wpCategory) {
            $this->saveCategory($wpCategory, $allCategories);
        }
    }

    public function users()
    {
        $wpUsers = $this->database->table('wp_users')->get()->values();

        $this->saveUsersToLaravel($wpUsers);

        return response()->json([
            'users' => $wpUsers,
        ]);
    }

    private function saveUsersToLaravel(Collection $wpUsers)
    {
        $role = Role::where('name', 'user')->first();
        if (!$role) {
            $role = Role::create([
                'name' => 'user',
                'display_name' => 'Utilizator'
            ]);
        }
        foreach ($wpUsers as $wpUser) {

            if (User::whereId($wpUser->ID)->first()) continue;

            if ($usr = User::whereEmail($wpUser->user_email)->first()) continue;

            $created_at = $wpUser->user_registered;

            if ($wpUser->user_registered === "0000-00-00 00:00:00") {
                $created_at = Carbon::now()->format('Y-m-d H:i:s');
            }
            $user = new User();
            $user->id = $wpUser->ID;
            $user->role_id = $role->id;
            $user->name = $wpUser->display_name;
            $user->password = trim($wpUser->user_pass) != "" ? $wpUser->user_pass : $wpUser->last_password;
            $user->email = $wpUser->user_email;
            $user->created_at = Carbon::make($created_at);
            $user->phone = $wpUser->user_phone;
            $user->company = $wpUser->user_company;
            $user->position = $wpUser->user_function;
            $user->email_verified_at = Carbon::make($created_at);
            $user->save();
        }
    }

    public function pages()
    {
        $wpPages = $this->database->table('wp_posts')->where('post_type', 'page')->get()
            ->filter(function ($wpPage) {
                return strlen($wpPage->post_content) > 900;
            })->values();

        foreach ($wpPages as $wpPage) {
            $wpPage->post_meta = $this->database->table('wp_postmeta')->where('post_id', $wpPage->ID)->get();
        }
        $this->savePagesToLaravel($wpPages);

        return response()->json([
            'pages' => $wpPages,
        ]);
    }

    private function savePagesToLaravel(Collection $wpPages)
    {
        foreach ($wpPages as $wpPage) {
            preg_match('/\].*?\[/', $wpPage->post_title, $matches);
            $title = isset($matches[0]) ? str_replace(']', '', str_replace('[', '', $matches[0])) : $wpPage->post_title;

            preg_match('/\].*?\[/', $wpPage->post_title, $matches);
            $body = isset($matches[0]) ? str_replace(']', '', str_replace('[', '', $matches[0])) : $wpPage->post_content;

            if ($pg = Page::whereSlug($wpPage->post_name)->first()) $pg->delete();

            $page = new Page();
            $page->author_id = $wpPage->post_author;
            $page->title = $title;
            $page->seo_title = $title;
            $page->body = $body;
            $page->slug = $wpPage->post_name;
            $page->status = $this->handleWpPageStatus($wpPage->post_status);
            $page->created_at = Carbon::make($wpPage->post_date);
            $page->updated_at = Carbon::make($wpPage->post_modified);
            $page->save();
        }
    }

    private function handleWpPageStatus($post_status)
    {
        switch ($post_status) {
            case 'publish':
                return Page::STATUS_ACTIVE;
            default:
                return Page::STATUS_INACTIVE;
        }
    }

    public function subscriptionServices()
    {
        $wpServices = $this->database->table('wp_terms')
            ->leftJoin('wp_term_taxonomy', 'wp_term_taxonomy.term_id', 'wp_terms.term_id')
            ->where('wp_term_taxonomy.taxonomy', 'category')
            ->get()->keyBy('term_id')->only(['663', '664', '666']);

        $this->saveServicesToLaravel($wpServices);

        return response()->json([
            'services' => $wpServices,
        ]);
    }

    private function saveServicesToLaravel(Collection $wpServices)
    {
        foreach ($wpServices as $wpService) {

            if ($srvc = SubscriptionService::whereName($wpService->name)->first()) $srvc->delete();

            $service = new SubscriptionService();
            $service->name = $wpService->name;
            $service->description = $wpService->description;
            $service->discount = 0;
            $service->page_id = $this->getTermsAndConditionPage($wpService);
            $service->price = $this->getPrice($wpService);
            $service->save();
        }
    }

    private function getTermsAndConditionPage($wpService)
    {
        $doc = new DOMDocument();
        $doc->loadHTML($wpService->description);
        $selector = new DOMXPath($doc);

        $result = $selector->query('//a');

        if ($result->length == 0) {
            return null;
        }

        return Page::whereSlug(rtrim(ltrim($result[0]->getAttribute('href'),'/'), '/'))->first()->id ?? null;
    }

    private function getPrice($wpService)
    {
        preg_match_all('!\d+!', $wpService->description, $matches);
        switch (true) {
            case $wpService->term_id === 664:
                return $matches[0][1];
            default:
                return $matches[0][0];
        }
    }

    public function subscriptions()
    {
        $wpSubscriptions = $this->database->table('wp_service_info')->get();

        foreach ($wpSubscriptions as $wpSubscription) {

            if (!$user = User::whereId($wpSubscription->user_id)->first()) continue;

            if ($wpSubscription->start_date === "0000-00-00" || $wpSubscription->start_date === "1970-01-01") continue;
            if ($wpSubscription->end_date === "0000-00-00" || $wpSubscription->end_date === "1970-01-01") continue;

            $subscription = new Subscription();
            $subscription->user_id = $wpSubscription->user_id;
            $subscription->name = $user->name;
            $subscription->company = $user->company;
            $subscription->phone = $user->phone;
            $subscription->email = $user->email;
            $subscription->start_date = Carbon::make($wpSubscription->start_date);
            $subscription->end_date = Carbon::make($wpSubscription->end_date);
            $subscription->service_id = $this->getService($wpSubscription)->id;
            $subscription->price = $this->getService($wpSubscription)->price;

            $subscription->save();
        }

        return response()->json($wpSubscriptions);
    }

    private function getService($wpSubscription)
    {
        switch (true) {
            case $wpSubscription->service_id === 663:
                return SubscriptionService::whereName('Revista electronică ”Contabilsef.md”')->first();
            case $wpSubscription->service_id === 664:
                return SubscriptionService::whereName('Consultant SNC')->first();
            default:
                return SubscriptionService::whereName('Codul Fiscal')->first();
        }
    }

    private function saveCategory($wpCategory, $allCategories)
    {
        $slug = rtrim($wpCategory['url'], '/');
        $slug = explode('/', $slug);
        $slug = last($slug);
        if (isset(Category::PARENT_CATEGORIES[$slug])) {
            $slug = Category::PARENT_CATEGORIES[$slug];
        }
        $slug = $slug == 'seminare' ? Category::INSTRUIRE_CATEGORY : $slug;

        if (!$item = Category::whereSlug($slug)->first()) {
            preg_match('/\].*?\[/', $wpCategory['title'], $matches);
            $title = isset($matches[0]) ? str_replace(']', '', str_replace('[', '', $matches[0])) : $wpCategory['title'];

            $item = new Category();
            $item->name = $title;
            $item->slug = $slug;

            $wpParent = $allCategories->where('ID', $wpCategory['menu_item_parent'])->first();
            if ($wpParent) {
                $category1 = $this->saveCategory($wpParent, $allCategories);
                $item->parent_id = $category1->id ?? null;
            }
            $item->save();
            if ($wpCategory['object'] === 'post') {
                $wpPost = $this->database->table('wp_posts')->where('ID', $wpCategory['object_id'])->first();
                $wpPost->post_meta = $this->database->table('wp_postmeta')->where('post_id', $wpPost->ID)->get();
                $this->savePost($wpPost, $item);
            }
        }

        return $item;
    }

    private function savePost($wpPost, $category = null)
    {

        if (!$category) {
            $wpCategorySlug = $wpPost->category->first()->wp_term_slug;
            $category = Category::whereSlug($wpCategorySlug == 'seminare' ? Category::INSTRUIRE_CATEGORY : $wpCategorySlug)->first();
        }
        if (!Post::whereSlug($wpPost->post_name)->first()) {
            if ($category) {
                preg_match('/\].*?\[/', $wpPost->post_title, $matches);
                $title = isset($matches[0]) ? str_replace(']', '', str_replace('[', '', $matches[0])) : $wpPost->post_title;

                preg_match('/\].*?\[/', $wpPost->post_content, $matches);
                $body = isset($matches[0]) ? str_replace(']', '', str_replace('[', '', $matches[0])) : $wpPost->post_content;

                $post = new Post();
                $post->category_id = $category->id;
                $post->author_id = $wpPost->post_author;
                $post->title = $title;
                $post->seo_title = $title;
                $post->body = $body;
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


                if ($imageId = $wpPost->post_meta->where('meta_key', '_thumbnail_id')->first()->meta_value ?? null) {
                    $image = $this->database->table('wp_posts')->where('ID', $imageId)->first();
                    $imagePath = substr($image->guid, strpos($image->guid, 'uploads/'));

                    if (file_exists(public_path() . '/assets/imgs/' . $imagePath)) {
                        $newFile = new UploadedFile( public_path() . '/assets/imgs/' . $imagePath, $imagePath);
                        $newFile->storePubliclyAs('posts', str_replace('uploads/', '/', $imagePath), 'public');

                        $post->image = str_replace('uploads/', 'posts/', $imagePath);
                    }
                }

                $post->save();
                if (isset($wpPost->category)) {
                    if ($wpService = $wpPost->category->whereIn('term_id', [663, 664, 666])->first()) {

                        $service = SubscriptionService::whereName($wpService->wp_term_name)->first();

                        if ($service) {
                            $post->subscriptionServices()->syncWithoutDetaching($service);
                        }
                    }
                }
            }
        }
    }
}
