<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignOverviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_overviews', function (Blueprint $table) {
            $table->id();
            $table->text('project_title')->nullable();
            $table->text('project_sub_title')->nullable();
            $table->text('project_primary_category')->nullable();
            $table->text('project_sub_category')->nullable();
            $table->text('project_location')->nullable();
            $table->string('project_image')->nullable();
            $table->string('project_video')->nullable();
            $table->text('currency')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('share_price')->nullable();
            $table->longText('campaign_story')->nullable();
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
        Schema::dropIfExists('campaign_overviews');
    }
}
