<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_rewards', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->integer('amount')->nullable();
            $table->text('description')->nullable();
            $table->date('delivery_starting')->nullable();
            $table->text('delivery_nature')->nullable();
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
        Schema::dropIfExists('campaign_rewards');
    }
}
