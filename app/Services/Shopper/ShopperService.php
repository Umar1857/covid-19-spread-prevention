<?php

namespace App\Services\Shopper;

use App\Repositories\Shopper\ShopperRepository;
use App\Repositories\Store\Location\LocationRepository;
use App\Services\BaseService;
use Carbon\Carbon;

/**
 * Class ShopperService
 * @package App\Services\Shopper
 */
class ShopperService extends BaseService
{
    /**
     * @var ShopperRepository
     */
    protected $shopperRepository;
    protected $locationRepo;

    /**
     * ShopperService constructor.
     * @param ShopperRepository $shopperRepository
     */
    public function __construct(ShopperRepository $shopperRepository, LocationRepository $locationRepo)
    {
        $this->shopperRepository = $shopperRepository;
        $this->locationRepo = $locationRepo;
        parent::__construct($this->shopperRepository);
    }

    /**
     * @param $request
     * @return bool
     */
    public function checkinShopper($request): bool
    {
        try {
            $timestemp = Carbon::now()->format('Y-m-d h:m:s');
            $location = $this->locationRepo->show(['uuid' => $request['locationUuid']]);
            $activeShoppersCount = $this->shopperRepository->getActiveShopperCount($location['id']);
            unset($request['locationUuid']);
            unset($request['storeUuid']);
            unset($request['_token']);
            $request['check_in'] = $timestemp;
            if ($activeShoppersCount < $location['shopper_limit']) {
                $request['active_at'] = $timestemp;
            }
            $request['location_id'] = $location['id'];
            $request['status_id'] = ($activeShoppersCount < $location['shopper_limit']) ? 1 : 3;

            $this->create($request);
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
            return false;
        }
    }

    /**
     * @param $location_id
     * @param $limit
     * @return bool
     */
    public function reviseQueue($location_id, $limit): bool
    {

        $activeShoppers = $this->shopperRepository->getActiveShopperCount($location_id);
        if ($activeShoppers < $limit) {
            $this->shopperRepository->reviseQueue($location_id, $limit - $activeShoppers);
        }
        return true;
    }

    /**
     * @return void
     */
    public function CompleteShopperJob()
    {
        $this->shopperRepository->completeShopperJob();
    }

}
