<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\RoleController;

use App\Http\Controllers\Agent\AgentPropertyController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CompareController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// User Frontend All Route
Route::get('/', [UserController::class, 'Index']);

Route::get('/dashboard', function(){
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function(){

    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');

    Route::get('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');

    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');

    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');

    Route::get('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');

    Route::get('/user/schedule/request', [UserController::class, 'UserScheduleRequest'])->name('user.schedule.request');
    // User Wishlist All Route
    Route::controller(WishlistController::class)->group(function(){
        Route::get('/user/wishlist', 'UserWishlist')->name('user.wishlist');
        Route::get('/get-wishlist-property', 'GetWishlistProperty');
        Route::get('/wishlist-remmove/{id}', 'WishlistRemove');
    });

    //User Compare All Route
    Route::controller(CompareController::class)->group(function(){
        Route::get('/user/compare', 'UserCompare')->name('user.compare');
        Route::get('/get-compare-property', 'GetCompareProperty');
        Route::get('/compare-remmove/{id}', 'CompareRemove');
    }); 
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

// Admin Group Middleware
Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');

    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');

    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');

    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');

}); // End Group Admin Middleware

// Agent Group Middleware
Route::middleware(['auth','role:agent'])->group(function(){
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');
}); // End Group Admin Middleware
     
     Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

// Admin Group Middleware
Route::middleware(['auth','role:admin'])->group(function(){

// Property Type All Route
    Route::controller(PropertyTypeController::class)->group(function(){
        Route::get('/all/type', 'AllType')->name('all.type');

        Route::get('/add/type', 'AddType')->name('add.type');

        Route::POST('/store/type', 'StoreType')->name('store.type');

        Route::get('/edit/type/{id}', 'EditType')->name('edit.type');

        Route::POST('/update/type', 'UpdateType')->name('update.type');

        Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');

    });

    // Amenities Type All Route
    Route::controller(PropertyTypeController::class)->group(function(){
        Route::get('/all/amenitie', 'AllAmenitie')->name('all.amenitie');

        Route::get('/add/amenitie', 'AddAmenitie')->name('add.amenitie');

        Route::POST('/store/amenitie', 'StoreAmenitie')->name('store.amenitie');

        Route::get('/edit/amenitie/{id}', 'EditAmenitie')->name('edit.amenitie');

        Route::POST('/update/amenitie', 'UpdateAmenitie')->name('update.amenitie');

        Route::get('/delete/amenitie/{id}', 'DeleteAmenitie')->name('delete.amenitie');

    });

    // Property All Route
    Route::controller(PropertyController::class)->group(function(){
        Route::get('/all/property', 'AllProperty')->name('all.property');
        Route::get('/add/property', 'AddProperty')->name('add.property');
        Route::Post('/store/property', 'StoreProperty')->name('store.property');
        Route::get('/edit/property{id}', 'EditProperty')->name('edit.property');
        Route::get('/update/property', 'UpdateProperty')->name('update.property');
        Route::get('/update/property/thambnail', 'UpdatePropertyThambnail')->name('update.property.thambnail');
        Route::get('/update/property/multiimage', 'UpdatePropertyMultiimage')->name('update.property.multiimage');
        Route::get('/property/multiimg/delete/{id}', 'PropertyMultiImgDelete')->name('property.multiimg.delete');
        Route::get('/store/new/multiimage', 'StoreNewMultiimage')->name('store.new.multiimage');
        Route::post('/update/property/facilities', 'UpdatePropertyFacilities')->name('update.property.facilities');
        Route::get('/delete/property/{id}', 'DeleteProperty')->name('delete.property');
        Route::get('/details/property/{id}', 'DetailsProperty')->name('details.property');
        Route::post('/inactive/property', 'InactiveProperty')->name('inactive.property');
        Route::post('/active/property', 'ActiveProperty')->name('active.property');
        Route::get('/admin/package/history', 'AdminPackageHistory')->name('admin.package.history');
        Route::get('/package/invoice/{id}', 'PackageInvoice')->name('package.invoice');
        Route::get('/admin/property/message', 'AdminPropertyMessage')->name('admin.property.message');

    });

    // Agent All Route from admin
Route::controller(AdminController::class)->group(function(){
    Route::get('/all/agent', 'AllAgent')->name('all.agent');
    Route::get('/add/agent', 'AddAgent')->name('add.agent');
    Route::post('/store/agent', 'StoreAgent')->name('store.agent');
    Route::get('/edit/agent', 'EditAgent')->name('edit.agent');
    Route::post('/update/agent', 'UpdateAgent')->name('update.agent');
    Route::get('/delete/agent/{id}', 'DeleteAgent')->name('delete.agent');
    Route::get('/changeStatus', 'changeStatus');
});

// State All Route
Route::controller(StateController::class)->group(function(){
    Route::get('/all/state', 'AllState')->name('all.state');
    Route::get('/add/state', 'AddState')->name('add.state');
    Route::post('/store/state', 'StoreState')->name('store.state');
    Route::get('/edit/state', 'EditState')->name('edit.state');
    Route::post('/update/state', 'UpdateState')->name('update.state');
    Route::get('/delete/state/{id}', 'DeleteState')->name('delete.state');
});

// Testimonials All Route
Route::controller(TestimonialController::class)->group(function(){
    Route::get('/all/testimonials', 'AllTestimonials')->name('all.testimonials');
    Route::get('/add/testimonials', 'AddTestimonials')->name('add.testimonials');
    Route::post('/store/testimonials', 'StoreTestimonials')->name('store.testimonials');
    Route::get('/edit/testimonials', 'EditTestimonials')->name('edit.testimonials');
    Route::post('/update/testimonials', 'UpdateTestimonials')->name('update.testimonials');
    Route::get('/delete/testimonials/{id}', 'DeleteTestimonials')->name('delete.testimonials');
});

// Blog Category All Route
Route::controller(BlogController::class)->group(function(){
    Route::get('/all/blog/category', 'AllBlogCategory')->name('all.blog.category');
    Route::post('/store/blog/category', 'StoreBlogCategory')->name('store.blog.category');
    Route::get('/edit/blog/category', 'EditBlogCategory')->name('edit.blog.category');
    Route::post('/update/blog/category', 'UpdateBlogCategory')->name('update.blog.category');
    Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category');
});

// Testimonials All Route
Route::controller(BlogController::class)->group(function(){
    Route::get('/all/post', 'AllPost')->name('all.post');
    Route::get('/add/post', 'AddPost')->name('add.post');
    Route::get('/store/post', 'StorePost')->name('store.post');
    Route::get('/edit/post', 'EditPost')->name('edit.post');
    Route::get('/update/post', 'UpdatePost')->name('update.post');
    Route::get('/delete/post/{id}', 'DeletePost')->name('delete.post');
});

// SMTP Setting All Route
Route::controller(SettingController::class)->group(function(){
    Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting');
    Route::post('/update/smtp/setting', 'UpdateSmtpSetting')->name('update.smtp.setting');
});

// Site Setting All Route
Route::controller(SettingController::class)->group(function(){
    Route::get('/site/setting', 'SiteSetting')->name('site.setting');
    Route::post('/update/site/setting', 'UpdateSiteSetting')->name('update.site.setting');
});

}); // End Group Admin Middleware