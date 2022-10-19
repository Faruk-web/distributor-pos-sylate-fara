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
use App\Models\StaffInOutDetails;
use App\Models\StaffDailyAttendence;



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


    public static function addAttendance() {
      $shop_id = Auth::user()->shop_id;
      $shop_settings = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
      
      $date = date("Y-m-d");
      $data = array("operation" => "fetch_log","auth_user" =>optional($shop_settings)->attendence_api_auth_user, "auth_code"=> optional($shop_settings)->attendence_api_auth_code, "start_date" => $date, "end_date" =>$date, "start_time" => "01:01:01", "end_time" => "24:60:00");

      $datapayload = json_encode($data);
      $api_request = curl_init('https://rumytechnologies.com/rams/json_api');
      curl_setopt($api_request, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($api_request, CURLINFO_HEADER_OUT, true);
      curl_setopt($api_request, CURLOPT_POST, true);
      curl_setopt($api_request, CURLOPT_POSTFIELDS, $datapayload);
      curl_setopt($api_request, CURLOPT_HTTPHEADER, array('Content-Type:
      application/json','Content-Length: ' . strlen($datapayload)));
      $result = curl_exec($api_request);
      $replace_syntax = str_replace('{"log":',"",$result);
      //print_r($replace_syntax);
      $replace_syntax = substr($replace_syntax, 0, -1);
      //print_r($replace_syntax);
      $json_data = json_decode($replace_syntax);

      
      if($json_data < 1) {
        return 0;
      }

      //dd($json_data);

      foreach ($json_data as $data) {
          $check_staff = User::find($data->registration_id);
          
          if(!is_null($check_staff)) {
              $check_details = StaffInOutDetails::Where(['shop_id'=>$shop_id, 'staff_id'=>$data->registration_id, 'date'=>$data->access_date, 'time'=>$data->access_time])->first('id');
              
              if(is_null($check_details)) {
                  $staff_details = new StaffInOutDetails;
                  $staff_details->shop_id = $shop_id;
                  $staff_details->staff_id = $data->registration_id;
                  $staff_details->date = $data->access_date;
                  $staff_details->time = $data->access_time;
                  $staff_details->access_id = $data->access_id;
                  $staff_details->save();
                  
                  $check_in_log = StaffDailyAttendence::Where(['shop_id'=>$shop_id, 'staff_id'=>$check_staff->id, 'date'=>$data->access_date])->first();
                  if(!is_null($check_in_log)) {
                      if($check_in_log->in_time != $data->access_time) {
                          $check_in_log->out_time = $data->access_time;
                          $check_in_log->update();
                      }
                  }
                  else {
                      $new_check_in_log = new StaffDailyAttendence;
                      $new_check_in_log->shop_id = $shop_id;
                      $new_check_in_log->staff_id = $check_staff->id;
                      $new_check_in_log->date = $data->access_date;
                      $new_check_in_log->in_time = $data->access_time;
                      $new_check_in_log->save();
                      
                  }
              }
          }
          
      }
      
  }
    


}
