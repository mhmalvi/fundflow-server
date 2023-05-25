<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $category = Category::orderBy('id', 'desc')->get();
            if ($category) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $category
                ], 200);
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
            if (Auth::check() && Auth::user()->roles == 'admin') {
                if (isset($request->image)) {
                    $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                    $request->image->move(public_path('assets/images/category'), $fileName);
                    $file_path = "assets/images/category/" . $fileName;
                }
                $category = Category::create([
                    'name' => isset($request->name) ? $request->name : "",
                    'description' => isset($request->description) ? $request->description : "",
                    'image' => isset($file_path) ? $file_path : "",
                    'slug' => isset($request->slug) ? $request->slug : ""
                ]);
                if ($category) {
                    return response()->json([
                        'message' => 'success',
                        'status' => 201,
                        'data' => $category
                    ], 201);
                } else {
                    return response()->json([
                        'message' => 'success',
                        'status' => 500,
                    ], 500);
                }
            } else {
                return response()->json([
                    'message' => 'unauthenticated',
                    'status' => 401
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    public function product_by_cat(Request $request)
    {
        if ($request->id) {
            $category = Category::find($request->id);
            // dd(json_encode($category->products));
            if ($category) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $category->products
                ], 200);
            } else {
                return response()->json([
                    'message' => 'not found',
                    'status' => 404
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'not found',
                'status' => 404
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        if ($slug) {
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $category
                ], 200);
            } else {
                return response()->json([
                    'message' => 'not found',
                    'status' => 404,
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'id not found',
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
    public function update(Request $request, $slug)
    {
        // dd($request->all());
        try {
            $update = Category::where('slug', $slug)->first();
            // dd($update);
            if (isset($request->image)) {
                $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('assets/images/category'), $fileName);
                $file_path = "assets/images/category/" . $fileName;
            }
            if ($update) {
                $update->name = isset($request->name) ? $request->name : "";
                $update->description = isset($request->description) ? $request->description : "";
                $update->image = isset($file_path) ? $file_path : "";
                $update->slug = isset($request->slug) ? $request->slug : "";
                $update->save();
                return response()->json([
                    'message' => 'updated',
                    'status' => 201,
                    'data' => $update
                ], 201);
            } else {
                return response()->json([
                    'message' => 'id mot found',
                    'status' => 404
                ]);
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
    public function destroy($slug)
    {
        
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            $delete = $category->delete();
            if ($delete) {
                return response()->json([
                    'message' => 'deleted',
                    'status' => 200
                ], 200);
            } else {
                return response()->json([
                    'message' => 'deleted',
                    'status' => 500
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'not found',
                'status' => 404
            ], 404);
        }
    }
}
