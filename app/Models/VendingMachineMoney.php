<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendingMachineMoney extends Model
{
    public function getAllRecords()
    {
        return VendingMachineMoney::All();
    }
}
