<?php

use Illuminate\Http\Request;
use App\Models\HomeTopSlider;
use App\Models\CampaignOverview;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\OurTeamController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OurInvestorController;
use App\Http\Controllers\Api\PossibilityController;
use App\Http\Controllers\Api\HomeTopSliderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('home-top-slider', [HomeTopSliderController::class, 'index']);


//category start
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{slug}', [CategoryController::class, 'show']);
Route::get('product-by-category', [CategoryController::class, 'product_by_cat']);
//category end

// product start
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{slug}', [ProductController::class, 'show']);

// product end

// blog start

Route::get('blogs', [BlogController::class, 'index']);
Route::get('blogs/{id}', [BlogController::class, 'show']);
// blog end


// article start
Route::get('articles', [ArticleController::class, 'index']);
Route::get('articles/{id}', [ArticleController::class, 'show']);
// article end


// story start
Route::get('stories', [StoryController::class, 'index']);
Route::get('stories/{id}', [StoryController::class, 'show']);
// story end

// our team start
Route::get('our-team', [OurTeamController::class, 'index']);
Route::get('our-team/{id}', [OurTeamController::class, 'show']);
// our team end

// our investor start
Route::get('our-investor', [OurInvestorController::class, 'index']);
Route::get('our-investor/{id}', [OurInvestorController::class, 'show']);
Route::get('investor-count', [OurInvestorController::class, 'investor_count']);
// our investor end

Route::get('monthly-blog-reader', [VisitorController::class, 'monthly_blog_reader']);


// campaign start
Route::post('campaign-about-store', [CampaignController::class, 'campaign_about']);
Route::post('campaign-reward-store', [CampaignController::class, 'campaign_reward']);
// campaign  end

Route::get('logout', [UserController::class, 'logout']);

Route::post('user-register', [UserController::class, 'user_register']);
Route::post('login', [UserController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('blog-store', [BlogController::class, 'store'])->middleware('admin');
    Route::post('blogs-update/{id}', [BlogController::class, 'update'])->middleware('admin');
    Route::get('blog-delete/{id}', [BlogController::class, 'destroy'])->middleware('admin');



    Route::post('our-investor-store', [OurInvestorController::class, 'store'])->middleware('admin');
    Route::post('our-investor-update/{id}', [OurInvestorController::class, 'update'])->middleware('admin');
    Route::get('our-investor-delete/{id}', [OurInvestorController::class, 'destroy'])->middleware('admin');

    Route::post('our-team-store', [OurTeamController::class, 'store'])->middleware('admin');
    Route::post('our-team-update/{id}', [OurTeamController::class, 'update'])->middleware('admin');
    Route::get('our-team-delete/{id}', [OurTeamController::class, 'destroy'])->middleware('admin');

    Route::post('story-store', [StoryController::class, 'store'])->middleware('admin');
    Route::post('stories-update/{id}', [StoryController::class, 'update'])->middleware('admin');
    Route::get('story-delete/{id}', [StoryController::class, 'destroy'])->middleware('admin');

    Route::post('product-store', [ProductController::class, 'store'])->middleware('admin');
    Route::post('products-update/{slug}', [ProductController::class, 'update'])->middleware('admin');
    Route::get('product-image-delete/{id}', [ProductController::class, 'delete_product_image'])->middleware('admin');
    Route::post('product-image-update/{id}', [ProductController::class, 'update_product_image']);

    Route::post('category-store', [CategoryController::class, 'store'])->middleware('admin');
    Route::post('categories-update/{slug}', [CategoryController::class, 'update'])->middleware('admin');
    Route::get('category-delete/{slug}', [CategoryController::class, 'destroy'])->middleware('admin');

    Route::post('home-top-slider-store', [HomeTopSliderController::class, 'store'])->middleware('admin');

    Route::post('possibility-store', [PossibilityController::class, 'store'])->middleware('admin');

    Route::post('faq-store', [CampaignController::class, 'faq']);

    Route::post('article-store', [ArticleController::class, 'store'])->middleware('admin');
    Route::post('article-update/{id}', [ArticleController::class, 'update'])->middleware('admin');
    Route::get('article-delete/{id}', [ArticleController::class, 'destroy'])->middleware('admin');

    Route::get('logout', [UserController::class, 'logout']);
});
