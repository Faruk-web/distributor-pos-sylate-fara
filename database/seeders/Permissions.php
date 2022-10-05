<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();

        $permissions = [

            ['name'=>'account.dashboard', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'account.loan', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'account.list.of.group', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'account.ledger.head', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'account.bank.and.cash', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'account.transaction', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'account.vouchers', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'account.customer.report', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'account.report', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'account.income.statement', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'admin.transaction.vouchers', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'account.capital', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'account.expense', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'account.statement', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],
            ['name'=>'account.indirect.income', 'guard_name'=>'web', 'group_name'=>'Account_Wing'],

            ['name'=>'branch.dashboard', 'guard_name'=>'web', 'group_name'=>'Branch'],
            ['name'=>'branch.customers', 'guard_name'=>'web', 'group_name'=>'Branch'],
            ['name'=>'branch.product.stock', 'guard_name'=>'web', 'group_name'=>'Branch'],
            ['name'=>'branch.sell', 'guard_name'=>'web', 'group_name'=>'Branch'],
            ['name'=>'branch.return.product', 'guard_name'=>'web', 'group_name'=>'Branch'],
            ['name'=>'branch.deliveryman', 'guard_name'=>'web', 'group_name'=>'Branch'],
            ['name'=>'branch.received.customer.due', 'guard_name'=>'web', 'group_name'=>'Branch'],
            ['name'=>'branch.reports', 'guard_name'=>'web', 'group_name'=>'Branch'],
            ['name'=>'branch.damage.product', 'guard_name'=>'web', 'group_name'=>'Branch'],
            ['name'=>'branch.setting', 'guard_name'=>'web', 'group_name'=>'Branch'],
            ['name'=>'branch.sell.discount', 'guard_name'=>'web', 'group_name'=>'Branch'],

            // ['name'=>'godown.dashboard', 'guard_name'=>'web', 'group_name'=>'Godown_Wing'],
            // ['name'=>'godown.stock.info', 'guard_name'=>'web', 'group_name'=>'Godown_Wing'],
            // ['name'=>'godown.stock.out', 'guard_name'=>'web', 'group_name'=>'Godown_Wing'],
            // ['name'=>'godown.stock.in.out.report', 'guard_name'=>'web', 'group_name'=>'Godown_Wing'],

            ['name'=>'admin.setting', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.dashboard', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.helper.role.permission', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.area', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.sr', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'branch', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.crm', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.deliveryman', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.products', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'branch.role.permission', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'others.customers', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'others.sell', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'others.receive.customers.due', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'others.returns.refund', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.branch.product.stock', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.set.opening.and.own.stock', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.product.ledger.table', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.damage.product', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.header.balance.statements', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.sms.panel', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'admin.branch.to.sr.transfer.products', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            ['name'=>'others.sell.discount', 'guard_name'=>'web', 'group_name'=>'Main_Wing'],
            
            
            
            ['name'=>'supplier.dashboard', 'guard_name'=>'web', 'group_name'=>'Supplier_Wing'],
            ['name'=>'supplier.add', 'guard_name'=>'web', 'group_name'=>'Supplier_Wing'],
            ['name'=>'supplier.stock.in', 'guard_name'=>'web', 'group_name'=>'Supplier_Wing'],
            ['name'=>'supplier.view.and.edit', 'guard_name'=>'web', 'group_name'=>'Supplier_Wing'],
            ['name'=>'supplier.report', 'guard_name'=>'web', 'group_name'=>'Supplier_Wing'],
            ['name'=>'supplier.table.ledger', 'guard_name'=>'web', 'group_name'=>'Supplier_Wing'],
            ['name'=>'supplier.return.product', 'guard_name'=>'web', 'group_name'=>'Supplier_Wing'],

        ];

        Permission::insert($permissions);

    }
}
