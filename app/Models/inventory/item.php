<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;
    protected $fillable = [        'unit_id',
    'sale_price',
    'cost_price',
    'uom_id',
    'inv_supplier_id',
    'model_no',
    'description',
    'location_id',
    'syscode',
    'item_name',
    'date_added',
    'qty_left',
    'user_id'
];

}
