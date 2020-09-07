<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSubscriptionServicesTableAddDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_services', function (Blueprint $table) {
            $table->integer('discount')->after('price')->default(0);
            $table->timestamp('discount_start_date')->after('price')->nullable();
            $table->timestamp('discount_end_date')->after('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_services', function (Blueprint $table) {
            $table->dropColumn('discount', 'discount_start_date', 'discount_end_date');
        });
    }
}
