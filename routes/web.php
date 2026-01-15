<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\EventController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\AlumniSectionController;
use App\Http\Controllers\Backend\FrontendSectionController;
use App\Http\Controllers\Backend\MachineTransferController;
use App\Http\Controllers\Backend\PublicDashboardController;
use App\Http\Controllers\Backend\PublicMachineDashboardController;


// .............................. FRONTEND ROUTES .................................... //

Route::get('/homePage', [FrontendController::class, 'index'])->name('public.homePage');
Route::get('/product', [FrontendController::class, 'product'])->name('public.product');
Route::get('/productDetails/{id}', [FrontendController::class, 'productDetails'])->name('public.productDetails');


Route::get('/cart', [CartController::class, 'index'])->name('cart'); // Change from FrontendController to CartController
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');



Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/order/{order}', [CheckoutController::class, 'show'])->name('checkout.show');
});



Route::get('/tasbih', function () {
    return view('frontend.tasbih');
})->name('tasbih');

Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');


// .............................. FRONTEND ROUTES .................................... //

// Auth route
Route::post('login-post', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('signup', [LoginController::class, 'signup'])->name('registration.post');

// admin route start
Route::get('/', function () {
    return view('backend.auth.login');
})->name('admin');


// .............................. BACKEND ROUTES .................................... //

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('profile', [LoginController::class, 'adminProfile'])->name('admin.profile');
    Route::post('profile/update', [LoginController::class, 'adminProfileUpdate'])->name('admin.profile.update');
    Route::get('profile/setting', [LoginController::class, 'adminProfileSetting'])->name('admin.profile.setting');
    Route::post('profile/change/password', [LoginController::class, 'adminChangePassword'])->name('admin.change.password');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.index');

    // Route::any('{any}',[FrontendController::class,'catchAll'])->where('any', '.*');

    Route::group(['prefix' => '/user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user');
        Route::get('/get/list', [UserController::class, 'getList']);
        Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::any('/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('admin.user.delete');
        Route::post('/change', [UserController::class, 'changePassword'])->name('admin.user.changepassword');
        Route::post('/admin/user/update-status', [UserController::class, 'updateStatus'])->name('user.updateStatus');
    });

    Route::group(['prefix' => '/role'], function () {
        Route::get('/generate/right/{mdule_name}', [RoleController::class, 'generate'])->name('admin.role.right.generate');

        Route::get('/', [RoleController::class, 'index'])->name('admin.role');
        Route::get('/get/role/list', [RoleController::class, 'getRoleList']);
        Route::get('/create', [RoleController::class, 'create'])->name('admin.role.create');
        Route::post('/store', [RoleController::class, 'store'])->name('admin.role.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('admin.role.edit');
        Route::any('/update/{id}', [RoleController::class, 'update'])->name('admin.role.update');
        Route::get('/delete/{id}', [RoleController::class, 'delete'])->name('admin.role.delete');

        Route::get('/right', [RoleController::class, 'right'])->name('admin.role.right');
        Route::get('/get/right/list', [RoleController::class, 'getRightList']);
        Route::post('/right/store', [RoleController::class, 'rightStore'])->name('admin.role.right.store');
        Route::get('/right/edit/{id}', [RoleController::class, 'editRight'])->name('admin.role.right.edit');
        Route::any('/right/update/{id}', [RoleController::class, 'roleRightUpdate'])->name('admin.role.right.update');
        Route::get('/right/delete/{id}', [RoleController::class, 'rightDelete'])->name('admin.role.right.delete');
    });



    // Category Routes
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('admin.category.delete');
        Route::get('/status/{id}', [CategoryController::class, 'toggleStatus'])->name('admin.category.status');
        Route::post('/get-list', [CategoryController::class, 'getList'])->name('admin.category.getList');
    });

    Route::group(['prefix' => 'admin/subcategory'], function () {
        Route::get('/', [SubCategoryController::class, 'index'])->name('admin.subcategory.index');
        Route::get('/create', [SubCategoryController::class, 'create'])->name('admin.subcategory.create');
        Route::post('/store', [SubCategoryController::class, 'store'])->name('admin.subcategory.store');
        Route::get('/edit/{id}', [SubCategoryController::class, 'edit'])->name('admin.subcategory.edit');
        Route::post('/update/{id}', [SubCategoryController::class, 'update'])->name('admin.subcategory.update');
        Route::get('/delete/{id}', [SubCategoryController::class, 'delete'])->name('admin.subcategory.delete');
        Route::get('/status/{id}', [SubCategoryController::class, 'toggleStatus'])->name('admin.subcategory.status');
        Route::post('/get-list', [SubCategoryController::class, 'getList'])->name('admin.subcategory.getList');
        Route::get('/get-by-category/{categoryId}', [SubCategoryController::class, 'getByCategory'])->name('admin.subcategory.getByCategory');
    });

    // Product Routes
    Route::group(['prefix' => 'admin/product'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/view/{id}', [ProductController::class, 'view'])->name('admin.product.view');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('admin.product.delete');
        Route::get('/status/{id}', [ProductController::class, 'toggleStatus'])->name('admin.product.status');
        Route::post('/get-list', [ProductController::class, 'getList'])->name('admin.product.getList');
        Route::get('/get-subcategories/{categoryId}', [ProductController::class, 'getSubcategories'])->name('admin.product.getSubcategories');

        // Image management routes for products (AJAX)
        Route::post('/update-image-order', [ProductController::class, 'updateImageOrder'])->name('admin.product.update-image-order');
        Route::delete('/delete-image/{id}', [ProductController::class, 'deleteImage'])->name('admin.product.delete-image');
        Route::post('/set-primary-image/{id}', [ProductController::class, 'setPrimaryImage'])->name('admin.product.set-primary-image');
    });

    // ..................................  WashTusuka Routes ....................................

    // unit routes
    Route::group(['prefix' => '/unit'], function () {
        Route::get('/', [UnitController::class, 'index'])->name('admin.unit.user');
        Route::get('/get/list', [UnitController::class, 'getList']);
        Route::post('/store', [UnitController::class, 'store'])->name('admin.unit.store');
        Route::get('/edit/{id}', [UnitController::class, 'edit'])->name('admin.unit.edit');
        Route::any('/update/{id}', [UnitController::class, 'update'])->name('admin.unit.update');
        Route::get('/delete/{id}', [UnitController::class, 'delete'])->name('admin.unit.delete');
    });

    Route::get('/admin/unit/get/workorders/list', [UnitController::class, 'getWorkOrdersList'])->name('unit.workorders.list');

    //machine transfer
    Route::group(['prefix' => '/machine-tranfer'], function () {
        Route::get('/', [MachineTransferController::class, 'index'])->name('admin.machineTrans.user');
        Route::get('/get/list', [MachineTransferController::class, 'getList'])->name('admin.machineTrans.getList');
        Route::post('/store', [MachineTransferController::class, 'store'])->name('admin.machineTrans.store');
        Route::get('/edit/{id}', [MachineTransferController::class, 'edit'])->name('admin.machineTrans.edit');
        Route::any('/update/{id}', [MachineTransferController::class, 'update'])->name('admin.machineTrans.update');
        Route::get('/delete/{id}', [MachineTransferController::class, 'delete'])->name('admin.machineTrans.delete');
        Route::get('/get-unit-machines/{id}', [MachineTransferController::class, 'getUnitMachines'])->name('admin.machineTrans.getUnitMachines');

        Route::get('/tranfer/dashboard', [MachineTransferController::class, 'dashboard'])->name('admin.machineTrans.dashboard');
        Route::post('/tranfer/dashboard/data', [MachineTransferController::class, 'dashboardData'])->name('admin.machineTrans.dashboard.data');
    });

    Route::get('machine-tranfer/get-units-by-date/{date}', [MachineTransferController::class, 'getUnitsByDate'])->name('admin.machineTrans.getUnitsByDate');
    Route::get('machine-tranfer/refresh/{date}', [MachineTransferController::class, 'refreshTransfersForDate'])->name('admin.machineTrans.refresh');
    Route::get('machine-tranfer/fix-all', [MachineTransferController::class, 'fixAllTransfers'])->name('admin.machineTrans.fixAll');
    Route::post('machine-transfers/wash-dashboard-data', [MachineTransferController::class, 'washDashboardData'])->name('admin.machineTrans.wash.dashboard.data');

    // Machine Transfer Approval Routes
    Route::get('machine-transfer/approvals', [MachineTransferController::class, 'approvals'])->name('machine-transfer.approvals');
    Route::get('machine-transfer/get/pending-list', [MachineTransferController::class, 'getPendingList'])->name('machine-transfer.pending-list');
    Route::post('machine-transfer/approve/{id}', [MachineTransferController::class, 'approve'])->name('machine-transfer.approve');
    Route::post('machine-transfer/reject/{id}', [MachineTransferController::class, 'reject'])->name('machine-transfer.reject');
    Route::get('machine-transfer/{id}', [MachineTransferController::class, 'show'])->name('machine-transfer.show');

    // ..................................  WashTusuka Routes ....................................

    Route::group(['prefix' => '/event'], function () {
        Route::get('/', [EventController::class, 'index'])->name('admin.event');
        Route::get('/get/list', [EventController::class, 'getList']);
        Route::post('/store', [EventController::class, 'store'])->name('admin.event.store');
        Route::get('/edit/{id}', [EventController::class, 'edit'])->name('admin.event.edit');
        Route::any('/update/{id}', [EventController::class, 'update'])->name('admin.event.update');
        Route::get('/delete/{id}', [EventController::class, 'delete'])->name('admin.event.delete');
    });


    Route::group(['prefix' => '/setting'], function () {
        Route::get('/general', [SettingController::class, 'general'])->name('admin.setting.general');
        Route::get('/static-content', [SettingController::class, 'staticContent'])->name('admin.setting.static.content');
        Route::get('/journey-unity-content', [SettingController::class, 'journeyUnityContent'])->name('admin.setting.journey.unity.content');
        Route::get('/setting-alumni-content', [SettingController::class, 'SettingAlumniContent'])->name('admin.setting.alumni-content');
        Route::get('/legal-content', [SettingController::class, 'legalContent'])->name('admin.setting.legal.content');
        Route::post('/update', [SettingController::class, 'update'])->name('admin.setting.update');

        Route::get('/change-language', [SettingController::class, 'changeLanguage'])->name('admin.setting.change.language');
    });

    // Frontend Section
    Route::group(['prefix' => '/frontend-section'], function () {
        Route::get('/journey', [FrontendSectionController::class, 'journey'])->name('admin.frontend.journey');
        Route::post('/update', [FrontendSectionController::class, 'update'])->name('admin.frontend.update');
        Route::post('/alumniBannerSection', [AlumniSectionController::class, 'update'])->name('admin.alumniBannerSection.update');
    });
});

Route::get('admin/logout', [LoginController::class, 'logout'])->name('admin.logout');
// admin route end