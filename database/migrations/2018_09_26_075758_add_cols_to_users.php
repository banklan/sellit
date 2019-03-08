<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('f_name')->after('id');  
            $table->string('l_name')->after('f_name');  
            $table->string('gender')->after('l_name')->nullable();  
            $table->string('phone_no')->after('gender')->nullable(); 
            $table->string('location')->after('password');  
            $table->string('city')->after('location')->nullable();  
            $table->text('about_me')->after('city')->nullable();  
            $table->string('prof_pix')->after('about_me')->nullable();  
            $table->boolean('status')->default(0)->after('prof_pix');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
