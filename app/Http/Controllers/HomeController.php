<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\HomeBlock;
use App\Models\Card;
use App\Models\Service;
use App\Models\Showcase;
use App\Models\Project;
use App\Models\Team;
use App\Models\Portfolio;
use App\Models\PortfolioType;
use App\Models\HomeContact;
use App\Models\ContactInformation;
use App\Models\HomeFaq;
use App\Models\News;
use App\Models\Fact;
use App\Models\DefaultProcess;
use App\Models\DefaultProcessCard;
use App\Models\DefaultBanner;

class HomeController extends Controller
{
    public function __construct()
    {
        //
    }

    public function inactive()
    {
        return view('inactive');
    }

    public function index()
    {
        // Fetch published sliders ordered by ordering field
        $sliders = Slider::published();
        
        // Fetch active about section home block
        $aboutBlock = HomeBlock::where('location', 'about_section')
            ->where('status', 0)
            ->whereNull('deleted_at')
            ->first();
        
        // Initialize empty collection for cards
        $aboutCards = collect([]);
        
        // Fetch active cards related to about section, ordered by id ASC
        // We need 4 icon cards + 1 background card = 5 total
        if ($aboutBlock) {
            $aboutCards = Card::where('home_block_id', $aboutBlock->id)
                ->where('status', 0)
                ->whereNull('deleted_at')
                ->orderBy('id', 'asc')
                ->get();
        }
        
        // Fetch services for home (published, shown in home, not sub service)
        $serviceModel = new Service();
        $services = $serviceModel->serviceshome();
        
        // Fetch showcases for home (active, shown in home, ordered by newest, limit 10)
        $showcases = Showcase::where('status', 'active')
            ->where('home_status', 'shown')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Fetch active facts ordered by ordering field
        $facts = Fact::where('status', 0) // 0 = Active
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->get();
        
        // Fetch the last active default process
        $defaultProcess = DefaultProcess::where('status', 0)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->first();
        
        // Fetch active cards for the process if it exists
        $processCards = collect([]);
        if ($defaultProcess) {
            $processCards = DefaultProcessCard::where('default_process_id', $defaultProcess->id)
                ->where('status', 0)
                ->whereNull('deleted_at')
                ->orderBy('ordering', 'asc')
                ->get();
        }
        
        // Fetch active "Why Choose Us" home block
        $whyChooseUsBlock = HomeBlock::where('location', 'why_choose_us')
            ->where('status', 0)
            ->whereNull('deleted_at')
            ->first();
        
        // Initialize empty collection for why choose us cards
        $whyChooseUsCards = collect([]);
        
        // Fetch active cards related to why choose us section, ordered by id ASC
        if ($whyChooseUsBlock) {
            $whyChooseUsCards = Card::where('home_block_id', $whyChooseUsBlock->id)
                ->where('status', 0)
                ->whereNull('deleted_at')
                ->orderBy('id', 'asc')
                ->get();
        }
        
        // Fetch engineering projects (published and shown on home) with their categories
        $engineeringProjects = Project::with('category')
            ->where('publish_status', 0) // Published
            ->where('home_status', 0)    // Shown on home
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Fetch team members with their job titles
        $teamMembers = Team::with('jobTitle')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Fetch active portfolio types for tabs
        $portfolioTypes = PortfolioType::where('status', 0)
            ->whereNull('deleted_at')
            ->orderBy('name_english', 'asc')
            ->get();
        
        // Fetch latest 6 published portfolios shown on home
        $portfolios = Portfolio::with('portfolioType')
            ->where('status', 0) // Published
            ->where('home_status', 0) // Shown on home
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        
        // Fetch home contact information
        $homeContact = HomeContact::getSingle();
        
        // Fetch contact information (phone, email, social media)
        $contactInfo = ContactInformation::getContactInfo();
        
        // Fetch active home FAQs ordered by order field
        $homeFaqs = HomeFaq::getHomeFaqs();
        
        // Fetch latest news/blogs ordered by newest created
        $newsModel = new News();
        $blogs = $newsModel->getlastnews();
        
        // Fetch the last active default banner (most recent)
        $defaultBanner = DefaultBanner::where('status', 0)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->first();
        
        return view('index', compact('sliders', 'aboutBlock', 'aboutCards', 'services', 'showcases', 'facts', 'defaultProcess', 'processCards', 'whyChooseUsBlock', 'whyChooseUsCards', 'engineeringProjects', 'teamMembers', 'portfolioTypes', 'portfolios', 'homeContact', 'contactInfo', 'homeFaqs', 'blogs', 'defaultBanner'));
    }
}
