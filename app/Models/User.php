<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone'
    ];

    public static function login(Request $request)
    {
        Auth::attempt($request->only('email', 'password')+['is_banned' => false]);
        if(Auth::check()){
            return redirect(route('home'));
        }
        return back()->with('alert', [
            'status' => 'danger',
            'message' => 'Не верная почта или пароль'
        ]);
    }

    public function status()
    {
        return $this->is_banned ? '<span class="text-danger">Заблокирован</span>' : '<span class="text-success">Доступен</span>';
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function wishList()
    {
        return $this->belongsToMany(Location::class, WishList::class)->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany(Location::class, Order::class)
                    ->withPivot('started_at', 'finished_at', 'status', 'code');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
