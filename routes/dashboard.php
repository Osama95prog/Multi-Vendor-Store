<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ImportPoroductsController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => ['auth:admin',],
    // 'middleware' => ['auth','auth.type:admin,super-admin'],
    'as' => 'dashboard.',
    'prefix' => 'admin/dashboard',

],function(){
    Route::get('/categories/trash',[CategoriesController::class,'trash'])
        ->name('categories.trash') ;
    Route::put('/categories/{category}/restore',[CategoriesController::class,'restore'])
        ->name('categories.restore') ;
    Route::delete('/categories/{category}/force-delete',[CategoriesController::class,'forceDelete'])
        ->name('categories.force-delete') ;

    // Route::resource('/categories',CategoriesController::class);
    // Route::resource('/products',ProductsController::class);

    Route::get('/products/import',[ImportPoroductsController::class,'create'])
    ->name('products.import') ;
    // this route does not have name because it is similar to the previous one and it inherite the name, notice that the deiffernce is in the method type
    Route::post('/products/import',[ImportPoroductsController::class,'store']);

    /* important nots
        we put the products resource after the get: products import
        because the resource has the products/{product}
        for the show route and to make sure that
        the show route has not overwrite
        the proudcts/import route we put it after
        as laravel might think that the
         products/{product} is products/import
         and product = import ..
    */
    Route::resources([
        'products' => ProductsController::class,
        'categories' => CategoriesController::class,
        'roles' => RolesController::class, // not done yet
        'users' => UsersController::class, // not done yet
    ]);

    Route::get('/profile/edit',[ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile/update',[ProfileController::class,'update'])->name('profile.update');


});
