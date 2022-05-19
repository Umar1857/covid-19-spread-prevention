<?php

namespace App\Services\Store\Location;

use App\Repositories\Store\Location\LocationRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use  App\Services\Shopper\ShopperService;

/**
 * Class LocationService
 * @package App\Services\Store
 */
class LocationService extends BaseService
{
    /**
     * @var LocationRepository
     */
    protected $location;
    protected $shopperService;

    /**
     * LocationService constructor.
     * @param LocationRepository $location
     */
    public function __construct(LocationRepository $location, ShopperService $shopperService)
    {
        $this->location = $location;
        $this->shopperService = $shopperService;
        parent::__construct($this->location);
    }

    /**
     * @param array|null $data
     * @return array|null
     */
    public function getShoppers(array $data = null): ?array
    {
        if ($data === null) {
            return null;
        }

        return [
            'active' => $this->filterShoppersByStatus($data, 'Active'),
            'pending' => $this->filterShoppersByStatus($data, 'Pending'),
            'completed' => $this->filterShoppersByStatus($data, 'Completed')
        ];
    }

    /**
     * @desc Filter Shoppers By Status. Sort Active and Pending by Check In Ascending. Sort Completed by Check Out Descending.
     *
     * @param array $data
     * @param string $status
     * @return array
     */
    private function filterShoppersByStatus(array $data, string $status): array
    {
        return collect($data)->filter(function ($value, $key) use ($status) {
            if (isset($value['status']['name']) && $value['status']['name'] === $status) {
                return $value;
            }
        })
            ->when($status === 'Completed', function ($collection) {
                return $collection->sortByDesc('check_out');
            })
            ->when($status !== 'Completed', function ($collection) {
                return $collection->sortBy('check_in');
            })
            ->toArray();
    }


    public function updateLimit($location_id, $limit)
    {
        DB::beginTransaction();
        try {
            $this->location->update($location_id, ['shopper_limit' => $limit]);
            $this->shopperService->reviseQueue($location_id, $limit);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
