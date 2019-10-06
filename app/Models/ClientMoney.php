<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ClientMoney
 *
 * @property int $id
 * @property int $price
 * @property int $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClientMoney newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClientMoney newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClientMoney query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClientMoney whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClientMoney whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClientMoney whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClientMoney wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClientMoney whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClientMoney extends Model
{
    /**
     * @return ClientMoney[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllRecords()
    {
        return ClientMoney::All();
    }
}
