<?php

namespace App\Jobs;

use App\NewsletterSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PrepareNewsletterSubscriptionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $newsletterSubscriptions = NewsletterSubscription::all();

        $newsletterSubscriptions->each(function ($newsletterSubscription) {
            SendNewsletterSubscriptionEmail::dispatch($newsletterSubscription->email);
        });

        PrepareNewsletterSubscriptionEmail::dispatch()->delay(now()->addSecond());
    }
}
