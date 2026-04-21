<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tool extends Model
{
    use HasFactory;
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
