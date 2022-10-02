<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->nullable()->index();
            $table->integer('branch_id')->nullable()->index();
            $table->integer('sr_area_id')->nullable()->index();
            $table->string('name');
            $table->string('email')->unique()->index();
            $table->string('phone')->unique();
            $table->string('type');
            $table->string('address')->nullable();
            $table->string('active')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->integer('is_employee')->default(0);
            $table->string('sallery')->nullable();
            $table->string('cv')->nullable();
            $table->longText('nid_info')->nullable();
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
        Schema::dropIfExists('users');
    }
}
