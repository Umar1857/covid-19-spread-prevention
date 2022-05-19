<?php

namespace App\Repositories\Shopper;

use App\Models\Shopper\Shopper;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Mixed_;

/**
 * Class ShopperRepository
 * @package App\Repositories\Shopper
 */
class ShopperRepository extends BaseRepository
{
    /**
     * @var Shopper
     */
    protected $shopper;

    /**
     * ShopperRepository constructor.
     * @param Shopper $shopper
     */
    public function __construct(Shopper $shopper)
    {
        $this->shopper = $shopper;
        parent::__construct($this->shopper);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        return $this->model->create($request);
    }

    /**
     * @param $location_id
     * @return mixed
     */
    public function getActiveShopperCount($location_id): mixed
    {
        return $this->shopper
            ->where('location_id', $location_id)
            ->where('created_at', '>', Carbon::now()->subDays(2))
            ->where('status_id', 1)->count();
    }

    /**
     * @param $location_id
     * @param $limit
     * @return mixed
     */
    public function reviseQueue($location_id, $limit): mixed
    {
        return $this->shopper
            ->where('created_at', '>', Carbon::now()->subDays(2))
            ->where('location_id', $location_id)
            ->where('status_id', 3)
            ->limit($limit)
            ->update(['status_id' => 1, 'active_at' => Carbon::now()->format('Y-m-d h:m:s')]);
    }

    /**
     * @param $location_id
     * @param $limit
     * @return mixed
     */
    public function completeShopperJob(): mixed
    {
        return $this->shopper
            ->where('active_at', '<', Carbon::now()->subHour(2))
            ->where('status_id', 1)
            ->update(['status_id' => 2, 'check_out' => Carbon::now()->format('Y-m-d h:m:s')]);
    }
}
