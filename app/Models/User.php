<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
        'device_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the customer associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public static function createEmail($room_name)
    {
        $date = date('d');
        $email = Str::lower(str_replace(' ', '', $room_name)) . Str::random(2) . '@bougenville.com';
        return $email;
    }

    public static function createPassword()
    {
        $password = Str::random(8);
        return $password;
    }

    public static function storeCustomer(Request $request, $email, $password)
    {
        $user = User::create([
            'name' => $request['name'],
            'role' => 'customer',
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        return $user->id;
    }

    public static function updateCustomer(Request $request, $id)
    {
        $user = User::find($id);
        if ($request->password == 0)
        {
            $user->email = $request->email;
        }
        else
        {
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->save();
    }

    public static function destroy($id)
    {
        User::where('id', $id)->delete();
    }
}
