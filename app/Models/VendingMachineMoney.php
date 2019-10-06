<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VendingMachineMoney
 *
 * @property int $id
 * @property int $price
 * @property int $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VendingMachineMoney newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VendingMachineMoney newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VendingMachineMoney query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VendingMachineMoney whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VendingMachineMoney whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VendingMachineMoney whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VendingMachineMoney wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VendingMachineMoney whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class VendingMachineMoney extends Model
{
    /**
     * @return VendingMachineMoney[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllRecords()
    {
        return VendingMachineMoney::All();
    }
}
