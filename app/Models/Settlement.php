<?php

namespace App\Models;

use CreateSettlementTypesTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;

    protected $table = 'settlements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'name',
        'zone_type',
        'zipcode_id',
        'settlement_type_id',
    ];

    protected $hidden = [
        'zipcode_id',
        'settlement_type_id'
    ];

    protected $with = ['settlement_type'];

    public function settlement_type()
    {
        return $this->belongsTo(SettlementType::class);
    }
}
