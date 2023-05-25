<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeTopSlider;
use App\Models\HomeTopSliderImage;
use App\Models\JoinUs;
use Illuminate\Support\Carbon;

class HomeTopSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $slider = HomeTopSlider::all();
            $images = HomeTopSliderImage::all();
            if ($slider) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $slider,
                    'images' => $images
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "not found"
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if ($request->title && $request->description) {
                $home = HomeTopSlider::create([
                    'title' => $request->title,
                    'description' => $request->description
                ]);
            }
            $data = array();
            if ($request->image) {
                foreach ($request->image as $images) {
                    $data[] = $images;
                    $images = [];
                }
                if ($data) {
                    for ($i = 0; $i < count($data); $i++) {
                        $path = $data[$i]->store('assets/images/slider', ['disk' =>   'home_slider']);
                        $save = HomeTopSliderImage::create([
                            'images' => $path,
                            'created_at' => Carbon::now()
                        ]);
                        $image[] = $save;
                    }
                }
            }


            if (isset($request->join_us_image)) {
                $fileName = time() . '.' . $request->join_us_image->getClientOriginalExtension();
                $request->join_us_image->move(public_path('assets/images/join_us'), $fileName);
                $file_path = "assets/images/join_us/" . $fileName;
                $join_us_img_path = $file_path;
            }

            if (isset($request->join_us_title) || isset($request->join_description) || isset($join_us_img_path)) {
                $joinUs = JoinUs::create([
                    'join_us_title' => $request->join_us_title,
                    'join_us_description' => $request->join_us_description,
                    'join_us_image' => $join_us_img_path
                ]);
            }
            if (isset($home) || isset($save) || isset($joinUs)) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => [
                        'data' => isset($home) ? $home : '',
                        'images' => isset($image) ? $image : '',
                        'join_us' => isset($joinUs) ? $joinUs : '',
                    ]
                ], 201);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500,
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
