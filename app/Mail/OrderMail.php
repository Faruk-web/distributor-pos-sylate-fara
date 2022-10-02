<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


class OrderMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $invoice_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $invoice_id = $this->invoice_id;
        $invoice_info = order::where('invoice_id', $invoice_id)->first();
        $shop_info = DB::table('shop_settings')->where('shop_code', $invoice_info->shop_id)->first();
        $pdf = PDF::loadView('cms.branch.sell.view_sold_invoice', compact('shop_info', 'invoice_info'));
       // $pdf = PDF::loadView('admin.invoice.generate', compact('order'));
        return $this->subject('Congratulations! Your order has been placed.')
                ->from('no-reply@ehishab.com', $shop_info->shop_name)
                //->to($invoice_info->customer_info->email, $invoice_info->customer_info->name)
                ->to('cse.ridoypaul@gmail.com', 'FIL')
                ->view('cms.branch.sell.view_sold_invoice', compact('shop_info', 'invoice_info'))
                ->attachData($pdf->output(), 'invoice.pdf', [
                    'mime' => 'application/pdf',
                ]);
    
    }
}
