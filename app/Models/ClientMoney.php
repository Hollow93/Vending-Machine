<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientMoney extends Model
{
    public function getAllRecords()
    {
        return ClientMoney::All();
    }
}
