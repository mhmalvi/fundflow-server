<?php

namespace App\Models;

use App\Models\CampaignOverview;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampaignAbout extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function campaign()
    {
        return $this->belongsTo(CampaignOverview::class);
    }
}
