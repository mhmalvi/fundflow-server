<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Models\MontlyBlogReader;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $blog = Blog::orderBy('id', 'desc')->get();
            if ($blog) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $blog
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
            if (Auth::check() && Auth::user()->roles == 'admin') {
                if (isset($request->image)) {
                    $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                    $request->image->move(public_path('assets/images/blogs'), $fileName);
                    $file_path = "assets/images/blogs/" . $fileName;
                }
                $blog = Blog::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'author' => $request->author,
                    'image' => $file_path
                ]);

                if ($blog) {
                    return response()->json([
                        'message' => 'success',
                        'status' => 201,
                        'data' => $blog
                    ], 201);
                } else {
                    return response()->json([
                        'message' => 'failed',
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
            $blog = Blog::find($id);
            if ($blog) {
                $visitor = new MontlyBlogReader();
                $visitor->monthly_blog_reader = 1;
                $visitor->save();
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $blog
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
            $update = Blog::find($id);
            // dd($update);
            if (isset($request->image)) {
                $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('assets/images/blogs'), $fileName);
                $file_path = "assets/images/blogs/" . $fileName;
            }
            if ($update) {
                $update->title = isset($request->title) ? $request->title : "";
                $update->description = isset($request->description) ? $request->description : "";
                $update->image = isset($file_path) ? $file_path : "";
                $update->author = isset($request->author) ? $request->author : "";
                $update->save();
                return response()->json([
                    'message' => 'updated',
                    'status' => 201,
                    'data' => $update
                ], 201);
            } else {
                return response()->json([
                    'message' => 'slug mot found',
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
    public function destroy($id)
    {
        try {
            $blog = Blog::find($id);
            if ($blog) {
                $delete = $blog->delete();
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
