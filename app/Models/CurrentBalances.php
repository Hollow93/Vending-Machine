<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentBalances extends Model
{
    public function getAllRecords()
    {
        return CurrentBalances::All();
    }

    public function getAllSummary()
    {
        $allSummary=[];

        foreach ($this->getAllRecords() as $record) {
            $allSummary[$record->name] = $record->summary;
        }

        return $allSummary;
    }
}
