<?php

namespace App\Models;

use App\Http\Controllers\BranchSettingController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, HasRoles;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'shop_id',
        'name',
        'email',
        'phone',
        'type',
        'address',
        'active',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // Custom code
    public static function getPermissionGroupsForAdminHealperRole()
    {
      $permissionGroups = DB::table('permissions')->select('group_name')->groupBy('group_name')->where('group_name', '!=', 'Branch')->get();
      return $permissionGroups;
    }
    public static function permissionsByGroupNameForAdminHealperRole($groupname)
    {
      $permissions = DB::table('permissions')->where('group_name', $groupname)->where('group_name', '!=', 'Branch')->orderBy('name', 'asc')->get();
      return $permissions;
    }


    public static function getPermissionGroupsForBranchUser()
    {
      $permissionGroups = DB::table('permissions')->select('group_name')->groupBy('group_name')->where('group_name', 'Branch')->get();
      return $permissionGroups;
    }

    public static function permissionsByGroupNameForBranchUserRole($groupname)
    {
      $permissions = DB::table('permissions')->where('group_name', $groupname)->where('group_name', 'Branch')->orderBy('name', 'asc')->get();
      return $permissions;
    }

    public static function checkPermission($permissionName) {
      if(Auth::user()->can($permissionName) || Auth::user()->type == 'owner') {
          return true;
      }
    }

    public static function checkMultiplePermission($permissionName) {
      if(Auth::user()->hasAnyPermission($permissionName) || Auth::user()->type == 'owner') {
          return true;
      }
    }

    

    //return branch name
    public function branchName() {
      return $this->belongsTo(Branch_setting::class, 'branch_id');
    }

    //return branch info
    public function branch_info() {
      return $this->belongsTo(Branch_setting::class, 'branch_id');
    }

    //user shop info
    public function shop_info() {
      return $this->belongsTo(Shop_setting::class, 'shop_id', 'shop_code');
    }

    //hand cash
    public function shop_cash() {
        return $this->belongsTo(Net_cash_bl::class, 'shop_id', 'shop_id');
    }

    //return branch info
    public function area_info() {
      return $this->belongsTo(Area::class, 'sr_area_id');
    }
    


}
