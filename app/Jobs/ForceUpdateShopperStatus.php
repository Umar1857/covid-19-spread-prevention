<?php

namespace App\Jobs;

use App\Models\Shopper\Shopper;
use App\Models\Store\Location\Location;
use App\Repositories\Shopper\ShopperRepository;
use App\Repositories\Store\Location\LocationRepository;
use App\Services\Shopper\ShopperService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ForceUpdateShopperStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shopperService = new ShopperService(new ShopperRepository(new Shopper()), new LocationRepository(new Location()));
        $shopperService->CompleteShopperJob();
    }
}
