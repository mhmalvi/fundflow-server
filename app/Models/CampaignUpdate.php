<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignUpdate extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function campaign_update()
    {
        return $this->belongsTo(CampaignOverview::class);
    }
}
