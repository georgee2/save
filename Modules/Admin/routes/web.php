<?php

use Illuminate\Support\Facades\Route;

// Use the fully qualified namespace for controllers
use Modules\Admin\App\Http\Controllers\AdminController;
use Modules\Admin\App\Http\Controllers\UsersController;
use Modules\Admin\App\Http\Controllers\NewsCategoriesController;
use Modules\Admin\App\Http\Controllers\NewsController;
use Modules\Admin\App\Http\Controllers\ServiceController;
use Modules\Admin\App\Http\Controllers\ServiceFeatureController;
use Modules\Admin\App\Http\Controllers\ServiceValueController;
use Modules\Admin\App\Http\Controllers\ServiceProcessController;
use Modules\Admin\App\Http\Controllers\ServiceBlockController;
use Modules\Admin\App\Http\Controllers\FAQController;
use Modules\Admin\App\Http\Controllers\ServiceFAQController;
use Modules\Admin\App\Http\Controllers\ServiceSectionOrderController;
use Modules\Admin\App\Http\Controllers\ServiceTitleController;
use Modules\Admin\App\Http\Controllers\PartnerController;
use Modules\Admin\App\Http\Controllers\ProjectController;
use Modules\Admin\App\Http\Controllers\ProjectBuildingComponentController;
use Modules\Admin\App\Http\Controllers\ProjectFloorController;
use Modules\Admin\App\Http\Controllers\ProjectFloorSpecificationController;
use Modules\Admin\App\Http\Controllers\ProjectFloorAmenityController;
use Modules\Admin\App\Http\Controllers\ProjectIncomeComponentController;
use Modules\Admin\App\Http\Controllers\ProjectLengthComponentController;
use Modules\Admin\App\Http\Controllers\ProjectConstructionCostController;
use Modules\Admin\App\Http\Controllers\ProjectSpecificationController;
use Modules\Admin\App\Http\Controllers\FeasibilityStudyController;
use Modules\Admin\App\Http\Controllers\SliderController;
use Modules\Admin\App\Http\Controllers\ContactInformationController;
use Modules\Admin\App\Http\Controllers\AboutInformationController;
use Modules\Admin\App\Http\Controllers\AboutFeatureController;
use Modules\Admin\App\Http\Controllers\AboutCustomBlockController;
use Modules\Admin\App\Http\Controllers\PortfolioController;
use Modules\Admin\App\Http\Controllers\PortfolioProcessController;
use Modules\Admin\App\Http\Controllers\PortfolioImageController;
use Modules\Admin\App\Http\Controllers\ProjectImageController;
use Modules\Admin\App\Http\Controllers\TeamController;
use Modules\Admin\App\Http\Controllers\HomeBlockController;
use Modules\Admin\App\Http\Controllers\CardController;
use Modules\Admin\App\Http\Controllers\HomeContactController;
use Modules\Admin\App\Http\Controllers\ShowcaseController;
use Modules\Admin\App\Http\Controllers\ShowcaseServiceController;
use Modules\Admin\App\Http\Controllers\ShowcaseProjectController;
use Modules\Admin\App\Http\Controllers\ShowcasePortfolioController;
use Modules\Admin\App\Http\Controllers\ShowcaseTeamController;
use Modules\Admin\App\Http\Controllers\ShowcaseNewController;
use Modules\Admin\App\Http\Controllers\HomeFaqController;
use Modules\Admin\App\Http\Controllers\PageBannerController;
use Modules\Admin\App\Http\Controllers\HomeSectionController;
use Modules\Admin\App\Http\Controllers\SiteSettingsController;
use Modules\Admin\App\Http\Controllers\FactController;
use Modules\Admin\App\Http\Controllers\DefaultProcessController;
use Modules\Admin\App\Http\Controllers\DefaultProcessCardController;
use Modules\Admin\App\Http\Controllers\DefaultBannerController;
use Modules\Admin\App\Http\Controllers\OfferController;
use Modules\Admin\App\Http\Controllers\OfferPriceController;
use Modules\Admin\App\Http\Controllers\OfferImageController;
use Modules\Admin\App\Http\Controllers\OfferBuildingComponentController;
use Modules\Admin\App\Http\Controllers\OfferFloorController;
use Modules\Admin\App\Http\Controllers\OfferFloorSpecificationController;
use Modules\Admin\App\Http\Controllers\OfferFloorAmenityController;
use Modules\Admin\App\Http\Controllers\OfferLengthComponentController;
use Modules\Admin\App\Http\Controllers\OfferIncomeComponentController;
use Modules\Admin\App\Http\Controllers\OfferConstructionCostController;
use Modules\Admin\App\Http\Controllers\OfferSpecificationController;
use Modules\Admin\App\Http\Controllers\OfferFeasibilityStudyController;
use Modules\Admin\App\Http\Controllers\InteriorDesignGalleryController;
use Modules\Admin\App\Http\Controllers\MenuController;
use Modules\Admin\App\Http\Controllers\HomeProjectSettingController;
use Modules\Admin\App\Http\Controllers\CertificateController;
use Modules\Admin\App\Http\Controllers\ActivityLogController;
use Modules\Admin\App\Http\Controllers\RoleController;
use Modules\Admin\App\Http\Controllers\UserRoleController;
use Modules\Admin\App\Http\Controllers\HomeInteriorSettingController;
use Modules\Admin\App\Http\Controllers\InteriorCategoryOrderController;
use Modules\Admin\App\Http\Controllers\ContactPageSectionController;
use Modules\Admin\App\Http\Controllers\AboutPageSectionController;
use Modules\Admin\App\Http\Controllers\SeoPageController;
use Modules\Admin\App\Http\Controllers\TranslationController;


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
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' , 'middleware' => 'auth', 'check.route.permission']],
    function () {

        Route::prefix('admin')->group(function () {

            // Admin Dashboard Route
            Route::get('/', [AdminController::class, 'index'])->name('Admin');

            // Translation API Route
            Route::post('/translate', [TranslationController::class, 'translate'])->name('admin.translate');



             // Project Users Routes
            Route::prefix('users')->group(function () {
                Route::get('/create', [UsersController::class, 'create'])->name('users.create');
                Route::post('/store', [UsersController::class, 'store'])->name('users.store');
                Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
                Route::post('/update/{id}', [UsersController::class, 'update'])->name('users.update');
                Route::post('/delete/{id}', [UsersController::class, 'destroy'])->name('users.delete');
                Route::get('/index', [UsersController::class, 'index'])->name('users.index');
            });




             // News Categories Routes
            Route::prefix('newscategories')->group(function () {
                Route::get('/create', [NewsCategoriesController::class, 'create'])->name('newscategories.create');
                Route::post('/store', [NewsCategoriesController::class, 'store'])->name('newscategories.store');
                Route::get('/edit/{id}', [NewsCategoriesController::class, 'edit'])->name('newscategories.edit');
                Route::post('/update/{id}', [NewsCategoriesController::class, 'update'])->name('newscategories.update');
                Route::post('/delete/{id}', [NewsCategoriesController::class, 'destroy'])->name('newscategories.delete');
                Route::get('/index', [NewsCategoriesController::class, 'index'])->name('newscategories.index');
                Route::get('/trashed', [NewsCategoriesController::class, 'trashed'])->name('newscategories.trashed');
                Route::post('/restore/{id}', [NewsCategoriesController::class, 'restore'])->name('newscategories.restore');
            });


            // News  Routes
            Route::prefix('news-back')->group(function () {
                Route::get('/create', [NewsController::class, 'create'])->name('news-back.create');
                Route::post('/store', [NewsController::class, 'store'])->name('news-back.store');
                Route::get('/edit/{id}', [NewsController::class, 'edit'])->name('news-back.edit');
                Route::post('/update/{id}', [NewsController::class, 'update'])->name('news-back.update');
                Route::post('/delete/{id}', [NewsController::class, 'destroy'])->name('news-back.delete');
                Route::get('/index', [NewsController::class, 'index'])->name('news-back.index');
            });


            // Services Routes
            Route::prefix('service')->group(function () {
                Route::get('/create', [ServiceController::class, 'create'])->name('service.create');
                Route::post('/store', [ServiceController::class, 'store'])->name('service.store');
                Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
                Route::post('/update/{id}', [ServiceController::class, 'update'])->name('service.update');
                Route::post('/delete/{id}', [ServiceController::class, 'destroy'])->name('service.delete');
                Route::get('/index', [ServiceController::class, 'index'])->name('service.index');
                Route::get('/show/{id}', [ServiceController::class, 'show'])->name('service.show');
                Route::get('/trashed', [ServiceController::class, 'trashed'])->name('service.trashed');
                Route::post('/restore/{id}', [ServiceController::class, 'restore'])->name('service.restore');
                Route::post('/toggle-publish/{id}', [ServiceController::class, 'togglePublish'])->name('service.toggle-publish');
                Route::post('/toggle-home-feature/{id}', [ServiceController::class, 'toggleHomeFeature'])->name('service.toggle-home-feature');
            });

            // Service Features Routes
            Route::prefix('service-feature')->group(function () {
                Route::post('/store', [ServiceFeatureController::class, 'store'])->name('service-feature.store');
                Route::post('/update/{id}', [ServiceFeatureController::class, 'update'])->name('service-feature.update');
                Route::post('/delete/{id}', [ServiceFeatureController::class, 'destroy'])->name('service-feature.delete');
            });

            // Service Values Routes
            Route::prefix('service-value')->group(function () {
                Route::post('/store', [ServiceValueController::class, 'store'])->name('service-value.store');
                Route::post('/update/{id}', [ServiceValueController::class, 'update'])->name('service-value.update');
                Route::post('/delete/{id}', [ServiceValueController::class, 'destroy'])->name('service-value.delete');
            });

            // Service Processes Routes
            Route::prefix('service-process')->group(function () {
                Route::post('/store', [ServiceProcessController::class, 'store'])->name('service-process.store');
                Route::post('/update/{id}', [ServiceProcessController::class, 'update'])->name('service-process.update');
                Route::post('/delete/{id}', [ServiceProcessController::class, 'destroy'])->name('service-process.delete');
                Route::post('/update-order', [ServiceProcessController::class, 'updateOrder'])->name('service-process.update-order');
            });

            // Service Blocks Routes
            Route::prefix('service-block')->group(function () {
                Route::post('/store', [ServiceBlockController::class, 'store'])->name('service-block.store');
                Route::post('/update/{id}', [ServiceBlockController::class, 'update'])->name('service-block.update');
                Route::post('/delete/{id}', [ServiceBlockController::class, 'destroy'])->name('service-block.delete');
            });

            // FAQ Routes
            Route::prefix('faq')->group(function () {
                Route::get('/index', [FAQController::class, 'index'])->name('faq.index');
                Route::get('/create', [FAQController::class, 'create'])->name('faq.create');
                Route::post('/store', [FAQController::class, 'store'])->name('faq.store');
                Route::get('/edit/{id}', [FAQController::class, 'edit'])->name('faq.edit');
                Route::post('/update/{id}', [FAQController::class, 'update'])->name('faq.update');
                Route::post('/delete/{id}', [FAQController::class, 'destroy'])->name('faq.delete');
                Route::get('/trashed', [FAQController::class, 'trashed'])->name('faq.trashed');
                Route::post('/restore/{id}', [FAQController::class, 'restore'])->name('faq.restore');
            });

            // Service FAQ Routes
            Route::prefix('service-faq')->group(function () {
                Route::post('/store', [ServiceFAQController::class, 'store'])->name('service-faq.store');
                Route::post('/delete/{id}', [ServiceFAQController::class, 'destroy'])->name('service-faq.delete');
            });

            // Service Section Order Routes
            Route::prefix('service-section-order')->group(function () {
                Route::post('/initialize/{serviceId}', [ServiceSectionOrderController::class, 'initializeOrders'])->name('service-section-order.initialize');
                Route::post('/update-orders', [ServiceSectionOrderController::class, 'updateOrders'])->name('service-section-order.update-orders');
                Route::post('/toggle-visibility/{id}', [ServiceSectionOrderController::class, 'toggleVisibility'])->name('service-section-order.toggle-visibility');
                Route::post('/reset/{serviceId}', [ServiceSectionOrderController::class, 'resetOrders'])->name('service-section-order.reset');
            });

            // Service Titles Routes
            Route::prefix('service-title')->group(function () {
                Route::get('/index', [ServiceTitleController::class, 'index'])->name('service-title.index');
                Route::get('/create', [ServiceTitleController::class, 'create'])->name('service-title.create');
                Route::post('/store', [ServiceTitleController::class, 'store'])->name('service-title.store');
                Route::get('/edit/{id}', [ServiceTitleController::class, 'edit'])->name('service-title.edit');
                Route::post('/update/{id}', [ServiceTitleController::class, 'update'])->name('service-title.update');
                Route::post('/delete/{id}', [ServiceTitleController::class, 'destroy'])->name('service-title.delete');
                Route::get('/show/{id}', [ServiceTitleController::class, 'show'])->name('service-title.show');
                Route::get('/trashed', [ServiceTitleController::class, 'trashed'])->name('service-title.trashed');
                Route::post('/restore/{id}', [ServiceTitleController::class, 'restore'])->name('service-title.restore');
            });

            // Partners Routes
            Route::prefix('partner')->group(function () {
                Route::get('/index', [PartnerController::class, 'index'])->name('partner.index');
                Route::get('/create', [PartnerController::class, 'create'])->name('partner.create');
                Route::post('/store', [PartnerController::class, 'store'])->name('partner.store');
                Route::get('/edit/{id}', [PartnerController::class, 'edit'])->name('partner.edit');
                Route::post('/update/{id}', [PartnerController::class, 'update'])->name('partner.update');
                Route::post('/delete/{id}', [PartnerController::class, 'destroy'])->name('partner.delete');
                Route::get('/show/{id}', [PartnerController::class, 'show'])->name('partner.show');
                Route::get('/trashed', [PartnerController::class, 'trashed'])->name('partner.trashed');
                Route::post('/restore/{id}', [PartnerController::class, 'restore'])->name('partner.restore');
                Route::post('/update-order', [PartnerController::class, 'updateOrder'])->name('partner.update-order');
            });
            
            // Slider Routes
            Route::prefix('slider')->group(function () {
                Route::get('/index', [SliderController::class, 'index'])->name('slider.index');
                Route::get('/create', [SliderController::class, 'create'])->name('slider.create');
                Route::post('/store', [SliderController::class, 'store'])->name('slider.store');
                Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
                Route::post('/update/{id}', [SliderController::class, 'update'])->name('slider.update');
                Route::post('/delete/{id}', [SliderController::class, 'destroy'])->name('slider.delete');
                Route::get('/trashed', [SliderController::class, 'trashed'])->name('slider.trashed');
                Route::post('/restore/{id}', [SliderController::class, 'restore'])->name('slider.restore');
                Route::post('/toggle-status/{id}', [SliderController::class, 'toggleStatus'])->name('slider.toggle-status');
                Route::post('/update-orders', [SliderController::class, 'updateOrders'])->name('slider.update-orders');
            });
            
            // Contact Information Routes (Single Row)
            Route::prefix('contact-information')->group(function () {
                Route::get('/', [ContactInformationController::class, 'index'])->name('contact-information.index');
                Route::post('/update', [ContactInformationController::class, 'update'])->name('contact-information.update');
            });
            
            // About Information Routes (Single Row)
            Route::prefix('about-information')->group(function () {
                Route::get('/', [AboutInformationController::class, 'index'])->name('about-information.index');
                Route::post('/update', [AboutInformationController::class, 'update'])->name('about-information.update');
                Route::post('/remove-image', [AboutInformationController::class, 'removeImage'])->name('about-information.remove-image');
            });
            
            // About Features Routes
            Route::prefix('about-feature')->group(function () {
                Route::get('/index', [AboutFeatureController::class, 'index'])->name('about-feature.index');
                Route::get('/create', [AboutFeatureController::class, 'create'])->name('about-feature.create');
                Route::post('/store', [AboutFeatureController::class, 'store'])->name('about-feature.store');
                Route::get('/edit/{id}', [AboutFeatureController::class, 'edit'])->name('about-feature.edit');
                Route::post('/update/{id}', [AboutFeatureController::class, 'update'])->name('about-feature.update');
                Route::post('/delete/{id}', [AboutFeatureController::class, 'destroy'])->name('about-feature.delete');
                Route::get('/trashed', [AboutFeatureController::class, 'trashed'])->name('about-feature.trashed');
                Route::post('/restore/{id}', [AboutFeatureController::class, 'restore'])->name('about-feature.restore');
                Route::post('/toggle-status/{id}', [AboutFeatureController::class, 'toggleStatus'])->name('about-feature.toggle-status');
            });
            
            // About Custom Blocks Routes
            Route::prefix('about-custom-block')->group(function () {
                Route::get('/index', [AboutCustomBlockController::class, 'index'])->name('about-custom-block.index');
                Route::get('/create', [AboutCustomBlockController::class, 'create'])->name('about-custom-block.create');
                Route::post('/store', [AboutCustomBlockController::class, 'store'])->name('about-custom-block.store');
                Route::get('/edit/{id}', [AboutCustomBlockController::class, 'edit'])->name('about-custom-block.edit');
                Route::post('/update/{id}', [AboutCustomBlockController::class, 'update'])->name('about-custom-block.update');
                Route::post('/delete/{id}', [AboutCustomBlockController::class, 'destroy'])->name('about-custom-block.delete');
                Route::get('/trashed', [AboutCustomBlockController::class, 'trashed'])->name('about-custom-block.trashed');
                Route::post('/restore/{id}', [AboutCustomBlockController::class, 'restore'])->name('about-custom-block.restore');
                Route::post('/toggle-status/{id}', [AboutCustomBlockController::class, 'toggleStatus'])->name('about-custom-block.toggle-status');
            });

            // Projects Routes
            Route::prefix('project')->group(function () {
                Route::get('/index', [ProjectController::class, 'index'])->name('project.index');
                Route::get('/create', [ProjectController::class, 'create'])->name('project.create');
                Route::post('/store', [ProjectController::class, 'store'])->name('project.store');
                Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
                Route::post('/update/{id}', [ProjectController::class, 'update'])->name('project.update');
                Route::post('/delete/{id}', [ProjectController::class, 'destroy'])->name('project.delete');
                Route::get('/show/{id}', [ProjectController::class, 'show'])->name('project.show');
                Route::get('/trashed', [ProjectController::class, 'trashed'])->name('project.trashed');
                Route::post('/restore/{id}', [ProjectController::class, 'restore'])->name('project.restore');
                Route::post('/toggle-publish/{id}', [ProjectController::class, 'togglePublish'])->name('project.toggle-publish');
                Route::post('/toggle-home-feature/{id}', [ProjectController::class, 'toggleHomeFeature'])->name('project.toggle-home-feature');
                Route::post('/toggle-feasibility-studies/{id}', [ProjectController::class, 'toggleFeasibilityStudies'])->name('project.toggle-feasibility-studies');
                Route::get('/subcategories', [ProjectController::class, 'getSubcategories'])->name('project.subcategories');
                Route::get('/live-search', [ProjectController::class, 'liveSearch'])->name('project.live-search');
                Route::post('/bulk-publish', [ProjectController::class, 'bulkPublish'])->name('project.bulk-publish');
                Route::post('/bulk-home-status', [ProjectController::class, 'bulkHomeStatus'])->name('project.bulk-home-status');
                
                // Project Building Components Sub-Routes (AJAX)
                Route::prefix('{projectId}/buildingcomponents')->group(function () {
                    Route::get('/available', [ProjectBuildingComponentController::class, 'getAvailableComponents']);
                    Route::post('/store', [ProjectBuildingComponentController::class, 'store']);
                    Route::post('/update/{id}', [ProjectBuildingComponentController::class, 'update']);
                    Route::post('/delete/{id}', [ProjectBuildingComponentController::class, 'destroy']);
                    Route::post('/restore/{id}', [ProjectBuildingComponentController::class, 'restore']);
                });
                
                // Project Income Components Sub-Routes (AJAX)
                Route::prefix('{projectId}/incomecomponents')->group(function () {
                    Route::get('/available', [ProjectIncomeComponentController::class, 'getAvailableComponents']);
                    Route::post('/store', [ProjectIncomeComponentController::class, 'store']);
                    Route::post('/update/{id}', [ProjectIncomeComponentController::class, 'update']);
                    Route::post('/delete/{id}', [ProjectIncomeComponentController::class, 'destroy']);
                    Route::post('/restore/{id}', [ProjectIncomeComponentController::class, 'restore']);
                });
                
                // Project Length Components Sub-Routes (AJAX)
                Route::prefix('{projectId}/lengthcomponents')->group(function () {
                    Route::get('/available-building-components', [ProjectLengthComponentController::class, 'getAvailableBuildingComponents']);
                    Route::get('/available-length-components', [ProjectLengthComponentController::class, 'getAvailableLengthComponents']);
                    Route::post('/store', [ProjectLengthComponentController::class, 'store']);
                    Route::post('/update/{id}', [ProjectLengthComponentController::class, 'update']);
                    Route::post('/delete/{id}', [ProjectLengthComponentController::class, 'destroy']);
                    Route::post('/restore/{id}', [ProjectLengthComponentController::class, 'restore']);
                });
                
                // Project Construction Costs Sub-Routes (AJAX)
                Route::prefix('{projectId}/constructioncosts')->group(function () {
                    Route::get('/available-feasibility-components', [ProjectConstructionCostController::class, 'getAvailableFeasibilityComponents']);
                    Route::get('/available-substation-rooms', [ProjectConstructionCostController::class, 'getAvailableSubstationRooms']);
                    Route::get('/available-pumps-rooms', [ProjectConstructionCostController::class, 'getAvailablePumpsRooms']);
                    Route::post('/store', [ProjectConstructionCostController::class, 'store']);
                    Route::post('/update/{id}', [ProjectConstructionCostController::class, 'update']);
                    Route::post('/delete/{id}', [ProjectConstructionCostController::class, 'destroy']);
                    Route::post('/restore/{id}', [ProjectConstructionCostController::class, 'restore']);
                });
                
                // Project Specifications Sub-Routes (AJAX)
                Route::prefix('{projectId}/specifications')->group(function () {
                    Route::get('/available', [ProjectSpecificationController::class, 'getAvailableComponents']);
                    Route::post('/store', [ProjectSpecificationController::class, 'store']);
                    Route::post('/bulk-store', [ProjectSpecificationController::class, 'bulkStore']);
                    Route::post('/update/{id}', [ProjectSpecificationController::class, 'update']);
                    Route::post('/delete/{id}', [ProjectSpecificationController::class, 'destroy']);
                    Route::post('/restore/{id}', [ProjectSpecificationController::class, 'restore']);
                    Route::post('/force-delete/{id}', [ProjectSpecificationController::class, 'forceDelete']);
                });
                
                // Project Floors Sub-Routes
                Route::prefix('{projectId}/floors')->group(function () {
                    Route::get('/index', [ProjectFloorController::class, 'index'])->name('project.floor.index');
                    Route::get('/create', [ProjectFloorController::class, 'create'])->name('project.floor.create');
                    Route::post('/store', [ProjectFloorController::class, 'store'])->name('project.floor.store');
                    Route::get('/show/{id}', [ProjectFloorController::class, 'show'])->name('project.floor.show');
                    Route::get('/edit/{id}', [ProjectFloorController::class, 'edit'])->name('project.floor.edit');
                    Route::post('/update/{id}', [ProjectFloorController::class, 'update'])->name('project.floor.update');
                    Route::post('/delete/{id}', [ProjectFloorController::class, 'destroy'])->name('project.floor.delete');
                    Route::post('/restore/{id}', [ProjectFloorController::class, 'restore'])->name('project.floor.restore');
                    Route::get('/get-floor-components', [ProjectFloorController::class, 'getFloorComponents'])->name('project.floor.get-floor-components');
                    
                    // Floor Specifications Sub-Routes
                    Route::prefix('{floorId}/specifications')->group(function () {
                        Route::get('/index', [ProjectFloorSpecificationController::class, 'index'])->name('project.floor.specification.index');
                        Route::get('/create', [ProjectFloorSpecificationController::class, 'create'])->name('project.floor.specification.create');
                        Route::post('/store', [ProjectFloorSpecificationController::class, 'store'])->name('project.floor.specification.store');
                        Route::get('/edit/{id}', [ProjectFloorSpecificationController::class, 'edit'])->name('project.floor.specification.edit');
                        Route::post('/update/{id}', [ProjectFloorSpecificationController::class, 'update'])->name('project.floor.specification.update');
                        Route::post('/delete/{id}', [ProjectFloorSpecificationController::class, 'destroy'])->name('project.floor.specification.delete');
                        Route::post('/restore/{id}', [ProjectFloorSpecificationController::class, 'restore'])->name('project.floor.specification.restore');
                    });
                    
                    // Floor Amenities Sub-Routes (AJAX)
                    Route::prefix('{floorId}/amenities')->group(function () {
                        Route::get('/available', [ProjectFloorAmenityController::class, 'getAvailableAmenities']);
                        Route::post('/store', [ProjectFloorAmenityController::class, 'store']);
                        Route::post('/delete/{id}', [ProjectFloorAmenityController::class, 'destroy']);
                        Route::post('/restore/{id}', [ProjectFloorAmenityController::class, 'restore']);
                    });
                });
            });
            
            // Feasibility Studies Routes
            Route::prefix('feasibility-study')->group(function () {
                Route::get('/index', [FeasibilityStudyController::class, 'index'])->name('feasibility-study.index');
                Route::get('/project/{projectId}/create', [FeasibilityStudyController::class, 'create'])->name('feasibility-study.create');
                Route::post('/store', [FeasibilityStudyController::class, 'store'])->name('feasibility-study.store');
                Route::get('/{id}/show', [FeasibilityStudyController::class, 'show'])->name('feasibility-study.show');
                Route::get('/{id}/edit', [FeasibilityStudyController::class, 'edit'])->name('feasibility-study.edit');
                Route::post('/{id}/update', [FeasibilityStudyController::class, 'update'])->name('feasibility-study.update');
                Route::post('/{id}/delete', [FeasibilityStudyController::class, 'destroy'])->name('feasibility-study.delete');
                Route::post('/{id}/force-delete', [FeasibilityStudyController::class, 'forceDestroy'])->name('feasibility-study.force-delete');
                Route::post('/{id}/duplicate', [FeasibilityStudyController::class, 'duplicate'])->name('feasibility-study.duplicate');
            });

            // Portfolio Routes
            Route::prefix('portfolio')->group(function () {
                Route::get('/index', [PortfolioController::class, 'index'])->name('portfolio.index');
                Route::get('/create', [PortfolioController::class, 'create'])->name('portfolio.create');
                Route::post('/store', [PortfolioController::class, 'store'])->name('portfolio.store');
                Route::get('/edit/{id}', [PortfolioController::class, 'edit'])->name('portfolio.edit');
                Route::post('/update/{id}', [PortfolioController::class, 'update'])->name('portfolio.update');
                Route::post('/delete/{id}', [PortfolioController::class, 'destroy'])->name('portfolio.delete');
                Route::get('/show/{id}', [PortfolioController::class, 'show'])->name('portfolio.show');
                Route::get('/trashed', [PortfolioController::class, 'trashed'])->name('portfolio.trashed');
                Route::post('/restore/{id}', [PortfolioController::class, 'restore'])->name('portfolio.restore');
            });
            
            // Portfolio Process Routes
            Route::prefix('portfolio-process')->group(function () {
                Route::post('/store', [PortfolioProcessController::class, 'store'])->name('portfolio-process.store');
                Route::post('/update/{id}', [PortfolioProcessController::class, 'update'])->name('portfolio-process.update');
                Route::post('/delete/{id}', [PortfolioProcessController::class, 'destroy'])->name('portfolio-process.delete');
                Route::post('/update-order', [PortfolioProcessController::class, 'updateOrder'])->name('portfolio-process.update-order');
            });
            
            // Portfolio Image/Gallery Routes
            Route::prefix('portfolio-image')->group(function () {
                Route::post('/store/{portfolioId}', [PortfolioImageController::class, 'store'])->name('portfolio-image.store');
                Route::get('/galleries/{portfolioId}', [PortfolioImageController::class, 'getGallery'])->name('portfolio-image.galleries');
            });

            // Project Image/Gallery Routes
            Route::prefix('project-image')->group(function () {
                Route::post('/store/{projectId}', [ProjectImageController::class, 'store'])->name('project-image.store');
                Route::get('/galleries/{projectId}', [ProjectImageController::class, 'getGallery'])->name('project-image.galleries');
            });

            // Team Routes
            Route::prefix('team')->name('admin.team.')->group(function () {
                Route::get('/index', [TeamController::class, 'index'])->name('index');
                Route::get('/create', [TeamController::class, 'create'])->name('create');
                Route::post('/store', [TeamController::class, 'store'])->name('store');
                Route::get('/show/{id}', [TeamController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [TeamController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [TeamController::class, 'update'])->name('update');
                Route::post('/delete/{id}', [TeamController::class, 'destroy'])->name('delete');
                Route::get('/trashed', [TeamController::class, 'trashed'])->name('trashed');
                Route::post('/restore/{id}', [TeamController::class, 'restore'])->name('restore');
                Route::post('/update-display-order', [TeamController::class, 'updateDisplayOrder'])->name('update-display-order');
                Route::post('/update-board-order', [TeamController::class, 'updateBoardOrder'])->name('update-board-order');
            });

            // Home Blocks Routes
            Route::prefix('homeblock')->group(function () {
                Route::get('/index', [HomeBlockController::class, 'index'])->name('homeblock.index');
                Route::get('/create', [HomeBlockController::class, 'create'])->name('homeblock.create');
                Route::post('/store', [HomeBlockController::class, 'store'])->name('homeblock.store');
                Route::get('/edit/{id}', [HomeBlockController::class, 'edit'])->name('homeblock.edit');
                Route::post('/update/{id}', [HomeBlockController::class, 'update'])->name('homeblock.update');
                Route::post('/delete/{id}', [HomeBlockController::class, 'destroy'])->name('homeblock.delete');
                Route::get('/trashed', [HomeBlockController::class, 'trashed'])->name('homeblock.trashed');
                Route::post('/restore/{id}', [HomeBlockController::class, 'restore'])->name('homeblock.restore');
            });

            // Cards Routes
            Route::prefix('card')->group(function () {
                Route::get('/index', [CardController::class, 'index'])->name('card.index');
                Route::get('/create', [CardController::class, 'create'])->name('card.create');
                Route::post('/store', [CardController::class, 'store'])->name('card.store');
                Route::get('/edit/{id}', [CardController::class, 'edit'])->name('card.edit');
                Route::post('/update/{id}', [CardController::class, 'update'])->name('card.update');
                Route::post('/delete/{id}', [CardController::class, 'destroy'])->name('card.delete');
                Route::get('/trashed', [CardController::class, 'trashed'])->name('card.trashed');
                Route::post('/restore/{id}', [CardController::class, 'restore'])->name('card.restore');
            });

            // Home Contact Routes (Single Row)
            Route::prefix('homecontact')->group(function () {
                Route::get('/index', [HomeContactController::class, 'index'])->name('homecontact.index');
                Route::post('/update', [HomeContactController::class, 'update'])->name('homecontact.update');
            });

            // Showcases Routes
            Route::prefix('showcase')->group(function () {
                Route::get('/index', [ShowcaseController::class, 'index'])->name('showcase.index');
                Route::get('/create', [ShowcaseController::class, 'create'])->name('showcase.create');
                Route::post('/store', [ShowcaseController::class, 'store'])->name('showcase.store');
                Route::get('/show/{id}', [ShowcaseController::class, 'show'])->name('showcase.show');
                Route::get('/edit/{id}', [ShowcaseController::class, 'edit'])->name('showcase.edit');
                Route::post('/update/{id}', [ShowcaseController::class, 'update'])->name('showcase.update');
                Route::post('/delete/{id}', [ShowcaseController::class, 'destroy'])->name('showcase.delete');
                Route::get('/trashed', [ShowcaseController::class, 'trashed'])->name('showcase.trashed');
                Route::post('/restore/{id}', [ShowcaseController::class, 'restore'])->name('showcase.restore');
                Route::post('/toggle-status/{id}', [ShowcaseController::class, 'toggleStatus'])->name('showcase.toggleStatus');
                Route::post('/toggle-home-status/{id}', [ShowcaseController::class, 'toggleHomeStatus'])->name('showcase.toggleHomeStatus');
                
                // Showcase Services Sub-Routes (AJAX)
                Route::prefix('{showcaseId}/services')->group(function () {
                    Route::get('/available', [ShowcaseServiceController::class, 'getAvailableServices']);
                    Route::post('/store', [ShowcaseServiceController::class, 'store']);
                    Route::post('/delete/{id}', [ShowcaseServiceController::class, 'destroy']);
                });
                
                // Showcase Projects Sub-Routes (AJAX)
                Route::prefix('{showcaseId}/projects')->group(function () {
                    Route::get('/available', [ShowcaseProjectController::class, 'getAvailableProjects']);
                    Route::post('/store', [ShowcaseProjectController::class, 'store']);
                    Route::post('/delete/{id}', [ShowcaseProjectController::class, 'destroy']);
                });
                
                // Showcase Portfolios Sub-Routes (AJAX)
                Route::prefix('{showcaseId}/portfolios')->group(function () {
                    Route::get('/available', [ShowcasePortfolioController::class, 'getAvailablePortfolios']);
                    Route::post('/store', [ShowcasePortfolioController::class, 'store']);
                    Route::post('/delete/{id}', [ShowcasePortfolioController::class, 'destroy']);
                });
                
                // Showcase Team Sub-Routes (AJAX)
                Route::prefix('{showcaseId}/team')->group(function () {
                    Route::get('/available', [ShowcaseTeamController::class, 'getAvailableTeam']);
                    Route::post('/store', [ShowcaseTeamController::class, 'store']);
                    Route::post('/delete/{id}', [ShowcaseTeamController::class, 'destroy']);
                });
                
                // Showcase News Sub-Routes (AJAX)
                Route::prefix('{showcaseId}/news')->group(function () {
                    Route::get('/available', [ShowcaseNewController::class, 'getAvailableNews']);
                    Route::post('/store', [ShowcaseNewController::class, 'store']);
                    Route::post('/delete/{id}', [ShowcaseNewController::class, 'destroy']);
                });
            });

            // Home FAQs Routes
            Route::prefix('homefaq')->group(function () {
                Route::get('/index', [HomeFaqController::class, 'index'])->name('homefaq.index');
                Route::get('/create', [HomeFaqController::class, 'create'])->name('homefaq.create');
                Route::post('/store', [HomeFaqController::class, 'store'])->name('homefaq.store');
                Route::get('/edit/{id}', [HomeFaqController::class, 'edit'])->name('homefaq.edit');
                Route::post('/update/{id}', [HomeFaqController::class, 'update'])->name('homefaq.update');
                Route::post('/delete/{id}', [HomeFaqController::class, 'destroy'])->name('homefaq.delete');
                Route::get('/trashed', [HomeFaqController::class, 'trashed'])->name('homefaq.trashed');
                Route::post('/restore/{id}', [HomeFaqController::class, 'restore'])->name('homefaq.restore');
            });

            // Page Banners Routes
            Route::prefix('page-banner')->group(function () {
                Route::get('/index', [PageBannerController::class, 'index'])->name('page-banner.index');
                Route::get('/create', [PageBannerController::class, 'create'])->name('page-banner.create');
                Route::post('/store', [PageBannerController::class, 'store'])->name('page-banner.store');
                Route::get('/edit/{id}', [PageBannerController::class, 'edit'])->name('page-banner.edit');
                Route::post('/update/{id}', [PageBannerController::class, 'update'])->name('page-banner.update');
                Route::post('/delete/{id}', [PageBannerController::class, 'destroy'])->name('page-banner.delete');
                Route::get('/trashed', [PageBannerController::class, 'trashed'])->name('page-banner.trashed');
                Route::post('/restore/{id}', [PageBannerController::class, 'restore'])->name('page-banner.restore');
            });

            // Site Settings Routes
            Route::prefix('site-settings')->group(function () {
                Route::get('/index', [SiteSettingsController::class, 'index'])->name('site-settings.index');
                Route::post('/update-construction', [SiteSettingsController::class, 'updateUnderConstruction'])->name('site-settings.update-construction');
                Route::post('/update-contact-forms', [SiteSettingsController::class, 'updateContactForms'])->name('site-settings.update-contact-forms');
            });

            // Facts Routes
            Route::prefix('facts')->group(function () {
                Route::get('/index', [FactController::class, 'index'])->name('admin.facts.index');
                Route::get('/create', [FactController::class, 'create'])->name('admin.facts.create');
                Route::post('/store', [FactController::class, 'store'])->name('admin.facts.store');
                Route::get('/edit/{id}', [FactController::class, 'edit'])->name('admin.facts.edit');
                Route::put('/update/{id}', [FactController::class, 'update'])->name('admin.facts.update');
                Route::delete('/destroy/{id}', [FactController::class, 'destroy'])->name('admin.facts.destroy');
                Route::get('/trashed', [FactController::class, 'trashed'])->name('admin.facts.trashed');
                Route::post('/restore/{id}', [FactController::class, 'restore'])->name('admin.facts.restore');
                Route::delete('/force-delete/{id}', [FactController::class, 'forceDelete'])->name('admin.facts.force-delete');
                Route::post('/toggle-status/{id}', [FactController::class, 'toggleStatus'])->name('admin.facts.toggle-status');
                Route::post('/update-orders', [FactController::class, 'updateOrders'])->name('admin.facts.update-orders');
            });

            // Default Processes Routes
            Route::prefix('default-processes')->group(function () {
                Route::get('/index', [DefaultProcessController::class, 'index'])->name('admin.default-processes.index');
                Route::get('/create', [DefaultProcessController::class, 'create'])->name('admin.default-processes.create');
                Route::post('/store', [DefaultProcessController::class, 'store'])->name('admin.default-processes.store');
                Route::get('/edit/{id}', [DefaultProcessController::class, 'edit'])->name('admin.default-processes.edit');
                Route::put('/update/{id}', [DefaultProcessController::class, 'update'])->name('admin.default-processes.update');
                Route::delete('/destroy/{id}', [DefaultProcessController::class, 'destroy'])->name('admin.default-processes.destroy');
                Route::get('/trashed', [DefaultProcessController::class, 'trashed'])->name('admin.default-processes.trashed');
                Route::post('/restore/{id}', [DefaultProcessController::class, 'restore'])->name('admin.default-processes.restore');
                Route::delete('/force-delete/{id}', [DefaultProcessController::class, 'forceDelete'])->name('admin.default-processes.force-delete');
                Route::post('/toggle-status/{id}', [DefaultProcessController::class, 'toggleStatus'])->name('admin.default-processes.toggle-status');
            });

            // Default Process Cards Routes
            Route::prefix('default-processes/{processId}/cards')->group(function () {
                Route::get('/index', [DefaultProcessCardController::class, 'index'])->name('admin.default-process-cards.index');
                Route::get('/create', [DefaultProcessCardController::class, 'create'])->name('admin.default-process-cards.create');
                Route::post('/store', [DefaultProcessCardController::class, 'store'])->name('admin.default-process-cards.store');
                Route::get('/edit/{id}', [DefaultProcessCardController::class, 'edit'])->name('admin.default-process-cards.edit');
                Route::put('/update/{id}', [DefaultProcessCardController::class, 'update'])->name('admin.default-process-cards.update');
                Route::delete('/destroy/{id}', [DefaultProcessCardController::class, 'destroy'])->name('admin.default-process-cards.destroy');
                Route::get('/trashed', [DefaultProcessCardController::class, 'trashed'])->name('admin.default-process-cards.trashed');
                Route::post('/restore/{id}', [DefaultProcessCardController::class, 'restore'])->name('admin.default-process-cards.restore');
                Route::delete('/force-delete/{id}', [DefaultProcessCardController::class, 'forceDelete'])->name('admin.default-process-cards.force-delete');
                Route::post('/toggle-status/{id}', [DefaultProcessCardController::class, 'toggleStatus'])->name('admin.default-process-cards.toggle-status');
                Route::post('/update-orders', [DefaultProcessCardController::class, 'updateOrders'])->name('admin.default-process-cards.update-orders');
            });

            // Default Banners Routes
            Route::prefix('default-banners')->group(function () {
                Route::get('/index', [DefaultBannerController::class, 'index'])->name('admin.default-banners.index');
                Route::get('/create', [DefaultBannerController::class, 'create'])->name('admin.default-banners.create');
                Route::post('/store', [DefaultBannerController::class, 'store'])->name('admin.default-banners.store');
                Route::get('/edit/{id}', [DefaultBannerController::class, 'edit'])->name('admin.default-banners.edit');
                Route::put('/update/{id}', [DefaultBannerController::class, 'update'])->name('admin.default-banners.update');
                Route::delete('/destroy/{id}', [DefaultBannerController::class, 'destroy'])->name('admin.default-banners.destroy');
                Route::get('/trashed', [DefaultBannerController::class, 'trashed'])->name('admin.default-banners.trashed');
                Route::post('/restore/{id}', [DefaultBannerController::class, 'restore'])->name('admin.default-banners.restore');
                Route::delete('/force-delete/{id}', [DefaultBannerController::class, 'forceDelete'])->name('admin.default-banners.force-delete');
                Route::post('/toggle-status/{id}', [DefaultBannerController::class, 'toggleStatus'])->name('admin.default-banners.toggle-status');
            });

            // Offers Routes
            Route::prefix('offer')->group(function () {
                Route::get('/index', [OfferController::class, 'index'])->name('offer.index');
                Route::get('/create', [OfferController::class, 'create'])->name('offer.create');
                Route::post('/store', [OfferController::class, 'store'])->name('offer.store');
                Route::get('/edit/{id}', [OfferController::class, 'edit'])->name('offer.edit');
                Route::post('/update/{id}', [OfferController::class, 'update'])->name('offer.update');
                Route::post('/delete/{id}', [OfferController::class, 'destroy'])->name('offer.delete');
                Route::get('/show/{id}', [OfferController::class, 'show'])->name('offer.show');
                Route::get('/trashed', [OfferController::class, 'trashed'])->name('offer.trashed');
                Route::post('/restore/{id}', [OfferController::class, 'restore'])->name('offer.restore');
                Route::post('/toggle-publish/{id}', [OfferController::class, 'togglePublish'])->name('offer.toggle-publish');
                Route::post('/toggle-home-feature/{id}', [OfferController::class, 'toggleHomeFeature'])->name('offer.toggle-home-feature');
                Route::post('/toggle-feasibility-studies/{id}', [OfferController::class, 'toggleFeasibilityStudies'])->name('offer.toggle-feasibility-studies');
                Route::get('/subcategories', [OfferController::class, 'getSubcategories'])->name('offer.subcategories');
                Route::get('/live-search', [OfferController::class, 'liveSearch'])->name('offer.live-search');
                Route::post('/bulk-publish', [OfferController::class, 'bulkPublish'])->name('offer.bulk-publish');
                Route::post('/bulk-home-status', [OfferController::class, 'bulkHomeStatus'])->name('offer.bulk-home-status');
                
                // Offer Prices Sub-Routes (AJAX)
                Route::prefix('{offerId}/prices')->group(function () {
                    Route::get('/available-emirates', [OfferPriceController::class, 'getAvailableEmirates']);
                    Route::post('/store', [OfferPriceController::class, 'store']);
                    Route::post('/bulk-store', [OfferPriceController::class, 'bulkStore']);
                    Route::post('/update/{id}', [OfferPriceController::class, 'update']);
                    Route::post('/delete/{id}', [OfferPriceController::class, 'destroy']);
                    Route::post('/restore/{id}', [OfferPriceController::class, 'restore']);
                    Route::post('/force-delete/{id}', [OfferPriceController::class, 'forceDelete']);
                });
            });
            
            // Offer Image/Gallery Routes
            Route::prefix('offer-image')->group(function () {
                Route::post('/store/{offerId}', [OfferImageController::class, 'store'])->name('offer-image.store');
                Route::get('/galleries/{offerId}', [OfferImageController::class, 'getGallery'])->name('offer-image.galleries');
            });
            
            // Offer Building Components Sub-Routes (AJAX)
            Route::prefix('offer/{offerId}/buildingcomponents')->group(function () {
                Route::get('/available', [OfferBuildingComponentController::class, 'getAvailableComponents']);
                Route::post('/store', [OfferBuildingComponentController::class, 'store']);
                Route::post('/update/{id}', [OfferBuildingComponentController::class, 'update']);
                Route::post('/delete/{id}', [OfferBuildingComponentController::class, 'destroy']);
                Route::post('/restore/{id}', [OfferBuildingComponentController::class, 'restore']);
            });
            
            // Offer Length Components Sub-Routes (AJAX)
            Route::prefix('offer/{offerId}/lengthcomponents')->group(function () {
                Route::get('/available-building-components', [OfferLengthComponentController::class, 'getAvailableBuildingComponents']);
                Route::get('/available-length-components', [OfferLengthComponentController::class, 'getAvailableLengthComponents']);
                Route::post('/store', [OfferLengthComponentController::class, 'store']);
                Route::post('/update/{id}', [OfferLengthComponentController::class, 'update']);
                Route::post('/delete/{id}', [OfferLengthComponentController::class, 'destroy']);
                Route::post('/restore/{id}', [OfferLengthComponentController::class, 'restore']);
            });
            
            // Offer Income Components Sub-Routes (AJAX)
            Route::prefix('offer/{offerId}/incomecomponents')->group(function () {
                Route::get('/available', [OfferIncomeComponentController::class, 'getAvailableComponents']);
                Route::post('/store', [OfferIncomeComponentController::class, 'store']);
                Route::post('/update/{id}', [OfferIncomeComponentController::class, 'update']);
                Route::post('/delete/{id}', [OfferIncomeComponentController::class, 'destroy']);
                Route::post('/restore/{id}', [OfferIncomeComponentController::class, 'restore']);
            });
            
            // Offer Construction Costs Sub-Routes (AJAX)
            Route::prefix('offer/{offerId}/constructioncosts')->group(function () {
                Route::get('/available-feasibility-components', [OfferConstructionCostController::class, 'getAvailableFeasibilityComponents']);
                Route::get('/available-substation-rooms', [OfferConstructionCostController::class, 'getAvailableSubstationRooms']);
                Route::get('/available-pumps-rooms', [OfferConstructionCostController::class, 'getAvailablePumpsRooms']);
                Route::post('/store', [OfferConstructionCostController::class, 'store']);
                Route::post('/update/{id}', [OfferConstructionCostController::class, 'update']);
                Route::post('/delete/{id}', [OfferConstructionCostController::class, 'destroy']);
                Route::post('/restore/{id}', [OfferConstructionCostController::class, 'restore']);
            });
            
            // Offer Specifications Sub-Routes (AJAX)
            Route::prefix('offer/{offerId}/specifications')->group(function () {
                Route::get('/available', [OfferSpecificationController::class, 'getAvailableComponents']);
                Route::post('/store', [OfferSpecificationController::class, 'store']);
                Route::post('/bulk-store', [OfferSpecificationController::class, 'bulkStore']);
                Route::post('/update/{id}', [OfferSpecificationController::class, 'update']);
                Route::post('/delete/{id}', [OfferSpecificationController::class, 'destroy']);
                Route::post('/restore/{id}', [OfferSpecificationController::class, 'restore']);
                Route::post('/force-delete/{id}', [OfferSpecificationController::class, 'forceDelete']);
            });
            
            // Offer Feasibility Studies Routes
            Route::prefix('offer-feasibility-study')->group(function () {
                Route::get('/index', [OfferFeasibilityStudyController::class, 'index'])->name('offer-feasibility-study.index');
                Route::get('/offer/{offerId}/create', [OfferFeasibilityStudyController::class, 'create'])->name('offer-feasibility-study.create');
                Route::post('/store', [OfferFeasibilityStudyController::class, 'store'])->name('offer-feasibility-study.store');
                Route::get('/{id}/show', [OfferFeasibilityStudyController::class, 'show'])->name('offer-feasibility-study.show');
                Route::get('/{id}/edit', [OfferFeasibilityStudyController::class, 'edit'])->name('offer-feasibility-study.edit');
                Route::post('/{id}/update', [OfferFeasibilityStudyController::class, 'update'])->name('offer-feasibility-study.update');
                Route::post('/{id}/delete', [OfferFeasibilityStudyController::class, 'destroy'])->name('offer-feasibility-study.delete');
                Route::post('/{id}/duplicate', [OfferFeasibilityStudyController::class, 'duplicate'])->name('offer-feasibility-study.duplicate');
            });
            
            // Offer Floors Sub-Routes
            Route::prefix('offer/{offerId}/floors')->group(function () {
                Route::get('/index', [OfferFloorController::class, 'index'])->name('offer.floor.index');
                Route::get('/create', [OfferFloorController::class, 'create'])->name('offer.floor.create');
                Route::post('/store', [OfferFloorController::class, 'store'])->name('offer.floor.store');
                Route::get('/show/{id}', [OfferFloorController::class, 'show'])->name('offer.floor.show');
                Route::get('/edit/{id}', [OfferFloorController::class, 'edit'])->name('offer.floor.edit');
                Route::post('/update/{id}', [OfferFloorController::class, 'update'])->name('offer.floor.update');
                Route::post('/delete/{id}', [OfferFloorController::class, 'destroy'])->name('offer.floor.delete');
                Route::post('/restore/{id}', [OfferFloorController::class, 'restore'])->name('offer.floor.restore');
                Route::get('/get-floor-components', [OfferFloorController::class, 'getFloorComponents'])->name('offer.floor.get-floor-components');
                
                // Floor Specifications Sub-Routes
                Route::prefix('{floorId}/specifications')->group(function () {
                    Route::get('/index', [OfferFloorSpecificationController::class, 'index'])->name('offer.floor.specification.index');
                    Route::get('/create', [OfferFloorSpecificationController::class, 'create'])->name('offer.floor.specification.create');
                    Route::post('/store', [OfferFloorSpecificationController::class, 'store'])->name('offer.floor.specification.store');
                    Route::get('/edit/{id}', [OfferFloorSpecificationController::class, 'edit'])->name('offer.floor.specification.edit');
                    Route::post('/update/{id}', [OfferFloorSpecificationController::class, 'update'])->name('offer.floor.specification.update');
                    Route::post('/delete/{id}', [OfferFloorSpecificationController::class, 'destroy'])->name('offer.floor.specification.delete');
                    Route::post('/restore/{id}', [OfferFloorSpecificationController::class, 'restore'])->name('offer.floor.specification.restore');
                });
                
                // Floor Amenities Sub-Routes (AJAX)
                Route::prefix('{floorId}/amenities')->group(function () {
                    Route::get('/available', [OfferFloorAmenityController::class, 'getAvailableAmenities']);
                    Route::post('/store', [OfferFloorAmenityController::class, 'store']);
                    Route::post('/delete/{id}', [OfferFloorAmenityController::class, 'destroy']);
                    Route::post('/restore/{id}', [OfferFloorAmenityController::class, 'restore']);
                });
            });

            // Interior Design Gallery Routes
            Route::prefix('interior-design-gallery')->group(function () {
                Route::get('/index', [InteriorDesignGalleryController::class, 'index'])->name('interior-design-gallery.index');
                Route::get('/create', [InteriorDesignGalleryController::class, 'create'])->name('interior-design-gallery.create');
                Route::post('/store', [InteriorDesignGalleryController::class, 'store'])->name('interior-design-gallery.store');
                Route::get('/show/{id}', [InteriorDesignGalleryController::class, 'show'])->name('interior-design-gallery.show');
                Route::get('/edit/{id}', [InteriorDesignGalleryController::class, 'edit'])->name('interior-design-gallery.edit');
                Route::post('/update/{id}', [InteriorDesignGalleryController::class, 'update'])->name('interior-design-gallery.update');
                Route::post('/delete/{id}', [InteriorDesignGalleryController::class, 'destroy'])->name('interior-design-gallery.delete');
                Route::get('/trashed', [InteriorDesignGalleryController::class, 'trashed'])->name('interior-design-gallery.trashed');
                Route::post('/restore/{id}', [InteriorDesignGalleryController::class, 'restore'])->name('interior-design-gallery.restore');
                Route::post('/toggle-publish/{id}', [InteriorDesignGalleryController::class, 'togglePublish'])->name('interior-design-gallery.toggle-publish');
                Route::post('/toggle-home/{id}', [InteriorDesignGalleryController::class, 'toggleHomeStatus'])->name('interior-design-gallery.toggle-home');
                Route::post('/bulk-publish', [InteriorDesignGalleryController::class, 'bulkPublish'])->name('interior-design-gallery.bulk-publish');
                Route::post('/bulk-home-status', [InteriorDesignGalleryController::class, 'bulkHomeStatus'])->name('interior-design-gallery.bulk-home-status');
                Route::get('/bulk-add', [InteriorDesignGalleryController::class, 'bulkAdd'])->name('interior-design-gallery.bulk-add');
                Route::post('/bulk-store', [InteriorDesignGalleryController::class, 'bulkStore'])->name('interior-design-gallery.bulk-store');
                Route::get('/get-next-number/{categoryId}', [InteriorDesignGalleryController::class, 'getNextNumber'])->name('interior-design-gallery.get-next-number');
                Route::get('/order-index', [InteriorDesignGalleryController::class, 'orderIndex'])->name('interior-design-gallery.order-index');
                Route::get('/order-all', [InteriorDesignGalleryController::class, 'orderAll'])->name('interior-design-gallery.order-all');
                Route::post('/update-index-order', [InteriorDesignGalleryController::class, 'updateIndexOrder'])->name('interior-design-gallery.update-index-order');
                Route::post('/update-all-order', [InteriorDesignGalleryController::class, 'updateAllOrder'])->name('interior-design-gallery.update-all-order');
            });

            // Home Interior Settings Routes
            Route::prefix('home-interior-settings')->group(function () {
                Route::get('/index', [HomeInteriorSettingController::class, 'index'])->name('home-interior-settings.index');
                Route::get('/select-images', [HomeInteriorSettingController::class, 'selectImages'])->name('home-interior-settings.select-images');
                Route::post('/save-images', [HomeInteriorSettingController::class, 'saveImages'])->name('home-interior-settings.save-images');
                Route::post('/clear-images', [HomeInteriorSettingController::class, 'clearImages'])->name('home-interior-settings.clear-images');
                Route::post('/update', [HomeInteriorSettingController::class, 'update'])->name('home-interior-settings.update');
                Route::post('/update-order', [HomeInteriorSettingController::class, 'updateOrder'])->name('home-interior-settings.update-order');
            });

            // Interior Category Order Routes
            Route::prefix('interior-category-order')->group(function () {
                Route::get('/index', [InteriorCategoryOrderController::class, 'index'])->name('interior-category-order.index');
                Route::post('/update-order', [InteriorCategoryOrderController::class, 'updateOrder'])->name('interior-category-order.update-order');
                Route::post('/toggle-publish/{id}', [InteriorCategoryOrderController::class, 'togglePublish'])->name('interior-category-order.toggle-publish');
                Route::get('/category-images/{id}', [InteriorCategoryOrderController::class, 'categoryImages'])->name('interior-category-order.category-images');
                Route::post('/update-category-images-order/{id}', [InteriorCategoryOrderController::class, 'updateCategoryImagesOrder'])->name('interior-category-order.update-category-images-order');
            });

            // Contact Page Sections Management Routes
            Route::prefix('contact-page-sections')->group(function () {
                Route::get('/index', [ContactPageSectionController::class, 'index'])->name('contact-page-sections.index');
                Route::post('/update-order', [ContactPageSectionController::class, 'updateOrder'])->name('contact-page-sections.update-order');
                Route::post('/toggle-status/{id}', [ContactPageSectionController::class, 'toggleStatus'])->name('contact-page-sections.toggle-status');
                Route::post('/move-up/{id}', [ContactPageSectionController::class, 'moveUp'])->name('contact-page-sections.move-up');
                Route::post('/move-down/{id}', [ContactPageSectionController::class, 'moveDown'])->name('contact-page-sections.move-down');
                Route::get('/edit/{id}', [ContactPageSectionController::class, 'edit'])->name('contact-page-sections.edit');
                Route::post('/update/{id}', [ContactPageSectionController::class, 'update'])->name('contact-page-sections.update');
            });

            // About Page Sections Management Routes
            Route::prefix('about-page-sections')->group(function () {
                Route::get('/index', [AboutPageSectionController::class, 'index'])->name('about-page-sections.index');
                Route::post('/update-order', [AboutPageSectionController::class, 'updateOrder'])->name('about-page-sections.update-order');
                Route::post('/toggle-status/{id}', [AboutPageSectionController::class, 'toggleStatus'])->name('about-page-sections.toggle-status');
                Route::post('/move-up/{id}', [AboutPageSectionController::class, 'moveUp'])->name('about-page-sections.move-up');
                Route::post('/move-down/{id}', [AboutPageSectionController::class, 'moveDown'])->name('about-page-sections.move-down');
                Route::get('/edit/{id}', [AboutPageSectionController::class, 'edit'])->name('about-page-sections.edit');
                Route::post('/update/{id}', [AboutPageSectionController::class, 'update'])->name('about-page-sections.update');
            });

            // Home Sections Management Routes
            Route::prefix('home-sections')->group(function () {
                Route::get('/index', [HomeSectionController::class, 'index'])->name('home-sections.index');
                Route::get('/edit/{id}', [HomeSectionController::class, 'edit'])->name('home-sections.edit');
                Route::post('/update/{id}', [HomeSectionController::class, 'update'])->name('home-sections.update');
                Route::post('/toggle-status/{id}', [HomeSectionController::class, 'toggleStatus'])->name('home-sections.toggle-status');
                Route::post('/toggle-divider/{id}', [HomeSectionController::class, 'toggleDivider'])->name('home-sections.toggle-divider');
                Route::post('/update-order', [HomeSectionController::class, 'updateOrder'])->name('home-sections.update-order');
                Route::post('/move-up/{id}', [HomeSectionController::class, 'moveUp'])->name('home-sections.move-up');
                Route::post('/move-down/{id}', [HomeSectionController::class, 'moveDown'])->name('home-sections.move-down');
                Route::post('/delete/{id}', [HomeSectionController::class, 'destroy'])->name('home-sections.delete');
                Route::get('/trashed', [HomeSectionController::class, 'trashed'])->name('home-sections.trashed');
                Route::post('/restore/{id}', [HomeSectionController::class, 'restore'])->name('home-sections.restore');
            });

            // Home Projects Section Settings Routes
            Route::prefix('home-project-settings')->group(function () {
                Route::get('/index', [HomeProjectSettingController::class, 'index'])->name('home-project-settings.index');
                Route::post('/update/{id}', [HomeProjectSettingController::class, 'update'])->name('home-project-settings.update');
                Route::post('/update-order', [HomeProjectSettingController::class, 'updateOrder'])->name('home-project-settings.update-order');
                Route::post('/toggle-status/{id}', [HomeProjectSettingController::class, 'toggleStatus'])->name('home-project-settings.toggle-status');
                Route::post('/bulk-update', [HomeProjectSettingController::class, 'bulkUpdate'])->name('home-project-settings.bulk-update');
                Route::get('/reset', [HomeProjectSettingController::class, 'resetToDefault'])->name('home-project-settings.reset');
                Route::get('/{id}/select-projects', [HomeProjectSettingController::class, 'selectProjects'])->name('home-project-settings.select-projects');
                Route::post('/{id}/save-projects', [HomeProjectSettingController::class, 'saveProjects'])->name('home-project-settings.save-projects');
                Route::post('/{id}/clear-projects', [HomeProjectSettingController::class, 'clearProjects'])->name('home-project-settings.clear-projects');
            });

            // Certificates Routes
            Route::prefix('certificate')->group(function () {
                Route::get('/index', [CertificateController::class, 'index'])->name('certificate.index');
                Route::get('/create', [CertificateController::class, 'create'])->name('certificate.create');
                Route::post('/store', [CertificateController::class, 'store'])->name('certificate.store');
                Route::get('/edit/{id}', [CertificateController::class, 'edit'])->name('certificate.edit');
                Route::post('/update/{id}', [CertificateController::class, 'update'])->name('certificate.update');
                Route::post('/delete/{id}', [CertificateController::class, 'destroy'])->name('certificate.delete');
                Route::get('/trashed', [CertificateController::class, 'trashed'])->name('certificate.trashed');
                Route::post('/restore/{id}', [CertificateController::class, 'restore'])->name('certificate.restore');
                Route::post('/toggle-status/{id}', [CertificateController::class, 'toggleStatus'])->name('certificate.toggle-status');
                Route::post('/update-order', [CertificateController::class, 'updateOrder'])->name('certificate.update-order');
            });

            // Menu Management Routes
            Route::prefix('menu')->name('admin.menu.')->group(function () {
                // User Guide
                Route::get('/guide', [MenuController::class, 'guide'])->name('guide');
                
                // Menu CRUD
                Route::get('/index', [MenuController::class, 'index'])->name('index');
                Route::get('/create', [MenuController::class, 'create'])->name('create');
                Route::post('/store', [MenuController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [MenuController::class, 'update'])->name('update');
                Route::post('/delete/{id}', [MenuController::class, 'destroy'])->name('delete');
                Route::get('/trashed', [MenuController::class, 'trashed'])->name('trashed');
                Route::post('/restore/{id}', [MenuController::class, 'restore'])->name('restore');
                Route::post('/toggle-status/{id}', [MenuController::class, 'toggleStatus'])->name('toggle-status');
                
                // Menu Settings
                Route::get('/settings', [MenuController::class, 'settings'])->name('settings');
                Route::post('/settings/update', [MenuController::class, 'updateSettings'])->name('settings.update');
                
                // Menu Items Management
                Route::get('/{menuId}/items', [MenuController::class, 'items'])->name('items');
                Route::get('/{menuId}/items/create', [MenuController::class, 'createItem'])->name('item.create');
                Route::post('/{menuId}/items/store', [MenuController::class, 'storeItem'])->name('item.store');
                Route::get('/{menuId}/items/edit/{itemId}', [MenuController::class, 'editItem'])->name('item.edit');
                Route::post('/{menuId}/items/update/{itemId}', [MenuController::class, 'updateItem'])->name('item.update');
                Route::post('/{menuId}/items/delete/{itemId}', [MenuController::class, 'destroyItem'])->name('item.delete');
                Route::post('/{menuId}/items/toggle-status/{itemId}', [MenuController::class, 'toggleItemStatus'])->name('item.toggle-status');
                Route::get('/{menuId}/items/trashed', [MenuController::class, 'trashedItems'])->name('items.trashed');
                Route::post('/{menuId}/items/restore/{itemId}', [MenuController::class, 'restoreItem'])->name('item.restore');
                Route::post('/{menuId}/items/update-order', [MenuController::class, 'updateItemsOrder'])->name('items.update-order');
                
                // AJAX endpoints for category/subcategory selection
                Route::get('/ajax/categories', [MenuController::class, 'getCategories'])->name('ajax.categories');
                Route::get('/ajax/subcategories', [MenuController::class, 'getSubcategories'])->name('ajax.subcategories');
            });

            // Activity Logs Routes
            Route::prefix('activity-logs')->name('admin.activity-logs.')->group(function () {
                Route::get('/', [ActivityLogController::class, 'index'])->name('index');
                Route::get('/show/{id}', [ActivityLogController::class, 'show'])->name('show');
                Route::post('/clear-old', [ActivityLogController::class, 'clearOld'])->name('clear-old');
            });

            // Roles Management Routes
            Route::prefix('roles')->name('admin.roles.')->group(function () {
                Route::get('/', [RoleController::class, 'index'])->name('index');
                Route::get('/create', [RoleController::class, 'create'])->name('create');
                Route::post('/store', [RoleController::class, 'store'])->name('store');
                Route::get('/show/{role}', [RoleController::class, 'show'])->name('show');
                Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('edit');
                Route::put('/update/{role}', [RoleController::class, 'update'])->name('update');
                Route::delete('/destroy/{role}', [RoleController::class, 'destroy'])->name('destroy');
                Route::get('/trashed', [RoleController::class, 'trashed'])->name('trashed');
                Route::post('/restore/{id}', [RoleController::class, 'restore'])->name('restore');
                Route::delete('/force-delete/{id}', [RoleController::class, 'forceDelete'])->name('force-delete');
                Route::patch('/toggle-active/{role}', [RoleController::class, 'toggleActive'])->name('toggle-active');
            });

            // User Roles Management Routes
            Route::prefix('users/roles')->name('admin.users.roles.')->group(function () {
                Route::get('/', [UserRoleController::class, 'index'])->name('index');
                Route::get('/edit/{user}', [UserRoleController::class, 'edit'])->name('edit');
                Route::put('/update/{user}', [UserRoleController::class, 'update'])->name('update');
                Route::get('/permissions/{user}', [UserRoleController::class, 'permissions'])->name('permissions');
            });

            // SEO Pages Management Routes
            Route::prefix('seo-pages')->name('admin.seo-pages.')->group(function () {
                Route::get('/', [SeoPageController::class, 'index'])->name('index');
                Route::get('/edit/{id}', [SeoPageController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [SeoPageController::class, 'update'])->name('update');
            });

        });
    }
);
