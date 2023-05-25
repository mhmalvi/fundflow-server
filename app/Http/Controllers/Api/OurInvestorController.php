<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OurInvestor;
use App\Models\Visitor;
use Illuminate\Http\Request;

class OurInvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $our_investor = OurInvestor::orderBy('id', 'desc')->get();
            if ($our_investor) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $our_investor
                ], 200);
            } else {
                return response()->json([
                    'message' => 'success',
                    'status' => 404,
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function investor_count()
    {
        $visitor_count = OurInvestor::all()->count();
        if ($visitor_count) {
            return response()->json([
                'message' => 'success',
                'data' => $visitor_count,
                'status' => 200
            ], 200);
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
                $request->image->move(public_path('assets/images/our_investor'), $fileName);
                $file_path = "assets/images/our_investor/" . $fileName;
            }
            $save = OurInvestor::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => isset($file_path) ? $file_path : "",
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $our_investor = OurInvestor::find($id);
            if ($our_investor) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => [$our_investor]
                ], 201);
            } else {
                return response()->json([
                    'message' => 'not found',
                    'status' => 404
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
            $our_investor = OurInvestor::find($id);
            if (isset($request->image)) {
                $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('assets/images/our_investor'), $fileName);
                $file_path = "assets/images/our_investor/" . $fileName;
            }
            if ($our_investor) {
                $our_investor->name = $request->name;
                $our_investor->image = isset($file_path) ? $file_path : "";
                $our_investor->description = $request->description;
                $update = $our_investor->save();
                if ($update) {
                    return response()->json([
                        'message' => 'success',
                        'status' => 201,
                        'data' => [$our_investor]
                    ], 201);
                } else {
                    return response()->json([
                        'message' => 'not found',
                        'status' => 500
                    ], 500);
                }
            } else {
                return response()->json([
                    'message' => 'not found',
                    'status' => 404
                ], 404);
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
            $our_investor = OurInvestor::find($id);
            if ($our_investor) {
                $delete = $our_investor->delete();
                if ($delete) {
                    return response()->json([
                        'message' => 'deleted',
                        'status' => 200
                    ], 201);
                } else {
                    return response()->json([
                        'message' => 'not found',
                        'status' => 500
                    ], 500);
                }
            } else {
                return response()->json([
                    'message' => 'not found',
                    'status' => 404
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
