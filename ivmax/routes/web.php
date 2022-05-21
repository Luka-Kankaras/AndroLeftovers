<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ProductController,
    PostController,
    TagController,
    CompanyController,
    LanguageController,
    TeamController,
    GeneralInfoController,
    InfoCategoryController,
    FaqController,
    ContactController,
    UserController,
    WebsiteController,
    ToothpasteTypeController,
    ToothbrushTypeController,
    ColorController,
    ImageController,
    HomepageController,
    FooterController,
    NewsletterController,
    TestimonialController,
};
use \App\Services\StaticFields;


Auth::routes();

Route::get('/', [WebsiteController::class, 'index']);
Route::get('/blog', [WebsiteController::class, 'blog'])->name('blog');
Route::get('/blog-single/{id}', [WebsiteController::class, "blogSingle"])->name('blog-single');
Route::get('/about', [WebsiteController::class, "about"])->name('about');
Route::get('/products', [WebsiteController::class, "products"])->name('products');
Route::get('/help', [WebsiteController::class, "help"])->name('help');
//Route::view('/welcome', 'welcome')->name('welcome');
Route::post('/submit-contact-form', [WebsiteController::class, 'submitContactForm']);

Route::post('/newsletter/store', [NewsletterController::class, 'store'])->name('newsletter.store');

Route::group(['prefix' => '/admin', 'middleware' => 'auth:web'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin');
    Route::get('{path}', [HomeController::class, 'index'])->where('path', '.*')->name('admin.home');
});



Route::group(['prefix' => '/cms', 'middleware' => 'auth:web'], function () {

    Route::get('/user/me', function () {
        return response()->json(auth()->user());
    });

    ################ PRODUCTS ################
    Route::apiResource('/products', ProductController::class);
    ##########################################


    ################ TOOTHPASTE TYPES ################
    Route::get('/toothpaste-types/get-all', [ToothpasteTypeController::class, 'getAll'])->name('toothpaste-types.get-all');
    Route::apiResource('/toothpaste-types', ToothpasteTypeController::class);
    ##################################################


    ################ TOOTHBRUSH TYPES ################
    Route::get('/toothbrush-types/get-all', [ToothbrushTypeController::class, 'getAll'])->name('toothbrush-types.get-all');
    Route::apiResource('/toothbrush-types', ToothbrushTypeController::class);
    ##################################################


    ################ COLORS ##################
    Route::get('/colors/get-all', [ColorController::class, 'getAll'])->name('colors.get-all');
    Route::apiResource('/colors', ColorController::class);
    ##########################################


    ################ POSTS ###################
    Route::apiResource('/posts', PostController::class);
    Route::put('/post-toggle-status/{post}', [PostController::class, 'toggleStatus'])->name('posts.toggle-status');
    Route::post('post/image', [PostController::class, 'preSaveImage'])->name('post.image');
    ##########################################


    ################ TAGS ####################
    Route::apiResource('/tags', TagController::class);
    Route::get('/select-tags', [TagController::class, 'selectTags'])->name('tags.select-tags');
    ##########################################


    ################ COMPANY ################
    Route::apiResource('/company', CompanyController::class);
    ##########################################


    ################ TEAM ####################
    Route::get('team/select-members', [TeamController::class, 'selectMembers'])->name('tags.select-members');
    Route::apiResource('/team', TeamController::class);
    ##########################################


    ################ GENERAL INFO ################
    Route::apiResource('/general-info', GeneralInfoController::class);
    ##############################################


    ################ INFO CATEGORY ################
    Route::apiResource('/info-category', InfoCategoryController::class);
    Route::get('/info-categories', [InfoCategoryController::class, 'getAll'])->name('info-categories');
    ###############################################


    ################ FAQ #####################
    Route::apiResource('/faqs', FaqController::class);
    Route::apiResource('/contacts', ContactController::class);
    Route::apiResource('/users', UserController::class);
    ##########################################


    ################ IMAGES ##################
    Route::apiResource('models.images', ImageController::class)->only(['index', 'store', 'destroy']);
    Route::post('images/update-order/{image}', [ImageController::class, 'updateOrder'])->name('images.update-order');
    ##########################################


    ################ HOMEPAGE ################
    Route::apiResource('homepage', HomepageController::class)->only(['index', 'update']);
    ##########################################


    ################ TESTIMONIALS ################
    Route::apiResource('testimonials', TestimonialController::class);
    ##############################################


    ################ TRANSLATIONS ################
    Route::get('/translations', [StaticFields::class, 'index'])->name('static-fields');
    Route::put('/translations', [StaticFields::class, 'update'])->name('update-static-fields');
    ##############################################


    ################ FOOTER ##################
    Route::apiResource('footer', FooterController::class);
    ##########################################


    ################ NEWSLETTER ################
    Route::get('newsletter/export', [NewsletterController::class, 'export'])->name('newsletter.export');
    Route::apiResource('newsletter', NewsletterController::class)->except('store');
    ############################################

});

/*
Route::get('/optimize-clear', function (){
    Artisan::call('optimize:clear');
    dd('ok');
});

Route::get('/migrate-fresh-seed', function () {
    Artisan::call('migrate:fresh --seed');
    dd('ok');
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    dd('ok');
});

Route::get('/storage-link-php', function () {
    $target = '/home/dhubmeef/public_html/ivmax/storage/app/public';
    $shortcut = '/home/dhubmeef/public_html/ivmax/public/media';
    symlink($target, $shortcut);
});
*/
