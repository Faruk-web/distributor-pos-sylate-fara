<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Product;

class GodownController extends Controller
{
    
    //Begin:: Godown Current Stock
    public function godown_current_stock() {
        if(User::checkPermission('godown.stock.info') == true){
            $wing = 'godown';
            
            return view('cms.shop_admin.godown.stock.current_stock', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Godown Current Stock

    
    
    

    
    
}
