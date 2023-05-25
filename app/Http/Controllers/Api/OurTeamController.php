<?php

namespace App\Http\Controllers\Api;

use App\Models\OurTeam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OurTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $our_team = OurTeam::orderBy('id', 'desc')->get();
            if ($our_team) {
                return response()->json([
                    'message' => 'success',
                    'data' => $our_team,
                    'status' => 200
                ], 200);
            } else {
                return response()->json([
                    'message' => 'not found',
                    'status' => 500
                ], 500);
            }
        } catch (\Throwable $th) {
            throw $th;
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
            if (isset($request->image)) {
                $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('assets/images/our_team'), $fileName);
                $file_path = "assets/images/our_team/" . $fileName;
            }
            $our_team = OurTeam::create([
                'name' => $request->name,
                'designation' => $request->designation,
                'company' => $request->company,
                'image' => isset($file_path) ? $file_path : "",
            ]);
            if ($our_team) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => $our_team
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $our_team = OurTeam::find($id);
            if ($our_team) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $our_team
                ], 200);
            } else {
                return response()->json([
                    'message' => 'not found',
                    'status' => 404,
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
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
        try {
            if (isset($request->image)) {
                $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('assets/images/our_team'), $fileName);
                $file_path = "assets/images/our_team/" . $fileName;
            }
            $our_team = OurTeam::find($id);
            $our_team->name = $request->name;
            $our_team->designation = $request->designation;
            $our_team->company = $request->company;
            $our_team->image = $file_path;
            $update = $our_team->save();
            if ($update) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => $our_team
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $our_team = OurTeam::find($id);
            if ($our_team) {
                $delete = $our_team->delete();
                if ($delete) {
                    return response()->json([
                        'message' => 'deleted',
                        'status' => 200
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'failed',
                        'status' => 500
                    ], 500);
                }
            }else{
                return response()->json([
                    'message'=>'not found',
                    'status'=>404
                ],404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
