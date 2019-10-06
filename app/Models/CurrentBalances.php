<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CurrentBalances
 *
 * @property int $id
 * @property string $name
 * @property int $summary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CurrentBalances newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CurrentBalances newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CurrentBalances query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CurrentBalances whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CurrentBalances whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CurrentBalances whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CurrentBalances whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CurrentBalances whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CurrentBalances extends Model
{
    /**
     * @return CurrentBalances[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllRecords()
    {
        return CurrentBalances::All();
    }

    /**
     * @return array
     */
    public function getAllSummary()
    {
        $allSummary=[];

        foreach ($this->getAllRecords() as $record) {
            $allSummary[$record->name] = $record->summary;
        }

        return $allSummary;
    }
}
