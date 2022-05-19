<?php

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Http\Requests\QueueRequest;
use App\Models\Store\Store;
use App\Repositories\Store\StoreRepository;
use App\Services\Shopper\ShopperService;
use App\Services\Store\StoreService;
use App\Services\Store\Location\LocationService;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class ShopperQueueController extends Controller
{
    /**
     * @var StoreService
     */
    protected $storeService;

    protected $store;

    protected $location;

    protected $shopperService;


    /**
     * LocationController constructor.
     * @param LocationService $location
     */
    public function __construct(StoreService $storeService, StoreRepository $store, LocationService $location, ShopperService $shopperService)
    {
        $this->storeService = $storeService;
        $this->store = $store;
        $this->location = $location;
        $this->shopperService = $shopperService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $store = $this->store->all();
        return view('public.shopper.stores')->with('stores', $store);
    }

    public function markAsComplete($shopperUuid)
    {
        $this->shopperService->updateByUuid($shopperUuid, ['status_id' => 2, 'check_out' => Carbon::now()->format('Y-m-d h:m:s')]);
        return redirect(URL::previous())->with('success', 'Shopper marked completed!');

    }

    /**
     * @param StoreStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addShopperToQueue(QueueRequest $request)
    {
        $res = $this->shopperService->checkinShopper($request->all());
        if ($res) {
            return redirect(URL::previous())->with('success', 'You are added to queue!');
        }
        return redirect()->back()->with('failed', 'Something went wrong!');
    }

    public function storeLocations(Store $store)
    {
        return view('public.store.locations.list')
            ->with('store', $store);
    }

    public function queues(string $storeUuid, string $locationUuid)
    {
        $location = $this->location->show(
            [
                'uuid' => $locationUuid
            ],
            [
                'Shoppers',
                'Shoppers.Status'
            ]
        );

        $shoppers = null;

        if (isset($location['shoppers']) && count($location['shoppers']) >= 1) {
            $shoppers = $this->location->getShoppers($location['shoppers']);
        }
        return view('public.store.locations.queues.list')
            ->with('location', $location)
            ->with('storeUuid', $storeUuid)
            ->with('locationUuid', $locationUuid)
            ->with('shoppers', $shoppers);
    }
}
