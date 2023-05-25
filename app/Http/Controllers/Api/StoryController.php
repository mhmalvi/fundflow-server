<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $story = Story::orderBy('id', 'desc')->get();
            if ($story) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $story
                ], 200);
            } else {
                return response()->json([
                    'message' => 'not found',
                    'status' => 404
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 500
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
            if (isset($request->image)) {
                $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('assets/images/stories'), $fileName);
                $file_path = "assets/images/stories/" . $fileName;
            }
            $story = Story::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => isset($file_path) ? $file_path : ""
            ]);

            if ($story) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => $story
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
        if ($id) {
            $story = Story::find($id);
            if ($story) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $story
                ], 200);
            } else {
                return response()->json([
                    'message' => 'not found',
                    'status' => 404,
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'slug not found',
                'status' => 404,
            ], 404);
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
            $update = Story::find($id);
            // dd($update);
            if (isset($request->image)) {
                $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('assets/images/stories'), $fileName);
                $file_path = "assets/images/stories/" . $fileName;
            }
            if ($update) {
                $update->title = isset($request->title) ? $request->title : "";
                $update->description = isset($request->description) ? $request->description : "";
                $update->image = isset($file_path) ? $file_path : "";
                $update->save();
                return response()->json([
                    'message' => 'updated',
                    'status' => 201,
                    'data' => $update
                ], 201);
            } else {
                return response()->json([
                    'message' => 'id not found',
                    'status' => 404
                ],404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 500,
            ], 500);
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
            $story = Story::find($id);
            if ($story) {
                $delete = $story->delete();
                if ($delete) {
                    return response()->json([
                        'message' => 'deleted',
                        'status' => 200
                    ]);
                } else {
                    return response()->json([
                        'message' => 'failed',
                        'status' => 500
                    ]);
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
