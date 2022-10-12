<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopSettingController;
use App\Http\Controllers\BranchSettingController;
use App\Http\Controllers\crmController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierInvoiceController;
use App\Http\Controllers\SupplierInvReturnController;
use App\Http\Controllers\GodownController;
use App\Http\Controllers\GodownStockOutInvoiceController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\DeliveryManController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReturnOrderController;
use App\Http\Controllers\TakeCustomerDueController;
use App\Http\Controllers\DamageProductController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\ContraController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LoanPersonController;
use App\Http\Controllers\LoanTransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OwnersController;
use App\Http\Controllers\CapitalTransactionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LedgerHeadController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\SMSSettingsController;
use App\Http\Controllers\SmsHistoryController;
use App\Http\Controllers\SmsRechargeRequestController;
use App\Http\Controllers\IndirectIncomesController;
use App\Http\Controllers\BusinessRenewController;
use App\Http\Controllers\BarcodePrintersController;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BranchToBranchTransferController;
use App\Http\Controllers\BranchToSRproductsTransferController;





Route::get('/inv/{invoice_id}', [OrderController::class, 'public_invoice_show']);
Route::get('/register/reseller', [AdminController::class, 'registration_form_reseller'])->name('reseller.referral.link');


Route::group(['middleware' => 'auth'], function () {

    //Begin:: Super Admin Route ----------------------->
    Route::get('/super-admin/pending-shop', [AdminController::class, 'pending_shop'])->name('super_admin.pending.shop');
    Route::get('/super-admin/pending-shop-data', [AdminController::class, 'pending_shop_data'])->name('super.admin.pending.shop.data');
    
    Route::get('/super-admin/activate-shop/{user_id}', [AdminController::class, 'active_shop_owner'])->name('super.admin.activate.shop');
    Route::get('/super-admin/active-shop', [AdminController::class, 'active_shop'])->name('super_admin.active.shop');
    Route::get('/super-admin/active-shop-data', [AdminController::class, 'active_shop_data'])->name('super.admin.active.shop.data');
    Route::get('/super-admin/deactivate-shop-owner/{user_id}', [AdminController::class, 'deactive_shop_owner'])->name('super.admin.deactive.shop');
    Route::get('/super-admin-shop-info/{shop_id}', [AdminController::class, 'super_admin_shop_info'])->name('super.admin.shop.info');
    Route::post('/super-admin/set-renew-date', [BusinessRenewController::class, 'store'])->name('super.admin.set.renew.date');
    
    
    //super admin tutorials
    Route::get('/super-admin/all-tutorials', [TutorialController::class, 'index'])->name('super_admin.tutorials');
    Route::post('/super-admin/create-tutorials', [TutorialController::class, 'store'])->name('super.admin.create.tutorial');
    Route::get('/super-admin/edit-tutorial/{id}', [TutorialController::class, 'edit']);
    Route::post('/super-admin/update-tutorial/{id}', [TutorialController::class, 'update']);
    
    //super admin Resslers
    Route::get('/super-admin/all-resellers', [AdminController::class, 'resellers'])->name('super_admin.all.reseller');
    Route::get('/super-admin/all-resellers-data', [AdminController::class, 'resellers_data'])->name('super.admin.resellers.data');
    Route::post('/super-admin/store-reseller', [AdminController::class, 'resellers_store'])->name('super.admin.store.reseller');
    Route::get('/super-admin/edit-reseller/{id}', [AdminController::class, 'edit_reseller'])->name('super.admin.edit.reseller');
    Route::post('/super-admin/update-reseller/{id}', [AdminController::class, 'update_reseller'])->name('super.admin.update.reseller');
    Route::get('/reseller-pending-shop', [AdminController::class, 'reseller_pending_shop'])->name('reseller.pending.shop');
    Route::get('/reseller-pending-shop-data', [AdminController::class, 'reseller_pending_shop_data'])->name('reseller.pending.shop.data');
    Route::get('/reseller-active-shop', [AdminController::class, 'reseller_active_shop'])->name('reseller.active.shop');
    Route::get('/reseller-active-shop-data', [AdminController::class, 'reseller_active_shop_data'])->name('reseller.active.shop.data');
    
    Route::get('/reseller-shop-info/{shop_id}', [AdminController::class, 'reseller_shop_info'])->name('reseller.shop.info');
    
    
    
    
    //sms
    Route::get('/super-admin/sms-settings', [SMSSettingsController::class, 'create'])->name('super_admin.sms.settings');
    Route::post('/super-admin/sms-settings-update', [SMSSettingsController::class, 'store'])->name('super.admin.update.sms.settings');
    Route::get('/super-admin/sms-pending-recharge-requests', [SmsRechargeRequestController::class, 'pending_recharge_requests'])->name('super_admin.sms.pending.recharge.requests');
    Route::get('/super-admin/sms-pending-recharge-requests-data', [SmsRechargeRequestController::class, 'pending_recharge_requests_data'])->name('super.admin.sms.pending.recharege.requests.data');
    Route::get('/super-admin/change-sms-recharge-requests-status/{id}', [SmsRechargeRequestController::class, 'super_admin_change_recharge_request_status'])->name('super.admin.change.sms.request.status');
    Route::post('/super-admin/update-sms-recharge-requests-status', [SmsRechargeRequestController::class, 'super_admin_update_recharge_request_status'])->name('super.admin.update.sms.recharge.request.status');
    
    
    
    Route::get('/super-admin/sms-approved-recharge-requests', [SmsRechargeRequestController::class, 'approved_recharge_requests'])->name('super_admin.sms.approved.recharge.requests');
    Route::get('/super-admin/sms-approved-recharge-requests-data', [SmsRechargeRequestController::class, 'approved_recharge_requests_data'])->name('super_admin.sms.approved.recharge.requests.data');
    
    Route::get('/super-admin/sms-history', [SmsHistoryController::class, 'super_admin_sms_history'])->name('super_admin.sms.history');
    Route::get('/super-admin/sms-history-data', [SmsHistoryController::class, 'super_admin_sms_history_data'])->name('super.admin.sms.histories.data');
    
    
    //Route::get('/mail', [AdminController::class, 'send_mail']);
    
    
    

    //End:: Super Admin Route ----------------------->

    Route::get('/', [AdminController::class, 'Dashboard'])->name('/');

    //Begin:: my moments
    Route::get('/my-moments', [AdminController::class, 'my_moments'])->name('my.moments');
    Route::get('/my-moments-date', [AdminController::class, 'my_moments_date'])->name('my.moments.data');
    
    //Begin:: Support
    Route::get('/support', [AdminController::class, 'support'])->name('user.support');
    
    Route::get('/command-new', [BranchSettingController::class, 'new_command']);
    

    //Begin:: Shop Admin Route ----------------------->
    
        //Begin:: demo file download
        Route::get('/download/demo/{file_name}', function($file_name = null){
            $path = public_path().'/demo/'.$file_name;
            if (file_exists($path)) {
                return Response::download($path);
            }
            else {
                return Redirect()->back()->with('error', 'No such file exist, Please try again.');
            }
        })->name('download.demo.file');
        //End:: demo file download
    
    
        //Begin::Admin Shop Setting.
        Route::get('/admin/shop-setting', [ShopSettingController::class, 'index'])->name('admin.shop_setting');
        Route::post('/admin/set-shop-setting', [ShopSettingController::class, 'store'])->name('admin.set.shop_setting');
        Route::post('/admin/set-shop-setting-customer-points', [ShopSettingController::class, 'admin_set_customer_points'])->name('admin.set.shop_setting.customer.point');
        Route::get('/admin/turorials', [ShopSettingController::class, 'shop_admin_tutorials'])->name('admin.tutorials');
        //End::Admin Shop Setting.

        //Begin:: Admin Helper role and permission
        Route::get('/admin/helper-role-permission', [AdminController::class, 'Admin_helper_role_and_permission'])->name('admin.helper_role_permission');
        Route::post('/admin/create-helper-role', [AdminController::class, 'Admin_Create_helper_role'])->name('admin.create.roll');
        Route::get('/admin/edit-admin-role/{id}', [AdminController::class, 'Edit_Admin_helper_role']);
        Route::post('/admin/update-admin-role/{id}', [AdminController::class, 'Update_Admin_helper_role']);
        Route::get('/admin/admin-helper-role-permissions/{id}', [AdminController::class, 'admin_helper_permission']);
        Route::get('/admin/set-permission-to-admin-helper-role', [AdminController::class, 'set_permission_to_admin_helper_role']);
        Route::get('/admin/delete-permission-from-role', [AdminController::class, 'delete_permission_from_role']);
        //End::Admin Helper role and permission

        //Begin::Admin Branch role and permission
        Route::get('/admin/branch-role-permission', [BranchSettingController::class, 'Branch_role_and_permission'])->name('admin.branch.role');
        Route::post('/admin/create-branch-role', [BranchSettingController::class, 'Create_branch_role'])->name('admin.create.branch.roll');
        Route::get('/admin/edit-branch-role/{id}', [BranchSettingController::class, 'Edit_branch_user_role']);
        Route::post('/admin/update-branch-user-role/{id}', [BranchSettingController::class, 'Update_branch_user_role']);
        Route::get('/admin/branch-role-permissions/{id}', [BranchSettingController::class, 'branch_helper_permission']);
        //End::Admin Branch role and permission

        
        //Begin::Admin  Area
        Route::get('/admin/all-area', [AreaController::class, 'index'])->name('admin.all.area');
        Route::get('/admin/all-area-data', [AreaController::class, 'index_data'])->name('admin.all.area.data');
        Route::post('/admin/create-area', [AreaController::class, 'store'])->name('admin.create.area');
        Route::get('/admin/edit-area/{id}', [AreaController::class, 'edit'])->name('admin.edit.area');
        Route::post('/admin/update-area/{id}', [AreaController::class, 'update']);
        //End::Admin  Area

        //Begin::Admin  SR
        Route::get('/admin/all-sr', [crmController::class, 'sr_index'])->name('admin.all.sr');
        Route::get('/admin/all-sr-data', [crmController::class, 'sr_index_data'])->name('admin.all.sr.data');
        Route::post('/admin/create-sr', [crmController::class, 'sr_store'])->name('admin.store.sr');
        Route::get('/admin/edit-sr/{id}', [crmController::class, 'sr_edit'])->name('admin.edit.sr');
        Route::post('/admin/update-sr/{id}', [crmController::class, 'sr_update']);
        //End::Admin  SR

        //Begin::Admin  Branch
        Route::get('/admin/all-branch', [BranchSettingController::class, 'index'])->name('admin.all.branch');
        Route::post('/admin/create-branch', [BranchSettingController::class, 'store'])->name('admin.create.branch');
        Route::get('/admin/edit-branch/{id}', [BranchSettingController::class, 'edit']);
        Route::post('/admin/update-branch/{id}', [BranchSettingController::class, 'update']);
        //End::Admin  Branch

        //Begin::Admin  CRM
        Route::get('/admin/all-crm', [crmController::class, 'index'])->name('admin.crm');
        Route::post('/admin/create-crm', [crmController::class, 'store'])->name('admin.create.crm');
        Route::get('/admin/edit-crm/{id}', [crmController::class, 'edit']);
        Route::post('/admin/update-crm/{id}', [crmController::class, 'update']);
        Route::get('/admin/deactive-crm/{id}', [crmController::class, 'DeactiveCRM']);
        Route::get('/admin/active-crm/{id}', [crmController::class, 'ActiveCRM']);
        Route::post('/admin/reset-crm-password', [crmController::class, 'reset_crm_password'])->name('admin.reset.crm.password');
        //End::Admin  CRM

        //Begin::Admin  Brands
        Route::get('/admin/all-brand', [BrandController::class, 'index'])->name('admin.product.brands');
        Route::post('/admin/create-brand', [BrandController::class, 'store'])->name('admin.create.brand');
        Route::post('/admin/upload-brand-csv', [BrandController::class, 'upload_brand_csv'])->name('admin.upload.brand.csv');
        Route::get('/admin/download-exist-brand', [BrandController::class, 'download_exist_brand'])->name('admin.download.exist.brand');
        Route::get('/admin/edit-brand/{id}', [BrandController::class, 'edit']);
        Route::post('/admin/update-brand/{id}', [BrandController::class, 'update']);
        Route::get('/admin/deactive-brand/{id}', [BrandController::class, 'DeactiveBrand']);
        Route::get('/admin/active-brand/{id}', [BrandController::class, 'ActiveBrand']);
        //End::Admin  Brands
        
        //Begin::Admin  Brands
        Route::get('/admin/all-variations', [ProductVariationController::class, 'index'])->name('admin.product.variations');
        Route::post('/admin/store-variation', [ProductVariationController::class, 'store'])->name('store.product.variations');
        // Route::post('/admin/upload-brand-csv', [BrandController::class, 'upload_brand_csv'])->name('admin.upload.brand.csv');
        // Route::get('/admin/download-exist-brand', [BrandController::class, 'download_exist_brand'])->name('admin.download.exist.brand');
        Route::get('/admin/edit-variation/{id}', [ProductVariationController::class, 'edit']);
        Route::post('/admin/update_variation/{id}', [ProductVariationController::class, 'update'])->name('update.product.variations');
        Route::post('/admin/store-variation-item', [ProductVariationController::class, 'store_variation_item'])->name('store.variations.item');
        Route::get('/admin/edit-variation-item/{id}', [ProductVariationController::class, 'edit_item']);
        Route::post('/admin/update_variation_item/{id}', [ProductVariationController::class, 'update_item'])->name('update.product.variation.item');
        // Route::post('/admin/update-brand/{id}', [BrandController::class, 'update']);
        // Route::get('/admin/deactive-brand/{id}', [BrandController::class, 'DeactiveBrand']);
        // Route::get('/admin/active-brand/{id}', [BrandController::class, 'ActiveBrand']);
        //End::Admin  Brands
        
        

        //Begin::Admin  Categories
        Route::get('/admin/all-categories', [CategoryController::class, 'index'])->name('admin.product.categories');
        Route::post('/admin/create-category', [CategoryController::class, 'store'])->name('admin.create.category');
        Route::post('/admin/upload-category-csv', [CategoryController::class, 'upload_category_csv'])->name('admin.upload.category.csv');
        Route::get('/admin/download-exist-categories', [CategoryController::class, 'download_exist_categories'])->name('admin.download.exist.categories');
        Route::get('/admin/edit-category/{id}', [CategoryController::class, 'edit']);
        Route::post('/admin/update-category/{id}', [CategoryController::class, 'update']);
        Route::get('/admin/deactive-category/{id}', [CategoryController::class, 'DeactiveCategory']);
        Route::get('/admin/active-category/{id}', [CategoryController::class, 'ActiveCategory']);
        //End::Admin  Categories

        //Begin::Admin  Unit Types
        Route::get('/admin/all-unit-types', [UnitTypeController::class, 'index'])->name('admin.product.unit_types');
        Route::post('/admin/create-unit-type', [UnitTypeController::class, 'store'])->name('admin.create.unit-type');
        Route::post('/admin/upload-unit-type-csv', [UnitTypeController::class, 'upload_unit_type_csv'])->name('admin.upload.unit.type.csv');
        Route::get('/admin/download-exist-unit-types', [UnitTypeController::class, 'download_exist_unit_types'])->name('admin.download.exist.unit.types');
        Route::get('/admin/edit-unit-type/{id}', [UnitTypeController::class, 'edit']);
        Route::post('/admin/update-unit-type/{id}', [UnitTypeController::class, 'update']);
        Route::get('/admin/deactive-unit-type/{id}', [UnitTypeController::class, 'DeactiveUnitType']);
        Route::get('/admin/active-unit-type/{id}', [UnitTypeController::class, 'ActiveUnitType']);
        //End::Admin  Unit Types

        //Begin::Admin  Products
        Route::get('/admin/all-product', [ProductController::class, 'index'])->name('admin.product.all');
        Route::get('/admin/all-product-data', [ProductController::class, 'all_product_data'])->name('admin.product.all.data');
        Route::get('/admin/product-add', [ProductController::class, 'create'])->name('admin.product.add');
        Route::get('/admin/check-product-barcode', [ProductController::class, 'Check_barcode']);
        Route::post('/admin/create-product-confirm', [ProductController::class, 'store'])->name('admin.product.add.confirm');
        Route::get('/admin/edit-product/{id}', [ProductController::class, 'edit']);
        Route::post('/admin/update-product/{id}', [ProductController::class, 'update']);
        Route::get('/admin/deactive-product/{id}', [ProductController::class, 'DeactiveProduct']);
        Route::get('/admin/active-product/{id}', [ProductController::class, 'ActiveProduct']);
        Route::get('/admin/product-barcode', [ProductController::class, 'Barcode'])->name('admin.product.barcode');
        Route::post('/admin/product-barcode-print', [ProductController::class, 'PrintBarcode'])->name('admin.print.barcode');
        Route::get('/admin/product-csv-upload', [ProductController::class, 'csvUpload'])->name('admin.product.csv.upload');
        Route::post('/admin/product-csv-upload-confrim', [ProductController::class, 'csvUpload_confirm'])->name('admin.product.csv.upload.confirm');
        Route::get('/admin/download-exist-products', [ProductController::class, 'admin_download_exist_products'])->name('admin.download.exist.products');
        //End::Admin  Products
        
        //Begin::Admin  Products Barcode Level
        Route::get('/admin/product-barcode-level-printers', [BarcodePrintersController::class, 'index'])->name('admin.product.barcode.printers');
        Route::get('/admin/add-product-barcode-level-printer', [BarcodePrintersController::class, 'create'])->name('admin.product.add.barcode.level.printer');
        Route::get('/admin/products-barcode-test-print', function() {
            return view('cms.shop_admin.produts.test_barcode_print');
        })->name('admin.product.print.test.barcode');
        Route::post('/admin/store-product-barcode-level-printer', [BarcodePrintersController::class, 'store'])->name('admin.product.store.barcode.level.printer');
        Route::get('/admin/edit-product-barcode-level-printer/{id}', [BarcodePrintersController::class, 'edit'])->name('admin.product.edit.barcode.level.printer');
        //Begin::Admin  Products Barcode Level
        

        //Begin::Admin  Products stock summery
        Route::get('/admin/{id}/prodcut-summery', [ProductStockController::class, 'product_stock_summery'])->name('admin.product.stock.summery');
        Route::get('/admin/view-product-lot-info/{id}', [ProductStockController::class, 'view_product_lot_info']);
        
        Route::get('/admin/prodcut-summery-data/{pid}', [ProductStockController::class, 'product_stock_in_out_summery_data'])->name('admin.product.stock.in.out.summery.data');
        Route::get('/admin/prodcut-summery-data-from-trackers/{pid}', [ProductStockController::class, 'product_summery_data']);
        
        Route::get('/admin/adjust-product-stock/{id}', [ProductStockController::class, 'product_stock_adjust'])->name('admin.adjust.product.stock');
        //End::Admin  Products stock summery

        //Begin:: Admin damage products
        Route::get('/admin/damage-products', [DamageProductController::class, 'admin_damage_product_index'])->name('admin.damage.products');
        Route::get('/admin/add-damage-products-data', [DamageProductController::class, 'admin_damage_product_index_data'])->name('admin.add.damage.products.data');
        Route::get('/admin/add-damage-product-info', [DamageProductController::class, 'admin_add_damage_godown_and_branch_stock_info']);
        Route::post('/admin/add-damage-product-confirm', [DamageProductController::class, 'admin_add_damage_product_confirm'])->name('admin.add.damage.product.confirm');
        Route::get('/admin/damage-stock-info', [DamageProductController::class, 'admin_damage_stock_info'])->name('admin.damage.stock.info');
        Route::get('/admin/damage-stock-data', [DamageProductController::class, 'admin_damage_stock_info_data'])->name('admin.all.damaged.product.data');
        //End:: Admin damage products

        //Begin::BRanch to branch Transfer
        Route::get('/admin/products/branch-to-branch-transfer', [BranchToBranchTransferController::class, 'create'])->name('admin.products.btob');
        Route::get('/admin/products/branch-to-branch-transfer/search_products', [BranchToBranchTransferController::class, 'get_products_search_by_title_into_branh_to_branch_transfer']);
        Route::post('/admin/products/branch-to-branch-transfer/store', [BranchToBranchTransferController::class, 'store'])->name('branch.to.branch.transfer.comfirm');
        Route::get('/admin/products/branch-to-branch-transfer-invoices', [BranchToBranchTransferController::class, 'index'])->name('admin.products.btob.invoices');
        Route::get('/admin/products/branch-to-branch-transfer-invoices_data', [BranchToBranchTransferController::class, 'index_data'])->name('admin.products.btob.invoices.data');
        
        //End::BRanch to branch Transfer

        //BEgin::Admin & Branch Product stocks
        Route::get('/admin/branch-product-stocks', [ProductController::class, 'branch_and_godown_product_stock'])->name('admin.branch.product.stock');
        Route::get('/admin/product/stock-data/{place}/{active_or_empty}', [ProductController::class, 'branch_and_godown_product_stock_data']);
        Route::get('/admin/product/stock-value', [ProductController::class, 'branch_and_godown_product_stock_value']);
        Route::post('/admin/product/current-stock-data/print', [ProductController::class, 'branch_and_godown_product_stock_data_print'])->name('admin.report.products.current.stock.print');
        Route::get('/stock/change-product-stock-info/{id}', [ProductController::class, 'change_stock_info']);
        Route::post('/stock/change_product_stock_info_confirm', [ProductController::class, 'change_stock_info_confirm'])->name('stock.change.product.stock.info.confirm');
        
        
        //End::Admin & Branch Product stocks

        //Begin:: Admin Set Product Opening & Own Products stocks view
        Route::get('/admin/opening-and-own-stock', [ProductController::class, 'set_opening_and_own_stock'])->name('admin.set.opening.and.own.stock');
        Route::get('/admin/get_products_search_by_title_into_own_stock_new', [ProductController::class, 'get_products_search_by_title_into_own_stock_new']);
        Route::get('/admin/opening-stock', [ProductController::class, 'set_opening_stock_new'])->name('admin.set.opening.stock');
        Route::get('/admin/get_products_search_by_title_into_opening_stock_new', [ProductController::class, 'get_products_search_by_title_into_opening_stock_new']);
        Route::get('/admin/opening-and-own-stock-data', [ProductController::class, 'set_opening_and_own_stock_data'])->name('admin.set.opening.and.own.stock.data');
        Route::get('/admin/set-own-stock', [ProductController::class, 'set_own_stock']);
        Route::post('/admin/set-own-stock-confirm', [ProductController::class, 'set_own_stock_confirm'])->name('set.own.stock.confirm');
        Route::get('/admin/download-csv-for-set-own-stock', [ProductController::class, 'download_csv_for_set_own_stock'])->name('admin.download.csv.for.set.own.stock');
        Route::post('/admin/download-csv-for-set-own-stock-confirm', [ProductController::class, 'admin_update_own_stock_by_csv_confirm'])->name('admin.download.csv.for.set.own.stock.confirm');
        Route::get('/admin/set-opening-stock', [ProductController::class, 'set_opening_stock']);
        Route::post('/admin/set-opening-stock-confirm', [ProductController::class, 'set_opening_stock_confirm'])->name('set.opening.stock.confirm');
        Route::post('/admin/download-opening-stock-csv', [ProductController::class, 'admin_download_opening_stock_csv'])->name('admin.download.opening.stock.csv');
        Route::post('/admin/opening-stock-csv-confirm', [ProductController::class, 'admin_opening_stock_csv_upload_confirm'])->name('admin.opening.stock.csv.confirm');
        //End:: Admin Set Product Opening & Own Products stocks view

        // Product Ledger Table
        Route::get('/admin/products-ledger-table', [ProductController::class, 'products_ledger_table'])->name('admin.product.ledger.table');

        

        //Begin:: Delivery man
        Route::get('/admin/all-deliveryman', [DeliveryManController::class, 'index'])->name('admin.all.deliveryman');
        Route::post('/admin/create-deliveryman', [DeliveryManController::class, 'store'])->name('admin.create.deliveryMan');
        Route::get('/admin/edit-deliveryMan/{id}', [DeliveryManController::class, 'edit']);
        Route::post('/admin/update-deliveryman/{id}', [DeliveryManController::class, 'update']);
        Route::get('/admin/deactive-deliveryMan/{id}', [DeliveryManController::class, 'deactiveDeliveryMan']);
        Route::get('/admin/active-deliveryMan/{id}', [DeliveryManController::class, 'activeDeliveryMan']);
        //End:: Delivery man

        //Begin:: Customers
        Route::get('/admin/all-customers', [CustomerController::class, 'admin_customers'])->name('admin.customers');
        Route::get('/admin/all-customers-data', [CustomerController::class, 'admin_customers_data'])->name('admin.customers.data');
        Route::get('/admin/doanload-exist-customers', [CustomerController::class, 'admin_download_exist_customers'])->name('admin.download.exist.customers');
        Route::get('/admin/create-customer', [CustomerController::class, 'admin_create_customer'])->name('admin.customer.create');
        Route::post('/admin/create-customer-confirm', [CustomerController::class, 'admin_create_customer_confirm'])->name('admin.add.customer.confirm');
        Route::post('/admin/upload-customer-csv-confirm', [CustomerController::class, 'upload_customer_csv_confirm'])->name('admin.upload.customer.csv');
        
        Route::get('/admin/edit-customers-data/{id}', [CustomerController::class, 'admin_edit_customer'])->name('admin.edit.customer');
        Route::post('/admin/update-customer/{id}', [CustomerController::class, 'admin_update_customer']);
        Route::get('/admin/{customer_code}/customer-due-received', [TakeCustomerDueController::class, 'admin_customers_due_received'])->name('admin.customer.due.received');
        Route::get('/admin/take-due/search-customer', [TakeCustomerDueController::class, 'admin_take_due_search_customers']);
        Route::post('/admin/customer-due-received-confirm', [TakeCustomerDueController::class, 'admin_received_customer_due_confirm'])->name('admin.received.customer.due.confirm');
        Route::get('/admin/customer-due-received-vouchers', [TakeCustomerDueController::class, 'admin_customer_due_received_vouchers'])->name('admin.customer.due.received.vouchers');
        Route::get('/admin/customer-due-received-vouchers-data', [TakeCustomerDueController::class, 'admin_customer_due_received_vouchers_data'])->name('admin.customer.due.received.vouchers.data');
        Route::get('/admin/view/{voucher_num}/customer-due-received-vouchers-info', [TakeCustomerDueController::class, 'admin_view_customer_due_received_voucher_info'])->name('admin.view.customer.due.received.voucher');
        //End:: Customers

        //Begin:: Customer Types
        Route::get('/admin/customer-types', [CustomerTypeController::class, 'index'])->name('admin.all.customer.types');
        Route::post('/admin/create-customer-types', [CustomerTypeController::class, 'store'])->name('admin.create.customer.type');
        Route::get('/admin/edit-customer-type/{id}', [CustomerTypeController::class, 'edit']);
        Route::post('/admin/update-customer-type/{id}', [CustomerTypeController::class, 'update']);
        Route::get('/admin/deactive-customer-type/{id}', [CustomerTypeController::class, 'deactiveCustomer_type']);
        Route::get('/admin/active-customer-type/{id}', [CustomerTypeController::class, 'active_customer_type']);
        //End:: Customer Types

       

        


        
        

        

        

        

        

        

        
        

    //End:: Shop Admin Route ------------------------->


    // Begin:: Shop Supplier Route ---------------------->
        Route::get('/admin/supplier', [AdminController::class, 'supplierDashboard'])->name('admin.supplier.wing');

        //Begin:: Suppliers CRUD
        Route::get('/admin/supplier/all', [SupplierController::class, 'index'])->name('suppliers.all');
        Route::post('/admin/supplier-create-new', [SupplierController::class, 'store'])->name('suppliers.create.supplier');
        Route::get('/supplier/edit-supplier/{id}', [SupplierController::class, 'edit']);
        Route::post('/supplier/update-supplier/{id}', [SupplierController::class, 'update']);
        Route::get('/supplier/deactive-supplier/{id}', [SupplierController::class, 'deactiveSupplier']);
        Route::get('/supplier/active-supplier/{id}', [SupplierController::class, 'activeSupplier']);
        
        Route::post('/admin/supplier-upload-csv', [SupplierController::class, 'upload_supplier_csv_confirm'])->name('admin.upload.supplier.csv');
        Route::get('/admin/download-exist-suppliers', [SupplierController::class, 'admin_download_exist_supplier'])->name('admin.download.exist.supplier');
        
        //End:: Suppliers CRUD
        
        //Begin:: Suppliers Stock In New
        Route::get('/supplier/{code}/stock-in-new', [SupplierController::class, 'supplier_stock_in_new'])->name('suppliers.stock.in.new');
        Route::get('/supplier/product-purchase/search-product-by-title_new', [SupplierController::class, 'get_products_search_by_title_into_purchase_new']);
        Route::post('/supplier/stock-in-new/confirm', [SupplierController::class, 'supplier_stock_in_confirm_new'])->name('supplier.stock.in.new.confirm');
        Route::get('/supplier/product-purchase-search-barcode_new', [SupplierController::class, 'supplier_product_purchase_search_barcode_new']);
        //End:: Suppliers Stock In New
        
        
        //Begin:: Suppliers Stock In
        Route::get('/supplier/{code}/stock-in', [SupplierController::class, 'supplier_stock_in'])->name('suppliers.stock.in');
        Route::get('/supplier/product-purchase-search-barcode', [SupplierController::class, 'supplier_product_purchase_search_barcode']);
        Route::get('/supplier/product-purchase/search-product-by-title', [SupplierController::class, 'get_products_search_by_title_into_purchase']);
        Route::post('/supplier/stock-in/confirm', [SupplierController::class, 'supplier_stock_in_confirm'])->name('supplier.stock.in.confirm');
        Route::get('/supplier/stock-in/search-supplier', [SupplierController::class, 'supplier_search'])->name('supplier.supplier.search');
        Route::get('/supplier/stock-in-invoices', [SupplierInvoiceController::class, 'index'])->name('supplier.stock.in.invoices');
        Route::get('/supplier/stock-in-invoices-data', [SupplierInvoiceController::class, 'supplier_invoice_data'])->name('supplier.stock.in.invoices.data');
        
        Route::get('/supplier/all-stock-in-invoices', [SupplierInvoiceController::class, 'supplier_all_invoice'])->name('supplier.all.stock.in.invoices');
        Route::get('/supplier/all-stock-in-invoices-data', [SupplierInvoiceController::class, 'supplier_all_invoice_data']);
        
        
        Route::get('/supplier/stock-in/{invoice_id}/view-invoice', [SupplierInvoiceController::class, 'show'])->name('supplier.stock.in.view.invoice');
        Route::get('/supplier/stock-in-invoice-for-return', [SupplierInvoiceController::class, 'all_invoice_for_edit'])->name('supplier.stock.in.invoices.for.return');
        Route::get('/supplier/stock-in-invoice-for-return-data', [SupplierInvoiceController::class, 'all_invoice_for_edit_data'])->name('supplier.stock.in.invoices.for.return.data');
        
        Route::get('/supplier/{id}/invoice-product-return', [SupplierInvoiceController::class, 'edit'])->name('supplier.invoice.return');
        Route::get('/admin/supplier/return-product-place', [SupplierInvoiceController::class, 'supplier_product_return_place']);
        
        // Supplier Return New ---------------------------------------------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        Route::get('/supplier/{id}/invoice-product-return-new', [SupplierInvoiceController::class, 'edit_new'])->name('supplier.invoice.return.new');
        Route::get('/admin/supplier/return_product_place_new', [SupplierInvoiceController::class, 'supplier_product_return_place_new']);
        Route::post('/supplier/invoice-product-return-confirm-new', [SupplierInvoiceController::class, 'update_new'])->name('supplier.invoice.return.confirm.new');
        
            //supplier direct return New
            Route::get('/supplier/direct-return/products-new', [SupplierInvReturnController::class, 'supplier_direct_return_new'])->name('supplier.direct.return.products.new');
            Route::get('/supplier/product-searchby-title/direct_return_new', [SupplierInvReturnController::class, 'get_products_search_by_title_new']);
            Route::get('/supplier/product_info_from_barcode_direct_return_new', [SupplierInvReturnController::class, 'get_product_info_from_barcode_new']);
            Route::post('/supplier/direct-return/products-confirm-new', [SupplierInvReturnController::class, 'supplier_direct_product_return_confirm_new'])->name('supplier.direct.return.products.confirm.new');
            
            //supplier direct return New
        // Supplier Return New ---------------------------------------------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        
        Route::post('/supplier/invoice-product-return-confirm', [SupplierInvoiceController::class, 'update'])->name('supplier.invoice.return.confirm');
        Route::get('/supplier/all-returned-invoices', [SupplierInvReturnController::class, 'index'])->name('supplier.all.returned.invoices');
        Route::get('/supplier/all-returned-invoices-data', [SupplierInvReturnController::class, 'supplier_return_product_invoice_data'])->name('supplier.all.returned.invoices.data');
        
        Route::get('/supplier/{id}/{how_many_times_edit}/returned-invoice-view', [SupplierInvReturnController::class, 'show'])->name('supplier.returned.invoice.view');
        
            //supplier direct return
            Route::get('/supplier/direct-return/products', [SupplierInvReturnController::class, 'supplier_direct_return'])->name('supplier.direct.return.products');
            Route::get('/supplier/direct-stock-out/search-supplier', [SupplierInvReturnController::class, 'search_supplier_for_direct_return']);
            Route::get('/supplier/product-info-from-barcode', [SupplierInvReturnController::class, 'get_product_info_from_barcode']);
            Route::get('/supplier/product-searchby-title/direct-return', [SupplierInvReturnController::class, 'get_products_search_by_title']);
            Route::post('/supplier/direct-return/products-confirm', [SupplierInvReturnController::class, 'supplier_direct_product_return_confirm'])->name('supplier.direct.return.products.confirm');
            
            
        //End:: Suppliers Stock In
        
        
        
        

        //Begin:: Suppliers Report
        Route::get('/supplier/supplier-all-reports', [SupplierController::class, 'supplier_report_all'])->name('supplier.all.reports');
        Route::get('/supplier/{supplier_id}/supplier-product-reports', [SupplierController::class, 'supplier_product_report'])->name('supplier.products.report');
        Route::get('/supplier/supplier-product-reports-data/{supplier_id}', [SupplierController::class, 'supplier_product_report_data'])->name('supplier.products.report.data');
        Route::get('/supplier/supplier-table-ledger', [SupplierController::class, 'supplier_table_ledger'])->name('supplier.table.ledger');
        Route::get('/supplier/supplier_table_ledger_data', [SupplierController::class, 'supplier_table_ledger_data']);
        
        Route::get('/supplier/{code}/supplier-group-porduct-ledger', [SupplierController::class, 'supplier_grout_product_ledger'])->name('supplier.grout.product.ledger');
        //End:: Supplier Report

        //Begin:: supplier Payment
        Route::get('/admin/{supplier_code}/supplier-payment', [SupplierPaymentController::class, 'create'])->name('admin.supplier.payment');
        Route::get('/admin/supplier-payment/search-supplier', [SupplierPaymentController::class, 'admin_search_supplier_to_pay']);
        Route::get('/admin/supplier-payment/change-bank/', [SupplierPaymentController::class, 'admin_supplier_payment_change_bank']);
        Route::post('/admin/supplier-payment-confirm', [SupplierPaymentController::class, 'store'])->name('admin.supplier.payment.confirm');
        Route::get('/admin/supplier-payment/vouchers', [SupplierPaymentController::class, 'index'])->name('admin.supplier.payment.vouchers');
        Route::get('/admin/supplier-payment/vouchers-data', [SupplierPaymentController::class, 'supplier_payment_vouchers_data'])->name('admin.supplier.payment.vouchers.data');
        Route::get('/admin/{voucher_num}/view-supplier-payment-voucher', [SupplierPaymentController::class, 'show'])->name('view.supplier.payment.voucher');
        //End:: supplier Payment
        
        
        
        

    // End:: Shop Supplier Route ---------------------->

        // Begin:: Shop Godown Route ---------------------->
        Route::get('/admin/godown', [AdminController::class, 'godownDashboard'])->name('admin.godown.wing');

        //Begin:: Godown Stock
        Route::get('/godown/current-stock-info', [GodownController::class, 'godown_current_stock'])->name('godown.current.stock.info');
        Route::get('/godown/stock-out', [GodownStockOutInvoiceController::class, 'create'])->name('godown.stock.out');
        Route::post('/godown/stock-out-confirm', [GodownStockOutInvoiceController::class, 'store'])->name('godown.stock.out.confirm');
        Route::get('/godown/stock-out-invoices', [GodownStockOutInvoiceController::class, 'index'])->name('godown.stock.out.invoices');
        Route::get('/godown/{invoice_id}/stock-out-invoice-view', [GodownStockOutInvoiceController::class, 'show'])->name('godown.stock.out.view.invoice');
        Route::get('/godown/stock-in-out-report', [GodownStockOutInvoiceController::class, 'godown_stock_in_out_report'])->name('godown.stock.out.report');
        Route::get('/godown/{id}/stock-in-out-summery/{code}', [GodownStockOutInvoiceController::class, 'godown_stock_in_out_summery_of_individual_product'])->name('godown.stock.in.out.summery');
        Route::get('/admin/report/godowns-product-in-out-summery-data', [GodownStockOutInvoiceController::class, 'godown_product_stock_in_out_summery_data']);
        Route::get('/godown/stock-in-out-ledger', [GodownStockOutInvoiceController::class, 'godown_stock_in_out_ledger'])->name('godown.stock.in.out.ledger');
        Route::get('/admin/report/godowns-stock-in-out-ledger-data', [GodownStockOutInvoiceController::class, 'godown_stock_in_out_ledger_data']);
        
        
        // Godown Stock Transfer New ---------------------------------------------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        Route::get('/godown/stock-out-new', [GodownStockOutInvoiceController::class, 'create_new'])->name('godown.stock.out.new');
        Route::get('/godown/stock-out/search-product-by-title_new', [GodownStockOutInvoiceController::class, 'get_products_search_by_title_into_stock_out']);
        Route::get('/godown/stock-out/product_search_by_barcode_new', [GodownStockOutInvoiceController::class, 'product_search_by_barcode_new']);
        Route::post('/godown/stock-out-confirm-new', [GodownStockOutInvoiceController::class, 'store_new'])->name('godown.stock.out.confirm.new');
        
        // Godown Stock Transfer New ---------------------------------------------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        
        //End:: Godown Stock

    // End:: Shop Godown Route ---------------------->

    // Begin:: Shop Account and transaction Route ---------------------->

        // Begin:: Account transaction Route ---------------------->
        Route::get('/admin/account/transaction', [AdminController::class, 'account_transaction_Dashboard'])->name('admin.account.transaction.wing');
        Route::get('/admin/report/header-balance-statements', [ReportController::class, 'admin_header_show_balance_statements']);
        

        //Begin:: Banks CRUD
        Route::get('/admin/account-transaction/banks', [BankController::class, 'index'])->name('admin.account.transaction.bank');
        Route::post('/admin/account-transaction/create-banks', [BankController::class, 'store'])->name('admin.create.new.bank');
        Route::get('/admin/account-transaction/{id}/edit-banks', [BankController::class, 'edit'])->name('admin.account.transaction.edit.bank');
        Route::post('/admin/account-transaction/{id}/update-bank', [BankController::class, 'update']);
        //End:: Banks CRUD

        //Begin::Contra
        Route::get('/admin/account/contra', [ContraController::class, 'create'])->name('admin.account.contra');
        Route::post('/admin/account/contra', [ContraController::class, 'store'])->name('admin.contra.confirm');
        Route::get('/admin/account/contra-list', [ContraController::class, 'index'])->name('admin.contra.list');
        Route::get('/admin/account/contra-list-data', [ContraController::class, 'contra_list_data'])->name('admin.contra.list.data');
        //End::Contra

        //Begin:: Loan Person
        Route::get('/admin/account-loan/person', [LoanPersonController::class, 'index'])->name('admin.account.loan.person');
        Route::post('/admin/add-new-loan-person', [LoanPersonController::class, 'store'])->name('admin.create.new.loan.person');
        Route::get('/admin/{id}/edit-loan-person', [LoanPersonController::class, 'edit'])->name('admin.edit.loan.person');
        Route::post('/admin/edit-loan-person/{id}', [LoanPersonController::class, 'update']);
        Route::get('/admin/account/loan-paid', [LoanTransactionController::class, 'create'])->name('admin.account.loan.paid');
        Route::get('/admin/lender-search', [LoanTransactionController::class, 'search_lender']);
        Route::get('/admin/lender-search-check', [LoanTransactionController::class, 'search_lender']);
        Route::post('/admin/account/loan-paid-confirm', [LoanTransactionController::class, 'loan_paid_confirm'])->name('admin.loan.paid.confirm');
        Route::get('/admin/account/loan-receive', [LoanTransactionController::class, 'loan_receive'])->name('admin.account.loan.receive');
        Route::post('/admin/account/loan-receive-confirm', [LoanTransactionController::class, 'loan_receive_confirm'])->name('admin.loan.receive.confirm');
        Route::get('/admin/account/loan-history', [LoanTransactionController::class, 'index'])->name('admin.account.loan.history');
        Route::get('/admin/account/loan-history-data', [LoanTransactionController::class, 'loan_history_data'])->name('admin.account.loan.history.data');
        //End:: Loan Person

        //Begin:: Capital 
        Route::get('/admin/account-capital/person', [OwnersController::class, 'index'])->name('admin.account.capital.person');
        Route::post('/admin/add-new-capital-person', [OwnersController::class, 'store'])->name('admin.create.new.capital.person');
        Route::get('/admin/{id}/edit-capital-person', [OwnersController::class, 'edit'])->name('admin.edit.capital.person');
        Route::post('/admin/edit-capital-person/{id}', [OwnersController::class, 'update']);
        Route::get('/admin/account/capital-withdraw', [CapitalTransactionController::class, 'capital_withdraw'])->name('admin.account.capital.withdraw');
        Route::post('/admin/account/capital-withdraw-confirm', [CapitalTransactionController::class, 'capital_withdraw_confirm'])->name('admin.capital.withdraw.confirm');
        Route::get('/admin/account/capital-receive', [CapitalTransactionController::class, 'capital_receive'])->name('admin.account.capital.receive');
        Route::post('/admin/account/capital-receive-confirm', [CapitalTransactionController::class, 'capital_receive_confirm'])->name('admin.capital.receive.confirm');
        Route::get('/admin/account/capital-history', [CapitalTransactionController::class, 'index'])->name('admin.account.capital.history');
        Route::get('/admin/account/capital-history-data', [CapitalTransactionController::class, 'capital_history_data'])->name('admin.account.capital.history.data');
        //End:: Capital

        //Begin:: Expense 
        Route::get('/admin/account-expense/group', [ExpenseController::class, 'expense_group'])->name('admin.account.expense.group');
        Route::get('/admin/account-ledger-heads', [LedgerHeadController::class, 'index'])->name('admin.account.ledger.heads');
        Route::post('/admin/account-ledger-heads-create', [LedgerHeadController::class, 'store'])->name('admin.create.ledger.head');
        Route::get('/admin/edit-ledger-head/{id}', [LedgerHeadController::class, 'edit'])->name('admin.edit.ledger.head');
        Route::post('/admin/update-ledger-head/{id}', [LedgerHeadController::class, 'update']);
        Route::get('/admin/account/make-expense-entry', [ExpenseController::class, 'make_expense_entry'])->name('admin.make.expense.entry');
        Route::post('/admin/account/expense-entry-confirm', [ExpenseController::class, 'make_expense_entry_confirm'])->name('admin.expense.entry.confirm');
        Route::get('/admin/account/expenses-vouchers', [ExpenseController::class, 'expenses_vouchers'])->name('admin.expense.vouchers');
        Route::get('/admin/account/expenses-vouchers-data', [ExpenseController::class, 'expenses_vouchers_data'])->name('admin.account.expenses.vouchers.data');
        Route::get('/admin/account/{voucher_num}/expenses-vouchers-view', [ExpenseController::class, 'expenses_voucher_view'])->name('admin.account.expenses.voucher.view');
        //End:: Expense
        
        //Begin:: Indirect Incomes 
        Route::get('/admin/account-indirect-income/add', [IndirectIncomesController::class, 'create'])->name('admin.add.indirect.incomes');
        Route::post('/admin/account-indirect-income/add-confirm', [IndirectIncomesController::class, 'store'])->name('admin.add.indirect.income.confirm');
        Route::get('/admin/account-indirect-income/vouchers', [IndirectIncomesController::class, 'index'])->name('admin.indirect.incomes.history');
        Route::get('/admin/account-indirect-income/-voucher-data', [IndirectIncomesController::class, 'indirect_income_vouchers_data'])->name('admin.indirect.incomes.voucher.data');
        
        Route::get('/admin/account-indirect-income/-voucher/{voucher_num}', [IndirectIncomesController::class, 'show'])->name('admin.indirect.incomes.voucher');
        
        
        //End:: Indirect Incomes
        
        


        //Begin:: Account Report
        Route::get('/admin/account/cash-flow', [TransactionController::class, 'index'])->name('admin.account.cash.flow');
        Route::get('/admin/account/cash-flow-data/{type}', [TransactionController::class, 'cash_flow_data'])->name('admin.cash.flow.data');
        Route::post('/admin/account/transaction-history-print', [TransactionController::class, 'transaction_history_print'])->name('admin.report.print.transaction.history');
        
        Route::get('/admin/account/cash-flow-diagram', [TransactionController::class, 'cash_flow_diagram'])->name('admin.account.cash.flow.diagram');
        Route::get('/admin/account/cash_flow_diagram_data', [TransactionController::class, 'cash_flow_diagram_data']);
        

        Route::get('/admin/users-moments', [ReportController::class, 'all_user_moments'])->name('admin.all.user.moments');
        Route::get('/admin/users-moments-data', [ReportController::class, 'all_user_moments_data'])->name('admin.all.users.moments.data');
        Route::get('/admin/report-all-customers', [ReportController::class, 'admin_report_all_customers'])->name('admin.report.all.customers');
        Route::get('/admin/customer-report-customer-info/{customer_type}', [ReportController::class, 'all_or_due_customers_data']);
        Route::post('/admin/print-all-or-due-customers', [ReportController::class, 'print_all_customers_or_due_custoers'])->name('admin.report.print.all.or.due.custoemrs');
        Route::get('/admin/report-suppliers', [ReportController::class, 'admin_report_suppliers'])->name('admin.report.all.suppliers');
        Route::get('/admin/supplier-report-supplier-info/{supplier_type}', [ReportController::class, 'all_or_due_suppliers_data']);
        Route::post('/admin/print-all-or-due-suppliers', [ReportController::class, 'print_all_suppliers_or_due_suppliers'])->name('admin.report.print.all.or.due.suppliers');
        Route::get('/admin/sales-report-by-product', [ReportController::class, 'sales_report_by_product'])->name('sales.report.by.product');
        Route::get('/admin/report/sales-report-by-product-data', [ReportController::class, 'sales_report_by_product_data']);
        Route::get('/admin/best-selling-products', [ReportController::class, 'best_selling_products'])->name('best.selling.products');
        Route::get('/admin/report/best-selling-product-data', [ReportController::class, 'best_selling_products_data']);
        Route::get('/admin/sales-report', [ReportController::class, 'only_sales_report'])->name('sales.report.only');
        Route::get('/admin/sales_report_date_range', [ReportController::class, 'only_sales_report_in_date_range']);
        
        
        
        
        
        //Report:: Day Book
        Route::get('/admin/account/report-day-book', [ReportController::class, 'day_book'])->name('admin.account.report.day.book');
        Route::get('/admin/report/day-book-data', [ReportController::class, 'day_book_data']);
        //Report:: Day Book

        //Report:: Trial Balance
        Route::get('/admin/account/report-trial-balance', [ReportController::class, 'trial_balance'])->name('admin.account.report.trial.balance');
        Route::get('/admin/report/trial-balance-data', [ReportController::class, 'trial_balance_data']);
        //Report:: Trial Balance
        
        //Report:: Income & Expenditure
        Route::get('/admin/account/report-income-expenditure', [ReportController::class, 'income_and_expenditure'])->name('admin.account.income.and.expenditure');
        Route::get('/admin/report/income-expenditure-data', [ReportController::class, 'income_and_expenditure_data']);
        //Report:: Income & Expenditure
        
        

        

        //Customer Ledger Table
        Route::get('/{code}/customer-ledger-table', [ReportController::class, 'customer_ledger_table'])->name('report.customer.ledger.table');
        Route::get('/admin/customer-ledger-table-summery/{id}', [ReportController::class, 'customer_ledger_table_summery']);
        Route::get('/admin/customer-ledger-table-invoice-summery/{id}', [ReportController::class, 'customer_ledger_table_invoice_summery']);
        Route::get('/admin/customer-ledger-table-payment-summery/{id}', [ReportController::class, 'customer_ledger_table_payment_summery']);
        Route::get('/admin/customer-returned-product-summery/{id}', [ReportController::class, 'customer_ledger_table_returned_product_summery']);
        Route::post('/admin/customer-date-range-ledger', [ReportController::class, 'customer_date_range_ledger'])->name('admin.customer.date.range.ledger');
        
        Route::get('/admin/customer-sold-product-ledger/{code}', [ReportController::class, 'customer_sold_product_ledger'])->name('customer.sold.product.ledger');
        //Customer Ledger Table

        //Supplier Ledger Table
        Route::get('/report/{id}/supplier-ledger-table', [ReportController::class, 'supplier_ledger_table'])->name('report.supplier.ledger.table');
        Route::get('/admin/supplier-ledger-table-invoice-summery/{id}', [ReportController::class, 'supplier_ledger_table_invoice_summery']);
        Route::get('/admin/supplier-ledger-table-payment-summery/{id}', [ReportController::class, 'supplier_ledger_table_payment_summery']);
        Route::get('/admin/supplier-returned-product-summery/{id}', [ReportController::class, 'supplier_ledger_table_returned_product_summery']);
        Route::post('/admin/supplier-date-range-ledger', [ReportController::class, 'supplier_date_range_ledger'])->name('admin.supplier.date.range.ledger');
        //Supplier Ledger Table

        //Lender Ledger Table
        Route::get('/report/{id}/lender-ledger-table', [ReportController::class, 'lender_ledger_table'])->name('report.lender.ledger.table');
        Route::get('/admin/lender-ledger-table-invoice-summery/{id}', [ReportController::class, 'lender_ledger_table_invoice_summery']);
        Route::post('/admin/lender-date-range-ledger', [ReportController::class, 'admin_Lender_date_range_ledger'])->name('admin.lender.date.range.ledger');
        //Lender Ledger Table

        //Bank Ledger Table
        Route::get('/report/{id}/bank-ledger-table', [ReportController::class, 'bank_ledger_table'])->name('report.bank.ledger.table');
        Route::get('/admin/bank-ledger-transaction-summery/{bank_id}', [ReportController::class, 'transaction_summery_of_bank']);
        Route::get('/admin/cheque-sell-paid-invoice-summery/{id}', [ReportController::class, 'bank_ledger_sell_paid_summery']);
        Route::get('/admin/customer-due-received-summery-by-bank/{id}', [ReportController::class, 'bank_ledger_customer_due_received_summery']);
        Route::get('/admin/bank-ledger-expenses-summery/{id}', [ReportController::class, 'bank_ledger_expenses_payment_summery']);
        Route::get('/admin/bank-ledger-loans-summery/{id}', [ReportController::class, 'bank_ledger_loans_summery']);
        Route::get('/admin/bank-ledger-supplier-payments-summery/{id}', [ReportController::class, 'bank_ledger_supplier_payments_summery']);
        Route::get('/admin/bank-ledger-capitals-summery/{id}', [ReportController::class, 'bank_ledger_capitals_summery']);
        Route::get('/admin/bank-ledger-contras-summery/{id}', [ReportController::class, 'bank_ledger_contras_summery']);
        Route::post('/admin/bank-date-range-ledger', [ReportController::class, 'admin_bank_date_range_ledger'])->name('admin.bank.date.range.ledger');
        //Bank Ledger Table

        //Owner Ledger Table
        Route::get('/report/{id}/owner-ledger-table', [ReportController::class, 'owner_ledger_table'])->name('report.owner.ledger.table');
        Route::get('/admin/owner-ledger-table-transaction-summery/{id}', [ReportController::class, 'owner_ledger_table_transaction_summery']);
        Route::post('/admin/owner-date-range-ledger', [ReportController::class, 'admin_owner_date_range_ledger'])->name('admin.owner.date.range.ledger');
        //Owner Ledger Table

        

        //Begin:: Ledger Report
        Route::get('/admin/accounts-statement/ledger', [ReportController::class, 'all_ledger_in_one_page'])->name('admin.account.statement.ledger');
        Route::get('/admin/all-lenders-for-ledger', [ReportController::class, 'admin_all_lenders_for_ledger'])->name('admin.all.lender.for.ledger');
        Route::get('/admin/all-banks-for-ledger', [ReportController::class, 'admin_all_banks_for_ledger'])->name('admin.all.banks.for.ledger');
        Route::get('/admin/all-owners-capital-persons-for-ledger', [ReportController::class, 'admin_all_capital_persons_for_ledger'])->name('admin.all.owners.for.ledger');
        //End:: Ledger Report
        
        //Begin:: Ledger Report
        Route::get('/admin/accounts-expenses-ledger', [ReportController::class, 'expenses_ledger'])->name('admin.account.expenses.ledger');
        Route::get('/admin/report/monthley-expenses-data', [ReportController::class, 'expenses_data']);
        // Route::get('/admin/all-banks-for-ledger', [ReportController::class, 'admin_all_banks_for_ledger'])->name('admin.all.banks.for.ledger');
        // Route::get('/admin/all-owners-capital-persons-for-ledger', [ReportController::class, 'admin_all_capital_persons_for_ledger'])->name('admin.all.owners.for.ledger');
        //End:: Ledger Report
        
        
        
        
        //Begin:: Shop Admin SMS
        Route::get('/admin/sms-panel', [SmsRechargeRequestController::class, 'index'])->name('admin.sms.panel');
        Route::get('/admin/sms-panel-recharge-requests-data', [SmsRechargeRequestController::class, 'shop_admin_recharge_requests_data'])->name('admin.sms.panel.recharge.request.data');
        Route::post('/admin/sms-panel-recharge-requests-confirm', [SmsRechargeRequestController::class, 'store'])->name('admin.sms.recharge.request.confirm');
        
        
        Route::get('/admin/sms-settings', [SmsRechargeRequestController::class, 'sms_settings'])->name('admin.sms.settings');
        Route::post('/admin/store-sms-settings', [SmsRechargeRequestController::class, 'store_sms_settings'])->name('admin.store.sms.settings');
        Route::get('/admin/sms-history', [SmsHistoryController::class, 'index'])->name('admin.sms.histories');
        Route::get('/admin/sms-history-data', [SmsHistoryController::class, 'shop_admin_sms_histories_data'])->name('admin.sms.histories.data');
        Route::get('/admin/send-sms', [SmsHistoryController::class, 'index'])->name('admin.sms.send');
        Route::get('/admin/send-sms-customer-data', [SmsHistoryController::class, 'customer_data'])->name('admin.sms.send.customer.data');
        Route::get('/admin/send-sms-supplier-data', [SmsHistoryController::class, 'supplier_data'])->name('admin.sms.send.supplier.data');
        Route::post('/admin/send-single-group-sms', [SmsHistoryController::class, 'send_single_sms'])->name('admin.send.single.sms');
        //End:: Shop Admin SMS
        
        

        

        
    // End:: Shop Account and transaction Route ---------------------->



    // Begin:: SR Route ------------------------------------------------------>

        //Begin:: Branch To SR transfer Products
        Route::get('/sr/transfer-products-branch-to-sr', [BranchToSRproductsTransferController::class, 'create'])->name('b.to.sr.transfer');
        Route::post('/sr/transfer-products-branch-to-sr-confirm', [BranchToSRproductsTransferController::class, 'store'])->name('b.to.sr.transfer.confirm');
        Route::get('/sr/transfer-products-branch-to-sr-invoices', [BranchToSRproductsTransferController::class, 'index'])->name('b.to.sr.transfer.index');
        Route::get('/sr/transfer-products-branch-to-sr-invoices_data', [BranchToSRproductsTransferController::class, 'index_data'])->name('b.to.sr.transfer.index.data');
        Route::get('/sr/product-stocks', [BranchToSRproductsTransferController::class, 'show'])->name('sr.product.stock');
        Route::get('/sr/product-stocks_data/{place}/{brand}', [BranchToSRproductsTransferController::class, 'stock_data']);
        Route::get('/sr/product-stocks_data_value', [BranchToSRproductsTransferController::class, 'stock_data_value']);
        
    // End:: SR Route ------------------------------------------------------>


    

    // Begin:: Branch Route ---------------------->

        //Begin:: Branch Setting.
        Route::get('/branch/setting', [BranchSettingController::class, 'branch_setting_index'])->name('branch.branch_setting');
        Route::post('/branch/update-branch-setting', [BranchSettingController::class, 'branch_setting_update']);
        //End:: Branch Setting.
    
        //Begin:: Customers
        Route::get('/branch/shop-customers', [CustomerController::class, 'index'])->name('branch.all.customer');
        Route::get('/branch/shop-customers-data', [CustomerController::class, 'customer_data'])->name('branch.all.customer.data');
        
        Route::get('/branch/add-customers', [CustomerController::class, 'create'])->name('branch.add.customer');
        Route::post('/branch/add-customers-confrim', [CustomerController::class, 'store'])->name('branch.add.customer.confirm');
        Route::get('/branch/edit-customer/{id}', [CustomerController::class, 'edit'])->name('branch.edit.customer');;
        Route::post('/branch/update-customer/{id}', [CustomerController::class, 'update']);
        Route::get('/branch/deactive-customer/{id}', [CustomerController::class, 'DeactiveCustomer'])->name('branch.deactive.customer');
        Route::get('/branch/active-customer/{id}', [CustomerController::class, 'ActiveCustomer'])->name('branch.active.customer');
        //End:: Customers

        //Begin:: Branch Product Stock
        Route::get('/branch/product-stock', [ProductStockController::class, 'index'])->name('branch.product.stock');
        Route::get('/branch/product-stock-data', [ProductStockController::class, 'product_stock_data'])->name('branch.product.stock.data');
        //End:: Branch Product Stock
        
        
        // Start ========================================================================================= Sell New =================== Sell New =======>
        Route::get('/branch/sell-new', [BranchSettingController::class, 'branch_sell_new'])->name('branch.sell.new');
        Route::get('/branch/stock-out/search_sr', [BranchSettingController::class, 'branch_search_sr_for_sale']);
        Route::get('/branch/stock-out/search-customer_new', [BranchSettingController::class, 'branch_search_customer_new']);
        Route::get('/branch/sell/search_customer_info', [BranchSettingController::class, 'search_customer_info_new']);
        Route::get('/branch/search/customer_phone_new', [BranchSettingController::class, 'branch_check_customer_phone_new']);
        Route::get('/branch/add-new-customer_into_pos_new', [BranchSettingController::class, 'add_new_customer_into_pos_new']);
        Route::get('/branch/convert_point_to_tk_into_sell', [BranchSettingController::class, 'convert_point_to_tk_into_sell']);
        Route::get('/branch/product_search_into_sell_new', [BranchSettingController::class, 'branch_product_search_into_sell_new']);
        Route::get('/get_products_from_sell_new', [BranchSettingController::class, 'get_products_from_sell_new']);
        Route::get('/branch/get_product_for_cart_into_sell_new', [BranchSettingController::class, 'get_product_for_cart_into_sell_new']);
        Route::get('/branch/product_search_from_barcode_new', [BranchSettingController::class, 'get_products_from_barcode_new']);
        Route::get('/branch/multiple_payment_row_add', [BranchSettingController::class, 'multiple_payment_row_add']);
        
        Route::post('/branch/new_sell_confirm_by_ajax_new', [OrderController::class, 'store_by_ajax_new']);
        
        
        // End ========================================================================================= Sell New =================== Sell New =======>
        
        
        //Begin:: Branch Product Sell
        Route::get('/branch/{customer_code}/sell', [BranchSettingController::class, 'branch_sell'])->name('branch.sell');
        Route::get('/branch/stock-out/search-customer', [BranchSettingController::class, 'branch_search_customer']);
        Route::post('/branch/add-new-customer/sell', [BranchSettingController::class, 'add_new_customer'])->name('branch.add.new.customer.from.sell');
        Route::get('/branch/search/customer-phone', [BranchSettingController::class, 'branch_check_customer_phone']);
        Route::get('/branch/search/customer-email', [BranchSettingController::class, 'branch_check_customer_email']);
        Route::get('/branch/sell/category-to-brand-search', [BranchSettingController::class, 'branch_category_to_brand_search']);
        Route::get('/branch/product-search-into-sell', [BranchSettingController::class, 'branch_product_search_into_sell']);
        Route::get('/get_products_from_sell', [BranchSettingController::class, 'get_products_from_sell']);
        Route::get('/branch/walking.customer', [BranchSettingController::class, 'select_walking_customer'])->name('shop.walking.customer');
        Route::post('/branch/new-sell-confirm', [OrderController::class, 'store'])->name('branch.new.sell.confirm');
        
        //test sell by ajax
        Route::post('/branch/new-sell-confirm-by-ajax', [OrderController::class, 'store_by_ajax']);
        //test sell by ajax
        
        
        Route::get('/branch/product-search-from-barcode', [BranchSettingController::class, 'get_products_from_barcode']);
        //End:: Branch Product Sell

        //Begin:: Branch Product Sold and return
        Route::get('/branch/sold-invoices', [OrderController::class, 'index'])->name('branch.sold.invoices');
        Route::get('/branch/sold-invoices-datatable-info', [OrderController::class, 'order_datatable_info'])->name('branch.sold.invoices.datatable.info');
        Route::get('/branch/{invoice_id}/sold-invoice-view', [OrderController::class, 'show'])->name('view.sold.invoice');
        
        Route::get('/branch/sold-invoices-v2', [OrderController::class, 'sold_invoices_full_info'])->name('branch.sold.invoices.full.info');
        Route::get('/branch/sold-invoices-v2-datatable-info', [OrderController::class, 'sold_invoices_full_info_data'])->name('branch.full.sold.invoices.datatable.info');
        
        Route::get('/print-invoice-half-page/{invoice_id}', [OrderController::class, 'print_invoice_in_half_page'])->name('view.sold.invoice.in.half.page');
        
        
        Route::get('/print_invoice/{invoice_id}', [OrderController::class, 'print_invoice_in_pos_printer'])->name('branch.print.sold.invoice.in.pos.printer');
        Route::get('/pos-print/{invoice_id}', [OrderController::class, 'invoice_pos_print'])->name('invoice.pos.print');
        
        
        
        Route::get('/branch/returnable-invoice', [ReturnOrderController::class, 'index'])->name('branch.returnable.invoice');
        Route::get('/branch/returnable-invoice-ajax', [ReturnOrderController::class, 'ajax_search'])->name('branch.returnable.invoice.ajax');
        Route::get('/branch/{invoice_id}/return-products', [ReturnOrderController::class, 'edit'])->name('branch.return.invoice.product');
        Route::get('/branch/return-products/exchange-status', [ReturnOrderController::class, 'beanch_exchange_status']);
        Route::get('/branch/return-products/search_customer', [ReturnOrderController::class, 'search_customer']);
        Route::get('/branch/return_products/search_products', [ReturnOrderController::class, 'products_search_by_title_in_customer_return']);
        Route::get('/distributor/return_products/confirm_return', [ReturnOrderController::class, 'confirm_direct_return_to_customer'])->name('customer.direct.return.products');
        
        Route::post('/branch/customer-return-products-confirm', [ReturnOrderController::class, 'update'])->name('customer.invoice.return.confirm');
        Route::get('/branch/customer-returned-invoices', [ReturnOrderController::class, 'returned_product_invoices'])->name('branch.customer.returned.invoices');
        Route::get('/branch/customer-returned-invoices-data', [ReturnOrderController::class, 'returned_product_invoices_data'])->name('branch.returned.invoices.data');
        Route::get('/branch/{invoice_id}/{current_return_times}/view-product-returned-invoice', [ReturnOrderController::class, 'show'])->name('view.product.returned.invoice');
        
            //Branch Return product New
                Route::get('/branch/{invoice_id}/return-products-new', [ReturnOrderController::class, 'edit_new'])->name('branch.return.invoice.product.new');
                Route::get('/branch/return_products/exchange_status_new', [ReturnOrderController::class, 'beanch_exchange_status_new']);
                Route::post('/branch/customer-return-products-confirm-new', [ReturnOrderController::class, 'update_new'])->name('customer.invoice.return.confirm.new');
            //Branch Return product New
            
            
        //Begin:: Branch Product Sold and return


        //begin:: branch received customer due
        Route::get('/branch/{customer_code}/take-due', [BranchSettingController::class, 'received_customer_due_index'])->name('branch.take.customer.due');
        Route::get('/branch/take-due/search-customer', [BranchSettingController::class, 'branch_search_customer_for_take_due']);
        Route::post('/branch/take-due/from-customer-confirm', [TakeCustomerDueController::class, 'store'])->name('branch.received.customer.due.confirm');
        Route::get('/branch/vouchers/customer-due', [TakeCustomerDueController::class, 'index'])->name('branch.due.received.vouchers');
        Route::get('/branch/vouchers/customer-due-data', [TakeCustomerDueController::class, 'index_data'])->name('branch.due.received.vouchers.data');
        Route::get('/branch/view/{voucher_num}/customer-due-received-voucher', [TakeCustomerDueController::class, 'show'])->name('view.due.received.voucher');
        //End:: branch received customer due

        //Begin:: branch Damage Product
        Route::get('/branch/products-for-damage', [DamageProductController::class, 'index'])->name('branch.damage.product');
        Route::get('/branch/products-for-damage-data', [DamageProductController::class, 'index_data'])->name('branch.damage.product.data');
        Route::post('/branch/add-damage-product', [DamageProductController::class, 'store'])->name('branch.add.damage.product');
        Route::get('/branch/all-damaged-product', [DamageProductController::class, 'branch_all_damaged_product'])->name('branch.all.damaged.product');
        Route::get('/branch/all-damaged-product-data', [DamageProductController::class, 'branch_all_damaged_product_data'])->name('branch.all.damaged.product.data');
        //End:: branch Damage Product

        //Begin:: branch Report
        Route::get('/branch/due-customers', [BranchSettingController::class, 'branch_due_customers'])->name('branch.due.customers');

        
        
        Route::get('/paul', [ReportController::class, 'test'])->name('test.paul');
       
        
        
        
        
        
        
        
        
    // End:: Branch Route ---------------------->


    // Begin:: Super Admin Route ---------------------->
    


    // End:: Super Admin Route ---------------------->


    



Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');





});

Route::get('/{code}', [ShopSettingController::class, 'shop_login']);
Route::get('/barcode-p', [ProductController::class, 'test_png_barcode_generator_can_generate_code_128_barcode']);





// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

