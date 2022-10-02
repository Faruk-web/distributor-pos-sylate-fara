<?php

namespace App\Http\Controllers;

use App\Models\Branch_setting;
use App\Models\Damage_product;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Product_stock;

class DamageProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('branch.damage.product') == true){
            return view('cms.branch.products.products_for_damage');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function index_data(Request $request)
    {
        if ($request->ajax()) {
            $product_stocks = Product_stock::where('branch_id', Auth::user()->branch_id)->where('shop_id', Auth::user()->shop_id)->get();
            return Datatables::of($product_stocks)
                ->addIndexColumn()
                ->addColumn('product_name', function($row){
                    $info = optional($row->product_info)->p_name;
                    return $info;
                })
                ->addColumn('brand_name', function($row){
                    $info = optional($row->product_info->brand_info)->brand_name;
                    return $info;
                })
                ->addColumn('image', function($row){
                    $info =  '<img style="width: 50px;" src="'.asset(optional($row->product_info)->image).'" class="rounded">';
                    return $info;
                })
                ->addColumn('stock', function($row){
                    $info = $row->stock." ".$row->product_info->unit_type_name->unit_name;
                    return $info;
                })
                ->addColumn('action', function($row){
                    $info = '<a  href="javascript:void(0)" onclick="add_damage('.$row->pid.','.$row->stock.')" class="btn btn-danger btn-sm">add</a>';
                    return $info;
                })
                
                ->rawColumns(['product_name', 'action', 'brand_name', 'image', 'stock'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(User::checkPermission('branch.damage.product') == true){
            $validated = $request->validate([
                'pid' => 'required',
                'unit' => 'required',
                'reason' => 'required',
            ]);
            $shop_id = Auth::user()->shop_id;
            $branch_id = Auth::user()->branch_id;
            $product_check = DB::table('products')->where(['id'=>$request->pid, 'shop_id'=>$shop_id])->first(['id', 'purchase_price', 'selling_price', 'p_name']);
            $product_stock = DB::table('product_stocks')->where(['pid'=>$request->pid, 'shop_id'=>$shop_id, 'branch_id'=>$branch_id])->first('stock');
            $current_stock = $product_stock->stock;

            if(!empty($product_check->id) && $current_stock >= $request->unit) {
                $purchase_price = $product_check->purchase_price;
                $selling_price = $product_check->selling_price;
                $insert = Damage_product::insert(['shop_id'=>$shop_id, 'branch_id'=>$branch_id, 'pid'=>$request->pid, 'quantity'=>$request->unit, 'purchase_price'=>$purchase_price, 'selling_price'=>$selling_price, 'reason'=>$request->reason, 'date'=>Carbon::now()]);
                if($insert) {
                    $p_data = array();
                    $p_data['product_id'] = $request->pid;
                    $p_data['branch_id'] = $branch_id;
                    $p_data['quantity'] = $request->unit;
                    $p_data['price'] = $purchase_price;
                    $p_data['total_price'] = $purchase_price*$request->unit;
                    $p_data['status'] = 0; // 0 means Out
                    $p_data['product_form'] = 'DM';
                    $p_data['invoice_id'] = '00';
                    $p_data['note'] = $request->reason;
                    $p_data['created_at'] = Carbon::now();
                    DB::table('product_trackers')->insert($p_data);

                    $update_stock = $current_stock-$request->unit;
                    DB::table('product_stocks')->where(['pid'=>$request->pid, 'branch_id'=>$branch_id])->update(['stock'=>$update_stock]);
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Add Damage product, Product name: '.$product_check->p_name.', damage Quantity: '.$request->unit.'', 'created_at' => Carbon::now()]);
                    return Redirect()->back()->with('success', 'Damage Product added successfully.');
                }
            }
            else {
                return Redirect()->back()->with('error', 'Error occoured, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\damage_product  $damage_product
     * @return \Illuminate\Http\Response
     */
    public function show(damage_product $damage_product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\damage_product  $damage_product
     * @return \Illuminate\Http\Response
     */
    public function edit(damage_product $damage_product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\damage_product  $damage_product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, damage_product $damage_product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\damage_product  $damage_product
     * @return \Illuminate\Http\Response
     */
    public function destroy(damage_product $damage_product)
    {
        //
    }

    public function branch_all_damaged_product()
    {
        if(User::checkPermission('branch.damage.product') == true){
            return view('cms.branch.products.all_damaged_products');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function branch_all_damaged_product_data(Request $request)
    {
        if ($request->ajax()) {
            $damaged_data = Damage_product::where('branch_id', Auth::user()->branch_id)->where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
            return Datatables::of($damaged_data)
                ->addIndexColumn()
                ->addColumn('product_name', function($row){
                    $info = optional($row->product_info)->p_name;
                    return $info;
                })
                ->addColumn('brand_name', function($row){
                    $info = optional($row->product_info->brand_info)->brand_name;
                    return $info;
                })
                ->addColumn('quantity', function($row){
                    $info = $row->quantity." ".$row->product_info->unit_type_name->unit_name;
                    return $info;
                })
                ->addColumn('reason', function($row){
                    $info = '<span class="reason_text">'.optional($row)->reason.'</span>';
                    return $info;
                })
                ->addColumn('date', function($row){
                    $info = date('d-m-Y', strtotime($row->date));
                    return $info;
                })
                
                ->rawColumns(['product_name', 'quantity', 'brand_name', 'reason', 'date'])
                ->make(true);
        }
    }

    //Begin:: Admin damage products
    public function admin_damage_product_index() {
        if(User::checkPermission('admin.damage.product') == true){
            $wing = 'main';
            $branches = Branch_setting::where('shop_id', Auth::user()->shop_id)->get(['id', 'branch_name', 'branch_address']);
            return view('cms.shop_admin.produts.add_damage_product', compact('wing', 'branches'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function admin_damage_product_index_data(Request $request)
    {
        if ($request->ajax()) {
            $products = DB::table('products')->where(['shop_id'=>Auth::user()->shop_id, 'active'=>1])->get(['id', 'p_name', 'barCode']);
            return Datatables::of($products)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '<button onclick="add_damage('.$row->id.')" class="btn btn-danger btn-sm">Add</button>';
                    return $info;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function admin_add_damage_godown_and_branch_stock_info(Request $request) {
        $pid = $request->pid;
        $place = $request->place;
        $shop_id = Auth::user()->shop_id;
        $output = '';
        $product_info = DB::table('products')->where(['id'=>$pid, 'shop_id'=>$shop_id])->first(['id', 'G_current_stock', 'p_name']);
        if(!empty($product_info->id) && $place == 'G') {
            $godown_product_stock = DB::table('product_stocks')->where(['branch_id'=>'G', 'pid'=>$pid])->where('stock', '>', 0)->get();
            if(count($godown_product_stock) > 0) {
                $output .='
                        <h4 class="text-center text-primary">'.$product_info->p_name.' in Godown</h4>
                            <table class="table table-bordered">
                              <thead>
                                <tr class="bg-success text-light">
                                  <th width="45%">Info</th>
                                  <th>Stock Qty</th>
                                  <th>Damage Qty</th>
                                </tr>
                              </thead>
                              <tbody id="damage_tbody>';
                              foreach($godown_product_stock as $stock) {
                                $variation_name = '';
                                if($stock->variation_id != 0 && $stock->variation_id != '') {
                                    $variation_info = DB::table('variation_lists')->where(['id'=>$stock->variation_id])->first();
                                    $variation_name =  ' ('.optional($variation_info)->list_title.')';
                                }
                                $generate_id = $stock->pid.$stock->id;
                            $output .='<tr id="cart_tr'.$generate_id.'">
                                          <td>
                                              <input type="hidden" name="pid[]" value="'.$stock->pid.'">
                                              <input type="hidden" name="lot_number[]" value="'.$stock->lot_number.'">
                                              <input type="hidden" name="variation_id[]" value="'.$stock->variation_id.'">
                                              <input type="hidden" name="database_id[]" value="'.$stock->id.'">
                                              <span class="text-success">'.$product_info->p_name.' '.$variation_name.'</span><br>
                                              <small><b>Lot Number: </b>'.$stock->lot_number.', <b>Sales Price:</b> '.$stock->sales_price .', <b>Discount:</b> '.$stock->discount.'('.$stock->discount_amount.'), <b>VAT: </b>'.$stock->vat.'%</small>
                                          </td>
                                          <td>
                                              <input type="number" step="any" value="'.$stock->stock.'" class="form-control" readonly="" id="stock_qty" max="" name="stock_qty[]">
                                          </td>
                                          <td>
                                            <input type="number" step="any" value="" class="form-control" required id="damage_qty" max="'.$stock->stock.'" name="damage_qty[]">
                                            <small class="text-danger">এই লট থেকে ড্যামেজ না দেখাতে চাইলে 0 দিন</small>
                                          </td>
                                        </tr>';
                              }
                                
                              $output .='</tbody>
                            </table>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Reason</label>
                                <textarea  class="form-control" required name="reason" rows="3" cols="50"></textarea>
                            </div>
                             <div class="card-footer text-right">
                                <button type="submit"  class="btn btn-success" onclick="form_submit(1)" id="submit_button_1">Submit</button>
                                <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                            </div>';
                
            }
            else {
                $output .='<div class="text-center h4 p-3 rounded shadow text-danger"><b>Sorry Godown Stock is empty</b></div>';
            }
            
        }
        else if(!empty($product_info->id)) {
            $branch_info = DB::table('branch_settings')->where(['id'=>$place, 'shop_id'=>$shop_id])->first(['id', 'branch_name']);
            if(!empty($branch_info->id)) {
                
                $branch_product_stock = DB::table('product_stocks')->where(['branch_id'=>$branch_info->id, 'pid'=>$pid])->where('stock', '>', 0)->get();
                if(count($branch_product_stock) > 0) {
                    $output .='
                            <h4 class="text-center text-primary">'.$product_info->p_name.' in '.$branch_info->branch_name.'</h4>
                                <table class="table table-bordered">
                                  <thead>
                                    <tr class="bg-success text-light">
                                      <th width="45%">Info</th>
                                      <th>Stock Qty</th>
                                      <th>Damage Qty</th>
                                    </tr>
                                  </thead>
                                  <tbody id="damage_tbody>';
                                  foreach($branch_product_stock as $stock) {
                                    $variation_name = '';
                                    if($stock->variation_id != 0 && $stock->variation_id != '') {
                                        $variation_info = DB::table('variation_lists')->where(['id'=>$stock->variation_id])->first();
                                        $variation_name =  ' ('.optional($variation_info)->list_title.')';
                                    }
                                    $generate_id = $stock->pid.$stock->id;
                                $output .='<tr id="cart_tr'.$generate_id.'">
                                              <td>
                                                  <input type="hidden" name="pid[]" value="'.$stock->pid.'">
                                                  <input type="hidden" name="lot_number[]" value="'.$stock->lot_number.'">
                                                  <input type="hidden" name="variation_id[]" value="'.$stock->variation_id.'">
                                                  <input type="hidden" name="database_id[]" value="'.$stock->id.'">
                                                  <span class="text-success">'.$product_info->p_name.' '.$variation_name.'</span><br>
                                                  <small><b>Lot Number: </b>'.$stock->lot_number.', <b>Sales Price:</b> '.$stock->sales_price .', <b>Discount:</b> '.$stock->discount.'('.$stock->discount_amount.'), <b>VAT: </b>'.$stock->vat.'%</small>
                                              </td>
                                              <td>
                                                  <input type="number" step="any" value="'.$stock->stock.'" class="form-control" readonly="" id="stock_qty" max="" name="stock_qty[]">
                                              </td>
                                              <td>
                                                <input type="number" step="any" value="" class="form-control" required id="damage_qty" max="'.$stock->stock.'" name="damage_qty[]">
                                                <small class="text-danger">এই লট থেকে ড্যামেজ না দেখাতে চাইলে 0 দিন</small>
                                              </td>
                                            </tr>';
                                  }
                                    
                                  $output .='</tbody>
                                </table>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Reason</label>
                                    <textarea  class="form-control" required name="reason" rows="3" cols="50"></textarea>
                                </div>
                                 <div class="card-footer text-right">
                                    <button type="submit"  class="btn btn-success" onclick="form_submit(1)" id="submit_button_1">Submit</button>
                                    <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                                </div>';
                    
                }
                else {
                    $output .='<div class="text-center h4 p-3 rounded shadow text-danger"><b>Sorry '.$product_info->p_name.' in '.$branch_info->branch_name.' Stock is empty</b></div>';
                }
            
            }
            else {
                $output .='<div class="text-center h4 p-3 rounded shadow text-danger"><b>Error Occoured, Plese try again.</b></div>';
            }
            
           
        }
        return response()->json($output); 
    }

    public function admin_add_damage_product_confirm(Request $request) {
        if(User::checkPermission('admin.damage.product') == true){
            
            $shop_id = Auth::user()->shop_id;
            $pid = $request->pid;
            $place = $request->place;
            $date = Carbon::now();
            if(is_null($pid) && $place != '') {
                return Redirect()->back()->with('error', 'No Product Found! Please try again.');
            }
            
            foreach($pid as $key => $item) {
                $product_id = $pid[$key];
                $damage_qty = $request->damage_qty[$key];
                $database_id = $request->database_id[$key];
                $product_check = Product_stock::Where(['pid'=>$product_id, 'id'=>$database_id])->first();
                if(!is_null($product_check) && $damage_qty > 0 && optional($product_check)->stock > 0) {
                    $db_stock = optional($product_check)->stock;
                    $final_damage_qty = 0;
                    if($damage_qty >= $db_stock) {
                       $final_damage_qty = $db_stock;
                    }
                    else if($db_stock >= $damage_qty) {
                       $final_damage_qty = $damage_qty;
                    }
                    
                    $total_price_of_damage = $final_damage_qty * $product_check->purchase_price;
                   
                   DB::table('product_trackers')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$product_check->purchase_line_id, 'lot_number'=>$product_check->lot_number, 'purchase_price'=>$product_check->purchase_price, 'total_purchase_price'=>$product_check->purchase_price*$final_damage_qty, 'sales_price'=>$product_check->sales_price, 'variation_id'=>$product_check->variation_id, 'branch_id'=>$place, 'product_id'=>$product_check->pid, 'quantity'=>$final_damage_qty, 'price'=>$product_check->purchase_price, 'discount'=>$product_check->discount, 'discount_amount'=>$product_check->discount_amount, 'vat'=>$product_check->vat, 'total_price'=>$total_price_of_damage, 'status'=>0, 'product_form'=>'DM', 'invoice_id'=>'DM', 'note'=>$request->reason, 'created_at'=>$date]);
                   
                   Damage_product::insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$product_check->purchase_line_id, 'lot_number'=>$product_check->lot_number, 'branch_id'=>$place, 'pid'=>$product_id, 'variation_id'=>$product_check->variation_id, 'quantity'=>$final_damage_qty, 'purchase_price'=>$product_check->purchase_price, 'selling_price'=>$product_check->sales_price, 'discount'=>$product_check->discount, 'discount_amount'=>$product_check->discount_amount, 'vat'=>$product_check->vat, 'reason'=>$request->reason, 'date'=>$date, 'created_by'=>Auth::user()->id]);
                   
                   $rest_stock = $db_stock - $final_damage_qty;
                   
                   if($rest_stock == 0) {
                      $product_check->delete(); 
                   }
                   else {
                       $update_product_item = $product_check;
                       $update_product_item->stock = $rest_stock;
                       $update_product_item->update();
                   }
                }
            }
            
            return Redirect()->back()->with('success', 'Damage Product added successfully.');
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }


    public function admin_damage_stock_info() {
        if(User::checkPermission('admin.damage.product') == true){
            $wing = 'main';
            return view('cms.shop_admin.produts.all_damage_product', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function admin_damage_stock_info_data(Request $request)
    {
        if ($request->ajax()) {
            $damaged_data = Damage_product::where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
            return Datatables::of($damaged_data)
                ->addIndexColumn()
                ->addColumn('product_name', function($row){
                    $variation_name = '';
                    if($row->variation_id != 0 && $row->variation_id != '') {
                        $variation_info = DB::table('variation_lists')->where(['id'=>$row->variation_id])->first();
                        $variation_name =  '<span class="text-success fw-bold">('.optional($variation_info)->list_title.')</span>';
                    }
                    $info = optional($row->product_info)->p_name." ".$variation_name."<br><small><b>Lot Number: </b>".$row->lot_number.", <b>Purchase Price:</b> ".$row->purchase_price.", <b>Sales Price:</b> ".$row->selling_price.", <b>Discount:</b> ".$row->discount."(".$row->discount_amount."), <b>VAT: </b>".$row->vat."%</small><br>Barcode: ".optional($row->product_info)->barCode;
                    return $info;
                })
                ->addColumn('place', function($row){
                    $info = '';
                    if($row->branch_id == 'G') {
                        $info .='Godown';
                    }
                    else {
                        $branch_info = DB::table('branch_settings')->where('id', $row->branch_id)->first('branch_name');
                        $info .= $branch_info->branch_name;
                    }
                    return $info;
                })
                ->addColumn('quantity', function($row){
                    $info = $row->quantity." ".$row->product_info->unit_type_name->unit_name;
                    return $info;
                })
                ->addColumn('reason', function($row){
                    $info = '<span class="reason_text">'.optional($row)->reason.'</span>';
                    return $info;
                })
                ->addColumn('date', function($row){
                    $info = date('d-m-Y', strtotime($row->date));
                    return $info;
                })
                
                ->rawColumns(['product_name', 'quantity', 'brand_name', 'reason', 'date'])
                ->make(true);
        }
    }

    //End:: Admin damage products
}
