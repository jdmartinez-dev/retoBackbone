<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{
    use HasFactory;

    protected $table = 'zipcodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zip_code',
        'locality',
        'municipality_id'
    ];

    protected $hidden = [
        'id',
        'municipality_id'
    ];

    protected $with = ['federal_entity', 'settlements', 'municipality'];

    public function settlements()
    {
        return $this->hasMany(Settlement::class)
            ->select(['key', 'name', 'zone_type', 'zipcode_id', 'settlement_type_id']);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function federal_entity()
    {
        return $this->hasOneThrough(State::class, Municipality::class, 'id', 'id', 'municipality_id', 'state_id')
            ->select(['states.key', 'states.name', 'states.code']);
    }
}
