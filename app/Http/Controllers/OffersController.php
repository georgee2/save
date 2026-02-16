<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\OfferCategory;
use App\Models\OfferSubCategory;
use App\Models\ProjectStyle;
use App\Models\ProjectType;
use App\Models\Specification;
use App\Models\Emirate;
use App\Models\PageBanner;

class OffersController extends Controller
{
    /**
     * Get common filter data for all offer pages
     * Only returns categories and subcategories that have at least one published offer
     */
    private function getFilterData($categoryId = null)
    {
        // Get categories that have at least one published offer
        $categories = OfferCategory::whereNull('deleted_at')
            ->whereHas('offers', function($query) {
                $query->where('publish_status', 0)->whereNull('deleted_at');
            })
            ->orderBy('title_english')
            ->get();
        
        // Get subcategories that have at least one published offer
        $subcategoriesQuery = OfferSubCategory::whereNull('deleted_at')
            ->whereHas('offers', function($query) {
                $query->where('publish_status', 0)->whereNull('deleted_at');
            })
            ->orderBy('title_english');
        
        if ($categoryId) {
            $subcategoriesQuery->where('category_id', $categoryId);
        }
        $subcategories = $subcategoriesQuery->get();
        
        $styles = ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get();
        $types = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        $emirates = Emirate::whereNull('deleted_at')->orderBy('title_english')->get();
        $specifications = Specification::whereNull('deleted_at')->orderBy('title_english')->get();
        
        // Categories with offer counts for slider filter (only those with offers)
        $categoriesWithCount = OfferCategory::withCount(['offers' => function($query) {
                $query->where('publish_status', 0)->whereNull('deleted_at');
            }])
            ->whereNull('deleted_at')
            ->having('offers_count', '>', 0)
            ->orderBy('title_english')
            ->get();
        
        // Subcategories with offer counts for slider filter (only those with offers)
        $subcategoriesWithCountQuery = OfferSubCategory::withCount(['offers' => function($query) {
                $query->where('publish_status', 0)->whereNull('deleted_at');
            }])
            ->whereNull('deleted_at')
            ->having('offers_count', '>', 0)
            ->orderBy('title_english');
        
        if ($categoryId) {
            $subcategoriesWithCountQuery->where('category_id', $categoryId);
        }
        $subcategoriesWithCount = $subcategoriesWithCountQuery->get();
        
        return compact('categories', 'subcategories', 'styles', 'types', 'emirates', 'specifications', 'categoriesWithCount', 'subcategoriesWithCount');
    }
    
    /**
     * Apply sorting to the query
     */
    private function applySorting($query, Request $request)
    {
        $sortby = $request->get('sortby', 'newest');
        
        switch ($sortby) {
            case 'oldest':
                $query->orderBy('offers.created_at', 'ASC');
                break;
            case 'price_low':
                // Order by minimum price using subquery
                $query->orderByRaw('(SELECT MIN(price) FROM offer_prices WHERE offer_prices.offer_id = offers.id AND offer_prices.status = 0) ASC');
                break;
            case 'price_high':
                // Order by maximum price using subquery
                $query->orderByRaw('(SELECT MAX(price) FROM offer_prices WHERE offer_prices.offer_id = offers.id AND offer_prices.status = 0) DESC');
                break;
            case 'area_low':
                $query->orderBy('offers.sqft', 'ASC');
                break;
            case 'area_high':
                $query->orderBy('offers.sqft', 'DESC');
                break;
            case 'newest':
            default:
                $query->orderBy('offers.created_at', 'DESC');
                break;
        }
        
        return $query;
    }
    
    /**
     * Apply common filters to the query
     */
    private function applyFilters($query, Request $request, $selectedEmirateId = null)
    {
        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        // Subcategory filter
        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }
        
        // Style filter
        if ($request->filled('style_id')) {
            $query->where('style_id', $request->style_id);
        }
        
        // Type filter
        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }
        
        // SQFT Range filter
        if ($request->filled('sqft_min')) {
            $query->where('sqft', '>=', $request->sqft_min);
        }
        if ($request->filled('sqft_max')) {
            $query->where('sqft', '<=', $request->sqft_max);
        }
        
        // SQM Range filter
        if ($request->filled('sqm_min')) {
            $query->where('sqm', '>=', $request->sqm_min);
        }
        if ($request->filled('sqm_max')) {
            $query->where('sqm', '<=', $request->sqm_max);
        }
        
        // Emirate filter - filter offers that have a price for this emirate
        if ($request->filled('emirate_id')) {
            $emirateId = $request->emirate_id;
            $query->whereHas('prices', function($q) use ($emirateId) {
                $q->where('emirate_id', $emirateId)
                  ->where('status', 0); // Active price
            });
        }
        
        // Price Range filter - filter by price in selected emirate (or any emirate if not selected)
        if ($request->filled('price_min') || $request->filled('price_max')) {
            $priceMin = $request->price_min;
            $priceMax = $request->price_max;
            $emirateId = $request->emirate_id;
            
            $query->whereHas('prices', function($q) use ($priceMin, $priceMax, $emirateId) {
                $q->where('status', 0); // Active price
                
                if ($emirateId) {
                    $q->where('emirate_id', $emirateId);
                }
                
                if ($priceMin) {
                    $q->where('price', '>=', $priceMin);
                }
                if ($priceMax) {
                    $q->where('price', '<=', $priceMax);
                }
            });
        }
        
        // Keyword search (title and SEO tags)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title_english', 'like', "%{$keyword}%")
                  ->orWhere('title_arabic', 'like', "%{$keyword}%")
                  ->orWhere('seo_tags', 'like', "%{$keyword}%");
            });
        }
        
        return $query;
    }
    
    /**
     * Process offers collection to add computed fields
     */
    private function processOffers($offers, $selectedEmirateId = null)
    {
        // Get primary emirate ID for default price display
        $primaryEmirate = Emirate::getPrimary();
        $primaryEmirateId = $primaryEmirate ? $primaryEmirate->id : null;
        
        return $offers->through(function($offer) use ($selectedEmirateId, $primaryEmirateId) {
            // Count videos (video_url and tour_url)
            $videoCount = 0;
            if (!empty($offer->video_url)) $videoCount++;
            if (!empty($offer->tour_url)) $videoCount++;
            $offer->video_count = $videoCount;
            
            // Add 1 for main image to images_count
            $offer->total_images = $offer->images_count + 1;
            
            // Get price based on selected emirate, primary emirate, or first available
            $activePrices = $offer->prices->where('status', 0);
            $offer->default_price = null;
            
            if ($selectedEmirateId) {
                // User selected a specific emirate - try to get price for it
                $offer->default_price = $activePrices
                    ->where('emirate_id', $selectedEmirateId)
                    ->first();
            }
            
            // If no selected emirate or no price found for selected, try primary emirate
            if (!$offer->default_price && $primaryEmirateId) {
                $offer->default_price = $activePrices
                    ->where('emirate_id', $primaryEmirateId)
                    ->first();
            }
            
            // Fallback to first available price if still not found
            if (!$offer->default_price) {
                $offer->default_price = $activePrices
                    ->sortBy(function($price) {
                        return $price->emirate ? $price->emirate->title_english : '';
                    })
                    ->first();
            }
            
            return $offer;
        });
    }
    
    /**
     * Display listing of all offers
     */
    public function index(Request $request)
    {
        // Get filter data
        $filterData = $this->getFilterData();
        
        // Build query - publish_status = 0 means published
        $query = Offer::where('publish_status', 0)
                      ->whereNull('deleted_at')
                      ->with(['category', 'subcategory', 'style', 'type', 'currency', 'specifications.specification', 'prices.emirate'])
                      ->withCount('images');
        
        // Apply filters
        $query = $this->applyFilters($query, $request);
        
        // Apply sorting
        $query = $this->applySorting($query, $request);
        
        // Get paginated results
        $selectedEmirateId = $request->emirate_id;
        $offers = $this->processOffers(
            $query->paginate(9)->withQueryString(),
            $selectedEmirateId
        );
        
        // Get page banner for offers page
        $pageBanner = PageBanner::getByTarget('offers');
        
        return view('pages.offers.index', array_merge(
            ['offers' => $offers, 'pageBanner' => $pageBanner],
            $filterData
        ));
    }
    
    /**
     * Display offers filtered by category
     */
    public function category(Request $request, $slug)
    {
        // Get the category by slug
        $currentCategory = OfferCategory::where('slug', $slug)
                                        ->whereNull('deleted_at')
                                        ->firstOrFail();
        
        // Get filter data (subcategories filtered by current category)
        $filterData = $this->getFilterData($currentCategory->id);
        
        // Build query - filter by category
        $query = Offer::where('publish_status', 0)
                      ->where('category_id', $currentCategory->id)
                      ->whereNull('deleted_at')
                      ->with(['category', 'subcategory', 'style', 'type', 'currency', 'specifications.specification', 'prices.emirate'])
                      ->withCount('images');
        
        // Apply additional filters (except category since we're filtering by it)
        $query = $this->applyFilters($query, $request);
        
        // Apply sorting
        $query = $this->applySorting($query, $request);
        
        // Get paginated results
        $selectedEmirateId = $request->emirate_id;
        $offers = $this->processOffers(
            $query->paginate(9)->withQueryString(),
            $selectedEmirateId
        );
        
        // Get page banner for offers page
        $pageBanner = PageBanner::getByTarget('offers');
        
        return view('pages.offers.category', array_merge(
            ['offers' => $offers, 'currentCategory' => $currentCategory, 'pageBanner' => $pageBanner],
            $filterData
        ));
    }
    
    /**
     * Display offers filtered by subcategory
     */
    public function subcategory(Request $request, $slug)
    {
        // Get the subcategory by slug
        $currentSubcategory = OfferSubCategory::where('slug', $slug)
                                              ->whereNull('deleted_at')
                                              ->with('category')
                                              ->firstOrFail();
        
        $currentCategory = $currentSubcategory->category;
        
        // Get filter data
        $filterData = $this->getFilterData($currentSubcategory->category_id);
        
        // Build query - filter by subcategory
        $query = Offer::where('publish_status', 0)
                      ->where('subcategory_id', $currentSubcategory->id)
                      ->whereNull('deleted_at')
                      ->with(['category', 'subcategory', 'style', 'type', 'currency', 'specifications.specification', 'prices.emirate'])
                      ->withCount('images');
        
        // Apply additional filters (except subcategory since we're filtering by it)
        $query = $this->applyFilters($query, $request);
        
        // Apply sorting
        $query = $this->applySorting($query, $request);
        
        // Get paginated results
        $selectedEmirateId = $request->emirate_id;
        $offers = $this->processOffers(
            $query->paginate(9)->withQueryString(),
            $selectedEmirateId
        );
        
        // Get page banner for offers page
        $pageBanner = PageBanner::getByTarget('offers');
        
        return view('pages.offers.subcategory', array_merge(
            ['offers' => $offers, 'currentCategory' => $currentCategory, 'currentSubcategory' => $currentSubcategory, 'pageBanner' => $pageBanner],
            $filterData
        ));
    }
    
    /**
     * Display single offer details
     */
    public function show(Request $request, $slug)
    {
        $offer = Offer::where('slug', $slug)
                     ->where('publish_status', 0)
                     ->whereNull('deleted_at')
                     ->with([
                         'category',
                         'subcategory',
                         'currency',
                         'style',
                         'type',
                         'images',
                         'specifications.specification',
                         'prices.emirate',
                         'floors' => function($query) {
                             $query->whereNull('deleted_at')
                                   ->with([
                                       'buildingComponent',
                                       'floorComponent',
                                       'specifications.specification',
                                       'amenities.amenity'
                                   ]);
                         },
                         'feasibilityStudies' => function($query) {
                             $query->whereNull('deleted_at')
                                   ->where('status', 'Active')
                                   ->with([
                                       'currency',
                                       'emirate',
                                       'buildingComponents.buildingComponent',
                                       'lengthComponents.lengthComponent',
                                       'incomeComponents.incomeComponent',
                                       'constructionCosts.substationRoom',
                                       'constructionCosts.pumpsRoom',
                                       'projectCost'
                                   ]);
                         }
                     ])
                     ->firstOrFail();
        
        // Get all emirates for the price selector
        $emirates = Emirate::whereNull('deleted_at')->orderBy('title_english')->get();
        
        // Get primary emirate for default selection
        $primaryEmirate = Emirate::getPrimary();
        $primaryEmirateId = $primaryEmirate ? $primaryEmirate->id : null;
        
        // Count videos
        $videoCount = 0;
        if (!empty($offer->video_url)) $videoCount++;
        if (!empty($offer->tour_url)) $videoCount++;
        $offer->video_count = $videoCount;
        
        // Total images
        $offer->total_images = $offer->images->count() + 1;
        
        // Get selected emirate from request, or use primary emirate as default
        $selectedEmirateId = $request->emirate_id;
        $activePrices = $offer->prices->where('status', 0);
        
        if ($selectedEmirateId) {
            $offer->selected_price = $activePrices->where('emirate_id', $selectedEmirateId)->first();
        }
        
        // Default price - try primary emirate first, then first available
        $offer->default_price = null;
        
        if ($primaryEmirateId) {
            $offer->default_price = $activePrices
                ->where('emirate_id', $primaryEmirateId)
                ->first();
        }
        
        // Fallback to first available if no primary emirate price
        if (!$offer->default_price) {
            $offer->default_price = $activePrices
                ->sortBy(function($price) {
                    return $price->emirate ? $price->emirate->title_english : '';
                })
                ->first();
        }
        
        // If no selected price, use default
        if (!isset($offer->selected_price) || !$offer->selected_price) {
            $offer->selected_price = $offer->default_price;
        }
        
        // Get all active prices for the emirate selector
        $offer->all_prices = $activePrices->sortBy(function($price) {
            return $price->emirate ? $price->emirate->title_english : '';
        })->values();
        
        return view('pages.offers.show', compact('offer', 'emirates', 'primaryEmirateId'));
    }
}
