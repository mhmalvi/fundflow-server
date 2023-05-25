<?php

namespace App\Http\Controllers\Api;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Models\CampaignAbout;
use App\Models\CampaignReward;
use App\Models\CampaignUpdate;
use App\Models\CampaignOverview;
use App\Http\Controllers\Controller;

class CampaignController extends Controller
{
    public function campaign_overview(Request $request)
    {
        try {
            if (isset($request->project_image)) {
                $fileName = time() . '.' . $request->project_image->getClientOriginalExtension();
                $request->project_image->move(public_path('assets/images/campaign_overview'), $fileName);
                $file_path = "assets/images/campaign_overview/" . $fileName;
            }

            if (isset($request->project_video)) {
                $fileName = time() . '.' . $request->project_video->getClientOriginalExtension();
                $request->project_video->move(public_path('assets/images/campaign_overview_video'), $fileName);
                $video_path = "assets/images/campaign_overview_video/" . $fileName;
            }
            $save = CampaignOverview::create([
                'project_title' => $request->project_title,
                'project_sub_title' => $request->project_sub_title,
                'project_primary_category' => $request->project_primary_category,
                'project_sub_category' => $request->project_sub_category,
                'project_location' => $request->project_location,
                'currency' => $request->currency,
                'amount' => $request->amount,
                'share_price' => $request->share_price,
                'campaign_story' => $request->campaign_story,
                'project_image' => isset($file_path) ? $file_path : "",
                'project_video' => isset($video_path) ? $video_path : "",
            ]);
            if ($save) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => [$save]
                ], 201);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ], 500);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function campaign_about(Request $request)
    {
        // dd($request->all());
        try {
            $save = CampaignAbout::create([
                'address' => $request->address,
                'amount' => $request->amount,
                'description' => $request->description,
                'campaign_id' => $request->campaign_id
            ]);
            if ($save) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => [$save]
                ], 201);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ], 500);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function campaign_update(Request $request)
    {
        // dd($request->all());
        try {
            $save = CampaignUpdate::create([
                'description' => $request->description,
                'campaign_id' => $request->campaign_id
            ]);
            if ($save) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => [$save]
                ], 201);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ], 500);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function campaign_reward(Request $request)
    {
        try {
            $save = CampaignReward::create([
                'title' => $request->title,
                'amount' => $request->amount,
                'description' => $request->description,
                'delivery_starting' => $request->delivery_starting,
                'delivery_nature' => $request->delivery_nature
            ]);
            if ($save) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => [$save]
                ], 201);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ], 500);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function faq(Request $request){
        try {
            $save = Faq::create([
                'question' => $request->question,
                'answer' => $request->answer,
            ]);
            if ($save) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => [$save]
                ], 201);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ], 500);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
