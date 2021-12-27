<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BoardingHouse extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'owner',
        'description',
        'village_id',
        'postal_code',
        'address',
        'phone_number',
        'whatsapp_number',
        'rule',
    ];

    /**
     * Get the village that owns the BoardingHouse
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }

    public static function index()
    {
        return BoardingHouse::all();
    }

    public static function getData() 
    {
        return BoardingHouse::first();
    }

    public static function countData() 
    {
        return BoardingHouse::count();
    }

    public static function store(Request $request)
    {
        BoardingHouse::create($request->all());
    }

    public static function edit(Request $request, BoardingHouse $boardingHouse)
    {
        $boardingHouse->update($request->all());
    }
}
