<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Customer;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'check_in_date',
        'status',
        'temporary_password',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public static function index()
    {
        return Booking::all();
    }

    public static function store(Request $request, $id, $password)
    {
        Booking::create([
            'customer_id' => $id,
            'check_in_date' => $request->check_in_date,
            'status' => 'pending',
            'temporary_password' => $password,
        ]);

    }

    public static function updateStatus($booking, $status)
    {
        $customer = Customer::find($booking->customer_id);
        Customer::updateStatus($customer);
        $booking->update([
            'status' => $status,
        ]);
    }
}
