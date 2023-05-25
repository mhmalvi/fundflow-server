<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $article = Article::orderBy('id', 'desc')->get();
            if ($article) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $article
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
            try {
                if (isset($request->image)) {
                    $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                    $request->image->move(public_path('assets/images/article'), $fileName);
                    $file_path = "assets/images/article/" . $fileName;
                }
                $article = Article::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'image' => $file_path
                ]);

                if ($article) {
                    return response()->json([
                        'message' => 'success',
                        'status' => 201,
                        'data' => $article
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
        } catch (\Throwable $th) {
            //throw $th;
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
            $article = Article::find($id);
            if ($article) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $article
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
            $article = Article::find($id);
            // dd($article);
            if (isset($request->image)) {
                $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('assets/images/article'), $fileName);
                $file_path = "assets/images/article/" . $fileName;
            }
            if ($article) {
                $article->title = isset($request->title) ? $request->title : "";
                $article->description = isset($request->description) ? $request->description : "";
                $article->image = isset($file_path) ? $file_path : "";
                $article->save();
                return response()->json([
                    'message' => 'updated',
                    'status' => 201,
                    'data' => $article
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
            $article = Article::find($id);
            if ($article) {
                $delete = $article->delete();
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
