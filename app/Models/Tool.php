<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $guarded = [];

    public function borrows()
    {
        return $this->hasMany(BorrowTool::class, 'barcode', 'barcode');
    }

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class, 'barcode', 'barcode');
    }
}
