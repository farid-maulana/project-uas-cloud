<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'payment_method',
        'total', 
        'description', 
        'evidence',
        'status',
    ];

    /**
     * Get the customer that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get all of the transactionDetails for the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public static function getData()
    {
        return Transaction::all();
    }

    public static function getDataDesc()
    {
        return Transaction::orderByDesc('created_at')->get();
    }

    public static function indexLimit()
    {
        return Transaction::orderByDesc('created_at')->limit(5)->get();
    }

    public static function getDataNotifLimit()
    {
        return Transaction::orderByDesc('created_at')->limit(3)->get();
    }

    public static function getDataByCustomerDesc($customer_id)
    {
        return Transaction::where('customer_id', $customer_id)->orderByDesc('created_at')->get();

    }

    public static function store(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $payment_method = 'cash';
            $status = 'accept';
            $evidence = NULL;
        } else {
            $payment_method = 'transfer';
            $status = 'pending';
            $evidence = $request->file('evidence')->store('evidence', 'public');
        }

        $transaction = Transaction::create([
            'customer_id' => $request->customer_id,
            'payment_method' => $payment_method,
            'total' => $request->total,
            'description' => $request->description,
            'evidence' => $evidence,     
            'status' => $status,
        ]);
        return $transaction->id;
    }

    public static function edit(Request $request, Transaction $transaction)
    {
        if (Auth::user()->role == 'admin') {
            $transaction->update([
                'customer_id' => $request->customer_id,
                'total' => $request->total,
                'description' => $request->description,
            ]);
        } else {
            if($request->file('evidence') == "") {
                $transaction->update([
                    'customer_id' => $request->customer_id,
                    'total' => $request->total,
                    'description' => $request->description,
                ]);
            } else {
                if ($transaction->evidence&&file_exists(storage_path('app/public/'.$transaction->evidence))) {
                    \Storage::delete('public/'.$transaction->evidence);
                }
                $evidence = $request->file('evidence')->store('evidence', 'public');
                $transaction->update([
                    'customer_id' => $request->customer_id,
                    'total' => $request->total,
                    'description' => $request->description,
                    'evidence' => $evidence,
                ]);
                // $image = $request->file('image');
                // $image->storeAs('public/', $image->hashName());
            }
        }
    }

    public static function updateStatus(Transaction $transaction)
    {
        $transaction->update([
            'status' => 'accept',
        ]);
    }
}
