<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $product = Product::orderBy('id', 'desc')->get();
            if ($product) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $product
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
            if (isset($request->image)) {
                $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('assets/images/product'), $fileName);
                $file_path = "assets/images/product/" . $fileName;
            }
            $product = Product::create([
                'name' => isset($request->name) ? $request->name : "",
                'description' => isset($request->description) ? $request->description : "",
                'image' => isset($file_path) ? $file_path : "",
                'price' => isset($request->price) ? $request->price : "",
                'target' => isset($request->target) ? $request->target : "",
                'raised' => isset($request->raised) ? $request->raised : "",
                'investor_number' => isset($request->investor_number) ? $request->investor_number : "",
                'slug' => isset($request->slug) ? $request->slug : "",
                'category_id' => isset($request->category_id) ? $request->category_id : "",
            ]);
            if ($request->images) {
                foreach ($request->images as $images) {
                    $data[] = $images;
                    $images = [];
                }
                if ($data) {
                    for ($i = 0; $i < count($data); $i++) {
                        $path = $data[$i]->store('assets/images/products', ['disk' =>   'product_images']);
                        $save = ProductImage::create([
                            'images' => $path,
                            'product_id' => $product->id,
                            'created_at' => Carbon::now()
                        ]);
                        $image[] = $save;
                    }
                }
            }
            if (isset($product) || isset($image)) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => [
                        'product' => isset($product) ? $product : "",
                        'images' => isset($image) ? $image : ""
                    ]
                ], 201);
            } else {
                return response()->json([
                    'message' => 'success',
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
    public function show($slug)
    {
        if ($slug) {
            $product = Product::where('slug', $slug)->first();
            if ($product) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $product
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
    public function update(Request $request, $slug)
    {
        // dd($request->all());
        try {
            $update = Product::where('slug', $slug)->first();
            // dd($update);
            if (isset($request->image)) {
                $fileName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('assets/images/product'), $fileName);
                $file_path = "assets/images/product/" . $fileName;
            }
            if ($update) {
                $update->name = isset($request->name) ? $request->name : "";
                $update->description = isset($request->description) ? $request->description : "";
                $update->image = isset($file_path) ? $file_path : "";
                $update->price = isset($request->price) ? $request->price : "";
                $update->target = isset($request->target) ? $request->target : "";
                $update->raised = isset($request->raised) ? $request->raised : "";
                $update->investor_number = isset($request->investor_number) ? $request->investor_number : "";
                $update->slug = isset($request->slug) ? $request->slug : "";
                // $update->category_id = isset($category_id) ? $category_id : "";
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

    public function update_product_image(Request $request)
    {
        $image = ProductImage::find($request->id);
        if ($request->images) {
            $data = $request->images;
            $path = $data->store('assets/images/products', ['disk' =>   'product_images']);
            $image->images = $path;
            $update = $image->save();
            if ($update) {
                return response()->json([
                    'message' => 'updated'
                ]);
            }
            $path = "";
            $data = "";
        }
    }

    public function delete_product_image($id)
    {
        $image = ProductImage::find($id);
        if ($image) {
            $delete = $image->delete();
            // dd($delete);
            if ($delete == true) {
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
        $product = Product::where('slug', $slug)->first();
        if ($product) {
            $delete = $product->delete();
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
