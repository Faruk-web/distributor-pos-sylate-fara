<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarcodePrintersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barcode_printers', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->index();
            $table->string('branch_id')->nullable()->index();
            $table->string('code')->index();
            $table->text('printer_name');
            $table->string('page_width')->nullable();
            $table->string('page_margin_left')->nullable();
            $table->string('page_margin_right')->nullable();
            $table->string('page_margin_top')->nullable();
            $table->string('page_margin_bottom')->nullable();
            $table->string('barcode_row')->nullable();
            $table->string('barcode_width')->nullable();
            $table->string('barcode_height')->nullable();
            $table->string('barcode_margin_left')->nullable();
            $table->string('barcode_margin_right')->nullable();
            $table->string('barcode_margin_top')->nullable();
            $table->string('barcode_margin_bottom')->nullable();
            $table->string('column1_margin_left')->nullable();
            $table->string('column1_margin_right')->nullable();
            $table->string('column1_margin_top')->nullable();
            $table->string('column1_margin_bottom')->nullable();
            $table->string('column2_margin_left')->nullable();
            $table->string('column2_margin_right')->nullable();
            $table->string('column2_margin_top')->nullable();
            $table->string('column2_margin_bottom')->nullable();
            $table->string('column3_margin_left')->nullable();
            $table->string('column3_margin_right')->nullable();
            $table->string('column3_margin_top')->nullable();
            $table->string('column3_margin_bottom')->nullable();
            $table->string('column4_margin_left')->nullable();
            $table->string('column4_margin_right')->nullable();
            $table->string('column4_margin_top')->nullable();
            $table->string('column4_margin_bottom')->nullable();
            $table->string('column5_margin_left')->nullable();
            $table->string('column5_margin_right')->nullable();
            $table->string('column5_margin_top')->nullable();
            $table->string('column5_margin_bottom')->nullable();
            $table->string('barcode_image_height')->nullable();
            $table->string('text_size')->nullable();
            $table->longText('note')->nullable();
            $table->integer('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barcode_printers');
    }
}
