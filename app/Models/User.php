<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_number',
        'name',
        'email',
        'phone',
        'nrc',
        'slug',
        'password',
        'role_id',
        'image',
        'company_id',
        'created_by',
        'noti_unread_count'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole($role)
    {
        return $this->role->name === $role;
        // return true;
    }

    public function permissionUser()
    {
        return $this->hasMany(PermissionUser::class, 'user_id');
    }

    public function hasPermissions($permission)
    {

        if ($this->role->permissions->contains('name', $permission)) {

            return true;
        }

        return $this->permissions->contains('name', $permission);
        // return true;
    }

    public function customers()
    {
        return $this->morphMany(Customer::class, 'createable');
    }

    public function orders()
    {
        return $this->morphMany(Order::class, 'createable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function hasAnyRelationships()
    {
        return $this->hasMany(ActivityLog::class, 'createable_id')->exists();
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'user_location', 'user_id', 'location_id');
    }

    public function getLocationName()
    {
        $locations = $this->locations;
        $location_name = '';
        $corma = ', ';
        $tmp = count($locations) - 1;
        foreach ($locations as $key => $location) {
            if ($key === $tmp) {
                $corma = ' ';
            }
            $location_name .= $location->location_name . $corma;
        }

        return $location_name;
    }

    public function getLocationIdsAttribute()
    {
        $locations = $this->locations;
        $location_ids = [];
        foreach ($locations as $key => $location) {
            $location_ids[] = $location->id;
        }
        return $location_ids;
    }

    public function pointOfSales()
    {
        return $this->hasMany(PointOfSale::class, 'createable_id');
    }

    public function purchaseReturns()
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class, 'created_by', 'id');
    }

    public function saleReturns()
    {
        return $this->hasMany(SaleReturn::class);
    }

    public function posReturns()
    {
        return $this->hasMany(PosReturn::class, 'created_by', 'id');
    }
}
