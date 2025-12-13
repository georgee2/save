<?php

use Illuminate\Support\Facades\Route;
use Modules\Basicdata\App\Http\Controllers\BasicdataController;
use Modules\Basicdata\App\Http\Controllers\ProjectTypeController;
use Modules\Basicdata\App\Http\Controllers\EngineeringCategoryController;
use Modules\Basicdata\App\Http\Controllers\EngineeringSubCategoryController;
use Modules\Basicdata\App\Http\Controllers\ProjectStyleController;
use Modules\Basicdata\App\Http\Controllers\AmenityController;
use Modules\Basicdata\App\Http\Controllers\BuildingComponentController;
use Modules\Basicdata\App\Http\Controllers\FloorComponentController;
use Modules\Basicdata\App\Http\Controllers\IncomeComponentController;
use Modules\Basicdata\App\Http\Controllers\LengthComponentController;
use Modules\Basicdata\App\Http\Controllers\CurrencyController;
use Modules\Basicdata\App\Http\Controllers\SpecificationController;
use Modules\Basicdata\App\Http\Controllers\SubstationRoomController;
use Modules\Basicdata\App\Http\Controllers\PumpsRoomController;
use Modules\Basicdata\App\Http\Controllers\FeasibilityStudyComponentController;
use Modules\Basicdata\App\Http\Controllers\PortfolioTypeController;
use Modules\Basicdata\App\Http\Controllers\JobTitleController;
use Modules\Basicdata\App\Http\Controllers\JobCategoryController;
use Modules\Basicdata\App\Http\Controllers\RankController;
use Modules\Basicdata\App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    ['prefix' => LaravelLocalization::setLocale(), 
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' , 'middleware' => 'auth']],
    function () {

        Route::prefix('basicdata')->group(function () {

            // Basicdata Dashboard Route
            Route::get('/', [BasicdataController::class, 'index'])->name('Basicdata');

            // Project Types Routes
            Route::prefix('projecttype')->group(function () {
                Route::get('/index', [ProjectTypeController::class, 'index'])->name('projecttype.index');
                Route::get('/create', [ProjectTypeController::class, 'create'])->name('projecttype.create');
                Route::post('/store', [ProjectTypeController::class, 'store'])->name('projecttype.store');
                Route::get('/edit/{id}', [ProjectTypeController::class, 'edit'])->name('projecttype.edit');
                Route::post('/update/{id}', [ProjectTypeController::class, 'update'])->name('projecttype.update');
                Route::post('/delete/{id}', [ProjectTypeController::class, 'destroy'])->name('projecttype.delete');
                Route::get('/trashed', [ProjectTypeController::class, 'trashed'])->name('projecttype.trashed');
                Route::post('/restore/{id}', [ProjectTypeController::class, 'restore'])->name('projecttype.restore');
            });

            // Engineering Categories Routes
            Route::prefix('engineeringcategory')->group(function () {
                Route::get('/index', [EngineeringCategoryController::class, 'index'])->name('engineeringcategory.index');
                Route::get('/create', [EngineeringCategoryController::class, 'create'])->name('engineeringcategory.create');
                Route::post('/store', [EngineeringCategoryController::class, 'store'])->name('engineeringcategory.store');
                Route::get('/show/{id}', [EngineeringCategoryController::class, 'show'])->name('engineeringcategory.show');
                Route::get('/edit/{id}', [EngineeringCategoryController::class, 'edit'])->name('engineeringcategory.edit');
                Route::post('/update/{id}', [EngineeringCategoryController::class, 'update'])->name('engineeringcategory.update');
                Route::post('/delete/{id}', [EngineeringCategoryController::class, 'destroy'])->name('engineeringcategory.delete');
                Route::get('/trashed', [EngineeringCategoryController::class, 'trashed'])->name('engineeringcategory.trashed');
                Route::post('/restore/{id}', [EngineeringCategoryController::class, 'restore'])->name('engineeringcategory.restore');
            });

            // Engineering Sub Categories Routes
            Route::prefix('engineeringsubcategory')->group(function () {
                Route::get('/index', [EngineeringSubCategoryController::class, 'index'])->name('engineeringsubcategory.index');
                Route::get('/create', [EngineeringSubCategoryController::class, 'create'])->name('engineeringsubcategory.create');
                Route::post('/store', [EngineeringSubCategoryController::class, 'store'])->name('engineeringsubcategory.store');
                Route::get('/show/{id}', [EngineeringSubCategoryController::class, 'show'])->name('engineeringsubcategory.show');
                Route::get('/edit/{id}', [EngineeringSubCategoryController::class, 'edit'])->name('engineeringsubcategory.edit');
                Route::post('/update/{id}', [EngineeringSubCategoryController::class, 'update'])->name('engineeringsubcategory.update');
                Route::post('/delete/{id}', [EngineeringSubCategoryController::class, 'destroy'])->name('engineeringsubcategory.delete');
                Route::get('/trashed', [EngineeringSubCategoryController::class, 'trashed'])->name('engineeringsubcategory.trashed');
                Route::post('/restore/{id}', [EngineeringSubCategoryController::class, 'restore'])->name('engineeringsubcategory.restore');
            });

            // Project Styles Routes
            Route::prefix('projectstyle')->group(function () {
                Route::get('/index', [ProjectStyleController::class, 'index'])->name('projectstyle.index');
                Route::get('/create', [ProjectStyleController::class, 'create'])->name('projectstyle.create');
                Route::post('/store', [ProjectStyleController::class, 'store'])->name('projectstyle.store');
                Route::get('/edit/{id}', [ProjectStyleController::class, 'edit'])->name('projectstyle.edit');
                Route::post('/update/{id}', [ProjectStyleController::class, 'update'])->name('projectstyle.update');
                Route::post('/delete/{id}', [ProjectStyleController::class, 'destroy'])->name('projectstyle.delete');
                Route::get('/trashed', [ProjectStyleController::class, 'trashed'])->name('projectstyle.trashed');
                Route::post('/restore/{id}', [ProjectStyleController::class, 'restore'])->name('projectstyle.restore');
            });

            // Amenities Routes
            Route::prefix('amenity')->group(function () {
                Route::get('/index', [AmenityController::class, 'index'])->name('amenity.index');
                Route::get('/create', [AmenityController::class, 'create'])->name('amenity.create');
                Route::post('/store', [AmenityController::class, 'store'])->name('amenity.store');
                Route::get('/edit/{id}', [AmenityController::class, 'edit'])->name('amenity.edit');
                Route::post('/update/{id}', [AmenityController::class, 'update'])->name('amenity.update');
                Route::post('/delete/{id}', [AmenityController::class, 'destroy'])->name('amenity.delete');
                Route::get('/trashed', [AmenityController::class, 'trashed'])->name('amenity.trashed');
                Route::post('/restore/{id}', [AmenityController::class, 'restore'])->name('amenity.restore');
            });

            // Building Components Routes
            Route::prefix('buildingcomponent')->group(function () {
                Route::get('/index', [BuildingComponentController::class, 'index'])->name('buildingcomponent.index');
                Route::get('/create', [BuildingComponentController::class, 'create'])->name('buildingcomponent.create');
                Route::post('/store', [BuildingComponentController::class, 'store'])->name('buildingcomponent.store');
                Route::get('/edit/{id}', [BuildingComponentController::class, 'edit'])->name('buildingcomponent.edit');
                Route::post('/update/{id}', [BuildingComponentController::class, 'update'])->name('buildingcomponent.update');
                Route::post('/delete/{id}', [BuildingComponentController::class, 'destroy'])->name('buildingcomponent.delete');
                Route::get('/trashed', [BuildingComponentController::class, 'trashed'])->name('buildingcomponent.trashed');
                Route::post('/restore/{id}', [BuildingComponentController::class, 'restore'])->name('buildingcomponent.restore');
            });

            // Floor Components Routes
            Route::prefix('floorcomponent')->group(function () {
                Route::get('/index', [FloorComponentController::class, 'index'])->name('floorcomponent.index');
                Route::get('/create', [FloorComponentController::class, 'create'])->name('floorcomponent.create');
                Route::post('/store', [FloorComponentController::class, 'store'])->name('floorcomponent.store');
                Route::get('/edit/{id}', [FloorComponentController::class, 'edit'])->name('floorcomponent.edit');
                Route::post('/update/{id}', [FloorComponentController::class, 'update'])->name('floorcomponent.update');
                Route::post('/delete/{id}', [FloorComponentController::class, 'destroy'])->name('floorcomponent.delete');
                Route::get('/trashed', [FloorComponentController::class, 'trashed'])->name('floorcomponent.trashed');
                Route::post('/restore/{id}', [FloorComponentController::class, 'restore'])->name('floorcomponent.restore');
            });

            // Income Components Routes
            Route::prefix('incomecomponent')->group(function () {
                Route::get('/index', [IncomeComponentController::class, 'index'])->name('incomecomponent.index');
                Route::get('/create', [IncomeComponentController::class, 'create'])->name('incomecomponent.create');
                Route::post('/store', [IncomeComponentController::class, 'store'])->name('incomecomponent.store');
                Route::get('/edit/{id}', [IncomeComponentController::class, 'edit'])->name('incomecomponent.edit');
                Route::post('/update/{id}', [IncomeComponentController::class, 'update'])->name('incomecomponent.update');
                Route::post('/delete/{id}', [IncomeComponentController::class, 'destroy'])->name('incomecomponent.delete');
                Route::get('/trashed', [IncomeComponentController::class, 'trashed'])->name('incomecomponent.trashed');
                Route::post('/restore/{id}', [IncomeComponentController::class, 'restore'])->name('incomecomponent.restore');
            });

            // Length Components Routes
            Route::prefix('lengthcomponent')->group(function () {
                Route::get('/index', [LengthComponentController::class, 'index'])->name('lengthcomponent.index');
                Route::get('/create', [LengthComponentController::class, 'create'])->name('lengthcomponent.create');
                Route::post('/store', [LengthComponentController::class, 'store'])->name('lengthcomponent.store');
                Route::get('/edit/{id}', [LengthComponentController::class, 'edit'])->name('lengthcomponent.edit');
                Route::post('/update/{id}', [LengthComponentController::class, 'update'])->name('lengthcomponent.update');
                Route::post('/delete/{id}', [LengthComponentController::class, 'destroy'])->name('lengthcomponent.delete');
                Route::get('/trashed', [LengthComponentController::class, 'trashed'])->name('lengthcomponent.trashed');
                Route::post('/restore/{id}', [LengthComponentController::class, 'restore'])->name('lengthcomponent.restore');
                Route::get('/get-building-components', [LengthComponentController::class, 'getBuildingComponents'])->name('lengthcomponent.get-building-components');
            });

            // Currencies Routes
            Route::prefix('currency')->group(function () {
                Route::get('/index', [CurrencyController::class, 'index'])->name('currency.index');
                Route::get('/create', [CurrencyController::class, 'create'])->name('currency.create');
                Route::post('/store', [CurrencyController::class, 'store'])->name('currency.store');
                Route::get('/edit/{id}', [CurrencyController::class, 'edit'])->name('currency.edit');
                Route::post('/update/{id}', [CurrencyController::class, 'update'])->name('currency.update');
                Route::post('/delete/{id}', [CurrencyController::class, 'destroy'])->name('currency.delete');
                Route::get('/trashed', [CurrencyController::class, 'trashed'])->name('currency.trashed');
                Route::post('/restore/{id}', [CurrencyController::class, 'restore'])->name('currency.restore');
            });

            // Specifications Routes
            Route::prefix('specification')->group(function () {
                Route::get('/index', [SpecificationController::class, 'index'])->name('specification.index');
                Route::get('/create', [SpecificationController::class, 'create'])->name('specification.create');
                Route::post('/store', [SpecificationController::class, 'store'])->name('specification.store');
                Route::get('/edit/{id}', [SpecificationController::class, 'edit'])->name('specification.edit');
                Route::post('/update/{id}', [SpecificationController::class, 'update'])->name('specification.update');
                Route::post('/delete/{id}', [SpecificationController::class, 'destroy'])->name('specification.delete');
                Route::get('/trashed', [SpecificationController::class, 'trashed'])->name('specification.trashed');
                Route::post('/restore/{id}', [SpecificationController::class, 'restore'])->name('specification.restore');
            });

            // Substation Rooms Routes
            Route::prefix('substationroom')->group(function () {
                Route::get('/index', [SubstationRoomController::class, 'index'])->name('substationroom.index');
                Route::get('/create', [SubstationRoomController::class, 'create'])->name('substationroom.create');
                Route::post('/store', [SubstationRoomController::class, 'store'])->name('substationroom.store');
                Route::get('/edit/{id}', [SubstationRoomController::class, 'edit'])->name('substationroom.edit');
                Route::post('/update/{id}', [SubstationRoomController::class, 'update'])->name('substationroom.update');
                Route::post('/delete/{id}', [SubstationRoomController::class, 'destroy'])->name('substationroom.delete');
                Route::get('/trashed', [SubstationRoomController::class, 'trashed'])->name('substationroom.trashed');
                Route::post('/restore/{id}', [SubstationRoomController::class, 'restore'])->name('substationroom.restore');
            });

            // Pumps Rooms Routes
            Route::prefix('pumpsroom')->group(function () {
                Route::get('/index', [PumpsRoomController::class, 'index'])->name('pumpsroom.index');
                Route::get('/create', [PumpsRoomController::class, 'create'])->name('pumpsroom.create');
                Route::post('/store', [PumpsRoomController::class, 'store'])->name('pumpsroom.store');
                Route::get('/edit/{id}', [PumpsRoomController::class, 'edit'])->name('pumpsroom.edit');
                Route::post('/update/{id}', [PumpsRoomController::class, 'update'])->name('pumpsroom.update');
                Route::post('/delete/{id}', [PumpsRoomController::class, 'destroy'])->name('pumpsroom.delete');
                Route::get('/trashed', [PumpsRoomController::class, 'trashed'])->name('pumpsroom.trashed');
                Route::post('/restore/{id}', [PumpsRoomController::class, 'restore'])->name('pumpsroom.restore');
            });

            // Feasibility Study Components Routes
            Route::prefix('feasibilitystudycomponent')->group(function () {
                Route::get('/index', [FeasibilityStudyComponentController::class, 'index'])->name('feasibilitystudycomponent.index');
                Route::get('/create', [FeasibilityStudyComponentController::class, 'create'])->name('feasibilitystudycomponent.create');
                Route::post('/store', [FeasibilityStudyComponentController::class, 'store'])->name('feasibilitystudycomponent.store');
                Route::get('/edit/{id}', [FeasibilityStudyComponentController::class, 'edit'])->name('feasibilitystudycomponent.edit');
                Route::post('/update/{id}', [FeasibilityStudyComponentController::class, 'update'])->name('feasibilitystudycomponent.update');
                Route::post('/delete/{id}', [FeasibilityStudyComponentController::class, 'destroy'])->name('feasibilitystudycomponent.delete');
                Route::get('/trashed', [FeasibilityStudyComponentController::class, 'trashed'])->name('feasibilitystudycomponent.trashed');
                Route::post('/restore/{id}', [FeasibilityStudyComponentController::class, 'restore'])->name('feasibilitystudycomponent.restore');
            });

            // Portfolio Types Routes
            Route::prefix('portfoliotype')->group(function () {
                Route::get('/index', [PortfolioTypeController::class, 'index'])->name('portfoliotype.index');
                Route::get('/create', [PortfolioTypeController::class, 'create'])->name('portfoliotype.create');
                Route::post('/store', [PortfolioTypeController::class, 'store'])->name('portfoliotype.store');
                Route::get('/edit/{id}', [PortfolioTypeController::class, 'edit'])->name('portfoliotype.edit');
                Route::post('/update/{id}', [PortfolioTypeController::class, 'update'])->name('portfoliotype.update');
                Route::post('/delete/{id}', [PortfolioTypeController::class, 'destroy'])->name('portfoliotype.delete');
                Route::get('/trashed', [PortfolioTypeController::class, 'trashed'])->name('portfoliotype.trashed');
                Route::post('/restore/{id}', [PortfolioTypeController::class, 'restore'])->name('portfoliotype.restore');
            });

            // Job Titles Routes
            Route::prefix('jobtitle')->group(function () {
                Route::get('/index', [JobTitleController::class, 'index'])->name('jobtitle.index');
                Route::get('/create', [JobTitleController::class, 'create'])->name('jobtitle.create');
                Route::post('/store', [JobTitleController::class, 'store'])->name('jobtitle.store');
                Route::get('/edit/{id}', [JobTitleController::class, 'edit'])->name('jobtitle.edit');
                Route::post('/update/{id}', [JobTitleController::class, 'update'])->name('jobtitle.update');
                Route::post('/delete/{id}', [JobTitleController::class, 'destroy'])->name('jobtitle.delete');
                Route::get('/trashed', [JobTitleController::class, 'trashed'])->name('jobtitle.trashed');
                Route::post('/restore/{id}', [JobTitleController::class, 'restore'])->name('jobtitle.restore');
            });

            // Job Categories Routes
            Route::prefix('jobcategory')->group(function () {
                Route::get('/index', [JobCategoryController::class, 'index'])->name('jobcategory.index');
                Route::get('/create', [JobCategoryController::class, 'create'])->name('jobcategory.create');
                Route::post('/store', [JobCategoryController::class, 'store'])->name('jobcategory.store');
                Route::get('/edit/{id}', [JobCategoryController::class, 'edit'])->name('jobcategory.edit');
                Route::post('/update/{id}', [JobCategoryController::class, 'update'])->name('jobcategory.update');
                Route::post('/delete/{id}', [JobCategoryController::class, 'destroy'])->name('jobcategory.delete');
                Route::get('/trashed', [JobCategoryController::class, 'trashed'])->name('jobcategory.trashed');
                Route::post('/restore/{id}', [JobCategoryController::class, 'restore'])->name('jobcategory.restore');
            });

            // Ranks Routes
            Route::prefix('rank')->group(function () {
                Route::get('/index', [RankController::class, 'index'])->name('rank.index');
                Route::get('/create', [RankController::class, 'create'])->name('rank.create');
                Route::post('/store', [RankController::class, 'store'])->name('rank.store');
                Route::get('/edit/{id}', [RankController::class, 'edit'])->name('rank.edit');
                Route::post('/update/{id}', [RankController::class, 'update'])->name('rank.update');
                Route::post('/delete/{id}', [RankController::class, 'destroy'])->name('rank.delete');
                Route::get('/trashed', [RankController::class, 'trashed'])->name('rank.trashed');
                Route::post('/restore/{id}', [RankController::class, 'restore'])->name('rank.restore');
            });

            // Language Manager Routes
            Route::prefix('language')->group(function () {
                Route::get('/index', [LanguageController::class, 'index'])->name('language.index');
                Route::get('/edit/{key}', [LanguageController::class, 'edit'])->name('language.edit');
                Route::post('/update/{key}', [LanguageController::class, 'update'])->name('language.update');
            });

        });
    }
);
