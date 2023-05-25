<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Possibility;
use App\Models\PossibilityRight;
use Illuminate\Http\Request;

class PossibilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
                $request->image->move(public_path('assets/images/possibility'), $fileName);
                $file_path = "assets/images/possibility/" . $fileName;
            }

            if (isset($request->left_title) || isset($request->left_description) || isset($file_path)) {
                $possibility = Possibility::create([
                    'left_title' => $request->left_title ? $request->left_title : '',
                    'left_description' => $request->left_description ? $request->left_description : '',
                    'image' => $file_path ? $file_path : '',
                ]);
            }

            if (isset($request->right_title) || isset($request->right_description)) {
                $right_possibility = PossibilityRight::create([
                    'right_title' => $request->right_title,
                    'right_description' => $request->right_description
                ]);
            }
            if (isset($possibility) || isset($right_possibility)) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => [
                        'left_possibility' => isset($possibility) ? $possibility : '',
                        'right_possibility' => isset($right_possibility) ? $right_possibility : ''
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
                'status' => 500
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
