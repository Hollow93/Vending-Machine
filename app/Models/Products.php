<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Products
 *
 * @property int $id
 * @property string $name
 * @property int $amount
 * @property int $price
 * @property string $image_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Products newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Products newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Products query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Products whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Products whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Products whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Products whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Products whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Products wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Products whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Products extends Model
{
    /**
     * @return Products[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllRecords()
    {
        return Products::All();
    }
}
