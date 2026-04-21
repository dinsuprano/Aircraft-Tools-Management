<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowTool extends Model
{
    protected $guarded = [];

    public function tool()
    {
        return $this->belongsTo(Tool::class, 'barcode', 'barcode');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
