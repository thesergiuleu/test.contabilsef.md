<?php

namespace App\Console\Commands;

use App\Notifications\SendSubscriptionReminderNotification;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class NotifyUserAboutSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to users who requested to subscribe but have not payed for it yet';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subscriptions = Subscription::query()->whereNull('start_date')->whereNull('end_date')->get();

        foreach ($subscriptions as $subscription) {
            if (Carbon::parse($subscription->created_at)->addDays(setting('site.days_until_subscription_reminder', 7))->format('Y-m-d') >= Carbon::now()->format('Y-m-d')) {
                if ($subscription->user->activeSubscription($subscription->service_id)) continue;

                Notification::send($subscription->user, new SendSubscriptionReminderNotification($subscription));
            }
        }
    }
}
