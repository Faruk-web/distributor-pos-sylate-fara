<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
       
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'max:11', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $code = date("ymd").rand(100, 999);

        $data = array();
        $data['shop_code'] = $code;
        $data['reseller_id'] = $input['reseller_id'];
        $data['shop_name'] = $input['company_name'];
        $data['start_date'] = date("Y-m-d");
        DB::table('shop_settings')->insert($data);
        DB::table('net_cash_bls')->insert(['shop_id' => $code, 'balance' => 0]);
        $customer_code = $code.'WALKING';
        DB::table('customers')->insert(['shop_id' => $code, 'code' => $customer_code, 'name'=>'Walking Customer', 'phone'=>'p'.$code, 'email'=>'WC'.$code.'@gmail.com', 'address'=>'none', 'opening_bl'=>0, 'balance'=>0, 'active'=>1]);

        return User::create([
            'shop_id' => $code,
            'type' => 'owner',
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'password' => Hash::make($input['password']),
        ]);


    }
}
