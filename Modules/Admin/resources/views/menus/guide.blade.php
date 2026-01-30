@extends('admin::layouts.master')
@section('title', 'Menu Management Guide')

@section('css')
<style>
    .guide-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .guide-section {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .guide-section-header {
        background: linear-gradient(135deg, #19868b 0%, #25a5aa 100%);
        color: #fff;
        padding: 20px 25px;
    }
    
    .guide-section-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }
    
    .guide-section-header .section-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        margin-right: 12px;
        font-weight: 700;
    }
    
    .guide-section-body {
        padding: 25px;
    }
    
    .guide-step {
        display: flex;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px dashed #e9ecef;
    }
    
    .guide-step:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .step-number {
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        background: #e3f2fd;
        color: #1565c0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        margin-right: 15px;
    }
    
    .step-content {
        flex-grow: 1;
    }
    
    .step-content h5 {
        margin: 0 0 8px;
        color: #333;
        font-size: 16px;
    }
    
    .step-content p {
        margin: 0;
        color: #666;
        line-height: 1.6;
    }
    
    .guide-tip {
        background: #fff3e0;
        border-left: 4px solid #ff9800;
        padding: 15px 20px;
        margin: 15px 0;
        border-radius: 0 8px 8px 0;
    }
    
    .guide-tip i {
        color: #ff9800;
        margin-right: 8px;
    }
    
    .guide-warning {
        background: #ffebee;
        border-left: 4px solid #f44336;
        padding: 15px 20px;
        margin: 15px 0;
        border-radius: 0 8px 8px 0;
    }
    
    .guide-warning i {
        color: #f44336;
        margin-right: 8px;
    }
    
    .guide-success {
        background: #e8f5e9;
        border-left: 4px solid #4caf50;
        padding: 15px 20px;
        margin: 15px 0;
        border-radius: 0 8px 8px 0;
    }
    
    .guide-success i {
        color: #4caf50;
        margin-right: 8px;
    }
    
    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .feature-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #19868b 0%, #25a5aa 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        color: #fff;
        font-size: 24px;
    }
    
    .feature-card h5 {
        margin: 0 0 10px;
        color: #333;
    }
    
    .feature-card p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }
    
    .item-type-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    
    .item-type-table th,
    .item-type-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }
    
    .item-type-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
    }
    
    .item-type-table tr:hover td {
        background: #f8f9fa;
    }
    
    .badge-type {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-static { background: #e3f2fd; color: #1565c0; }
    .badge-dynamic { background: #e8f5e9; color: #2e7d32; }
    .badge-query { background: #f3e5f5; color: #7b1fa2; }
    .badge-divider { background: #fce4ec; color: #c2185b; }
    
    .toc-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .toc-list li {
        padding: 10px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .toc-list li:last-child {
        border-bottom: none;
    }
    
    .toc-list a {
        color: #19868b;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
    }
    
    .toc-list a:hover {
        color: #0d5f62;
    }
    
    .toc-list a i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }
    
    .screenshot-placeholder {
        background: #f0f0f0;
        border: 2px dashed #ccc;
        border-radius: 8px;
        padding: 40px;
        text-align: center;
        color: #999;
        margin: 15px 0;
    }
    
    .code-example {
        background: #2d2d2d;
        color: #f8f8f2;
        padding: 15px 20px;
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-size: 13px;
        overflow-x: auto;
        margin: 15px 0;
    }
    
    .code-example .comment {
        color: #6272a4;
    }
    
    .code-example .keyword {
        color: #ff79c6;
    }
    
    .code-example .string {
        color: #f1fa8c;
    }
</style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="container-fluid">
        
        <nav class="breadcrumbs">
            <a href="{{route('Admin')}}" class="breadcrumbs__item"> <i class="fa fa-home"></i> Dashboard</a>
            <a href="{{route('admin.menu.index')}}" class="breadcrumbs__item"><i class="fa fa-bars"></i> Menus</a>
            <a style="pointer-events: none;" href="#" class="breadcrumbs__item is-active"><i class="fa fa-book"></i> User Guide</a>
        </nav>

        <div class="col-lg-12">
            <hr>
            
            <div class="guide-container">
                
                {{-- Header --}}
                <div class="text-center mb-5">
                    <h2 style="color: #19868b; font-weight: 700; margin-bottom: 10px;">
                        <i class="fa fa-bars"></i> Menu Management System
                    </h2>
                    <p class="text-muted" style="font-size: 16px;">Complete guide for managing website navigation menus</p>
                    <div class="mt-3">
                        <a href="{{ route('admin.menu.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left"></i> Back to Menus
                        </a>
                    </div>
                </div>
                
                {{-- Table of Contents --}}
                <div class="guide-section">
                    <div class="guide-section-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h3><i class="fa fa-list-ol"></i> Table of Contents</h3>
                    </div>
                    <div class="guide-section-body">
                        <ul class="toc-list">
                            <li><a href="#section-overview"><i class="fa fa-info-circle"></i> 1. System Overview</a></li>
                            <li><a href="#section-global-search"><i class="fa fa-search"></i> 2. Global Search Bar</a></li>
                            <li><a href="#section-primary"><i class="fa fa-star"></i> 3. Understanding the Primary Menu</a></li>
                            <li><a href="#section-create"><i class="fa fa-plus"></i> 4. Creating a New Menu</a></li>
                            <li><a href="#section-items"><i class="fa fa-list"></i> 5. Managing Menu Items</a></li>
                            <li><a href="#section-quicklinks"><i class="fa fa-bolt"></i> 6. Quick Links (Ready Options)</a></li>
                            <li><a href="#section-dynamic"><i class="fa fa-database"></i> 7. Dynamic Query Items</a></li>
                            <li><a href="#section-visibility"><i class="fa fa-eye"></i> 8. Visibility Controls</a></li>
                            <li><a href="#section-dragdrop"><i class="fa fa-arrows"></i> 9. Drag & Drop Ordering</a></li>
                            <li><a href="#section-tips"><i class="fa fa-lightbulb-o"></i> 10. Tips & Best Practices</a></li>
                        </ul>
                    </div>
                </div>
                
                {{-- Section: Global Search Bar --}}
                <div class="guide-section" id="section-global-search">
                    <div class="guide-section-header" style="background: linear-gradient(135deg, #19868b 0%, #e1273d 100%);">
                        <h3><span class="section-number">2</span> Global Search Bar</h3>
                    </div>
                    <div class="guide-section-body">
                        <p style="font-size: 16px; color: #555; line-height: 1.8;">
                            The website features a powerful global search bar that allows visitors to search across Offers and Projects with location-based filtering.
                        </p>
                        
                        <h4 style="margin-top: 20px; color: #333;">Search Bar Features:</h4>
                        
                        <div class="feature-grid">
                            <div class="feature-card">
                                <div class="feature-icon" style="background: linear-gradient(135deg, #e1273d 0%, #ff6b6b 100%);"><i class="fa fa-tags"></i></div>
                                <h5>Offers / Projects Tabs</h5>
                                <p>Toggle between searching Offers or Projects using the red/teal tabs</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon" style="background: linear-gradient(135deg, #19868b 0%, #38ef7d 100%);"><i class="fa fa-map-marker-alt"></i></div>
                                <h5>Emirates Filter</h5>
                                <p>Filter results by emirate location (Dubai, Abu Dhabi, Sharjah, etc.)</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"><i class="fa fa-search"></i></div>
                                <h5>Live Search</h5>
                                <p>Instant results appear as you type with images and details</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"><i class="fa fa-sliders-h"></i></div>
                                <h5>Advanced Filters</h5>
                                <p>Category, subcategory, type, style, and area size filters</p>
                            </div>
                        </div>
                        
                        <div class="guide-tip">
                            <i class="fa fa-lightbulb-o"></i>
                            <strong>How it works:</strong> When a user selects an emirate and navigates to Offers or Projects, the page automatically filters to show only items available in that emirate with corresponding prices.
                        </div>
                        
                        <h4 style="margin-top: 25px; color: #333;">Search Bar Components:</h4>
                        
                        <table class="item-type-table">
                            <thead>
                                <tr>
                                    <th>Component</th>
                                    <th>Description</th>
                                    <th>Behavior</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge-type" style="background: #e1273d; color: #fff;">OFFERS</span></td>
                                    <td>Offers tab button</td>
                                    <td>Filters search to Offers only</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-type" style="background: #19868b; color: #fff;">PROJECTS</span></td>
                                    <td>Projects tab button</td>
                                    <td>Filters search to Projects only</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-type badge-dynamic">Emirates Dropdown</span></td>
                                    <td>Location selector</td>
                                    <td>Filters by emirate, updates prices on listing pages</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-type badge-static">Search Input</span></td>
                                    <td>Keyword search field</td>
                                    <td>Live search with 2+ characters, shows instant results</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-type badge-query">Advanced Search</span></td>
                                    <td>Expandable filters panel</td>
                                    <td>Category, subcategory, type, style, area filters</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="guide-success">
                            <i class="fa fa-check-circle"></i>
                            <strong>Auto-sync:</strong> The emirate selection in the global search bar automatically syncs with the filter sidebar on listing pages, ensuring consistent filtering across the site.
                        </div>
                    </div>
                </div>
                
                {{-- Section 1: Overview --}}
                <div class="guide-section" id="section-overview">
                    <div class="guide-section-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <h3><span class="section-number">1</span> System Overview</h3>
                    </div>
                    <div class="guide-section-body">
                        <p style="font-size: 16px; color: #555; line-height: 1.8;">
                            The Menu Management System allows you to create and manage navigation menus for your website. 
                            You can create multiple menus for different locations (header, footer, sidebar) and customize 
                            each menu with static links, dynamic content from your database, or custom filtered queries.
                        </p>
                        
                        <div class="feature-grid">
                            <div class="feature-card">
                                <div class="feature-icon"><i class="fa fa-bars"></i></div>
                                <h5>Multiple Menus</h5>
                                <p>Create separate menus for header, footer, sidebar, and mobile navigation</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon"><i class="fa fa-sitemap"></i></div>
                                <h5>Nested Items</h5>
                                <p>Create multi-level dropdown menus with unlimited nesting depth</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon"><i class="fa fa-database"></i></div>
                                <h5>Dynamic Content</h5>
                                <p>Pull menu items automatically from Services, Offers, Projects, or News</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon"><i class="fa fa-filter"></i></div>
                                <h5>Custom Queries</h5>
                                <p>Filter dynamic content by specific categories or subcategories</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon"><i class="fa fa-arrows"></i></div>
                                <h5>Drag & Drop</h5>
                                <p>Easily reorder menu items with intuitive drag and drop</p>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon"><i class="fa fa-language"></i></div>
                                <h5>Bilingual Support</h5>
                                <p>Full English and Arabic support for all menu items</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Section 3: Primary Menu --}}
                <div class="guide-section" id="section-primary">
                    <div class="guide-section-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <h3><span class="section-number">3</span> Understanding the Primary Menu</h3>
                    </div>
                    <div class="guide-section-body">
                        <p>The <strong>Primary Menu</strong> is the main navigation menu displayed in your website header. It has special protection to prevent accidental deletion.</p>
                        
                        <div class="guide-warning">
                            <i class="fa fa-exclamation-triangle"></i>
                            <strong>Important:</strong> The Primary Menu cannot be deleted. You can only hide it by setting it to "Inactive" or modify its items.
                        </div>
                        
                        <h4 style="margin-top: 25px; color: #333;">Primary Menu Characteristics:</h4>
                        
                        <div class="guide-step">
                            <div class="step-number"><i class="fa fa-star"></i></div>
                            <div class="step-content">
                                <h5>Protected from Deletion</h5>
                                <p>The primary menu has a lock icon and cannot be deleted. This ensures your main navigation is always available.</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number"><i class="fa fa-eye"></i></div>
                            <div class="step-content">
                                <h5>Can Be Hidden</h5>
                                <p>You can toggle the menu to "Inactive" to hide it from the website without deleting it.</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number"><i class="fa fa-edit"></i></div>
                            <div class="step-content">
                                <h5>Fully Editable Items</h5>
                                <p>All menu items within the primary menu can be added, edited, reordered, or removed freely.</p>
                            </div>
                        </div>
                        
                        <div class="guide-success">
                            <i class="fa fa-check-circle"></i>
                            <strong>Pre-configured:</strong> The primary menu comes pre-seeded with your current website navigation structure including Home, Services, Offers, Projects, About, and Contact.
                        </div>
                    </div>
                </div>
                
                {{-- Section 4: Creating a Menu --}}
                <div class="guide-section" id="section-create">
                    <div class="guide-section-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <h3><span class="section-number">4</span> Creating a New Menu</h3>
                    </div>
                    <div class="guide-section-body">
                        <p>Follow these steps to create a new custom menu:</p>
                        
                        <div class="guide-step">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h5>Go to Menu Management</h5>
                                <p>Navigate to <strong>Settings → Menu Management → Add New Menu</strong> in the admin sidebar.</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h5>Enter Menu Details</h5>
                                <p>Fill in the following required fields:</p>
                                <ul style="margin-top: 10px; color: #666;">
                                    <li><strong>Title (English):</strong> Name of the menu (e.g., "Footer Menu")</li>
                                    <li><strong>Title (Arabic):</strong> Arabic translation of the menu name</li>
                                    <li><strong>Slug:</strong> Unique identifier (auto-generated from title)</li>
                                    <li><strong>Location:</strong> Where the menu will be used (Header, Footer, Sidebar, Mobile)</li>
                                    <li><strong>Status:</strong> Active or Inactive</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h5>Save the Menu</h5>
                                <p>Click "Create Menu" to save. You'll be redirected to the menus list where you can start adding items.</p>
                            </div>
                        </div>
                        
                        <div class="guide-tip">
                            <i class="fa fa-lightbulb-o"></i>
                            <strong>Tip:</strong> Use descriptive names and slugs for your menus to easily identify them later. Example: "footer-links", "mobile-nav", "sidebar-menu".
                        </div>
                    </div>
                </div>
                
                {{-- Section 5: Managing Menu Items --}}
                <div class="guide-section" id="section-items">
                    <div class="guide-section-header" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <h3><span class="section-number">5</span> Managing Menu Items</h3>
                    </div>
                    <div class="guide-section-body">
                        <p>Menu items are the individual links that appear in your menu. Here are the available item types:</p>
                        
                        <table class="item-type-table">
                            <thead>
                                <tr>
                                    <th>Item Type</th>
                                    <th>Description</th>
                                    <th>Use Case</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge-type badge-static">Static Link</span></td>
                                    <td>A manual link to any page or URL</td>
                                    <td>Home, About Us, Contact, External links</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-type badge-dynamic">Dynamic: Services</span></td>
                                    <td>Automatically pulls all published services</td>
                                    <td>Services dropdown menu</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-type badge-dynamic">Dynamic: Offers</span></td>
                                    <td>Automatically pulls offer categories</td>
                                    <td>Offers dropdown menu</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-type badge-dynamic">Dynamic: Projects</span></td>
                                    <td>Automatically pulls project categories</td>
                                    <td>Projects dropdown menu</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-type badge-dynamic">Dynamic: News</span></td>
                                    <td>Automatically pulls news categories</td>
                                    <td>News/Blog dropdown menu</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-type badge-dynamic">Dynamic: Interior</span></td>
                                    <td>Automatically pulls interior design categories</td>
                                    <td>Interior Design dropdown menu</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-type badge-query">Dynamic Query</span></td>
                                    <td>Custom filtered content from categories</td>
                                    <td>Specific category pages, filtered content</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-type badge-divider">Divider</span></td>
                                    <td>A visual separator line</td>
                                    <td>Separating menu sections</td>
                                </tr>
                                <tr>
                                    <td><span class="badge-type badge-divider">Section Header</span></td>
                                    <td>A non-clickable section title</td>
                                    <td>Labeling menu sections</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <h4 style="margin-top: 30px; color: #333;">Adding a Menu Item:</h4>
                        
                        <div class="guide-step">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h5>Click "Add New Item"</h5>
                                <p>From the menu items page, click the "Add New Item" button in the top right.</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h5>Choose Item Type</h5>
                                <p>Select the type of item you want to add (Static, Dynamic, Query, etc.)</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h5>Configure the Item</h5>
                                <p>Fill in the title, link/route, icon, and visibility settings based on the item type.</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h5>Set Parent (Optional)</h5>
                                <p>To create a nested/dropdown item, select a parent item from the dropdown.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Section 6: Quick Links --}}
                <div class="guide-section" id="section-quicklinks">
                    <div class="guide-section-header" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);">
                        <h3><span class="section-number">6</span> Quick Links (Ready Options)</h3>
                    </div>
                    <div class="guide-section-body">
                        <p>When creating a <strong>Static Link</strong> menu item, you can use the Quick Links feature to instantly populate common pages.</p>
                        
                        <div class="guide-success">
                            <i class="fa fa-bolt"></i>
                            <strong>One-Click Setup:</strong> Click any Quick Link button to automatically fill in the route, title, and icon for that page.
                        </div>
                        
                        <h4 style="margin-top: 20px; color: #333;">Available Quick Links:</h4>
                        
                        <table class="item-type-table">
                            <thead>
                                <tr>
                                    <th>Quick Link</th>
                                    <th>Route</th>
                                    <th>Icon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="fa fa-home text-primary"></i> Home Page</td>
                                    <td><code>index</code></td>
                                    <td><code>fa fa-home</code></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-info-circle text-info"></i> About Us</td>
                                    <td><code>about</code></td>
                                    <td><code>fa fa-info-circle</code></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-envelope text-success"></i> Contact Us</td>
                                    <td><code>contact</code></td>
                                    <td><code>fa fa-envelope</code></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-cogs text-secondary"></i> Services</td>
                                    <td><code>services.index</code></td>
                                    <td><code>fa fa-cogs</code></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-tags text-warning"></i> Offers</td>
                                    <td><code>offers.index</code></td>
                                    <td><code>fa fa-tags</code></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-building text-dark"></i> Projects</td>
                                    <td><code>projects.index</code></td>
                                    <td><code>fa fa-building</code></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-handshake text-info"></i> Partners</td>
                                    <td><code>partners.index</code></td>
                                    <td><code>fa fa-handshake</code></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-map-marker-alt text-primary"></i> Our Branches</td>
                                    <td><code>branches.index</code></td>
                                    <td><code>fa fa-map-marker-alt</code></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-users text-success"></i> Our Team</td>
                                    <td><code>team.index</code></td>
                                    <td><code>fa fa-users</code></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-user-tie text-danger"></i> Board of Directors</td>
                                    <td><code>team.board</code></td>
                                    <td><code>fa fa-user-tie</code></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-briefcase text-warning"></i> Careers</td>
                                    <td><code>careers.index</code></td>
                                    <td><code>fa fa-briefcase</code></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-newspaper text-secondary"></i> News / Blog</td>
                                    <td><code>blogs.index</code></td>
                                    <td><code>fa fa-newspaper</code></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-couch text-info"></i> Interior Design</td>
                                    <td><code>interior.index</code></td>
                                    <td><code>fa fa-couch</code></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="guide-tip">
                            <i class="fa fa-lightbulb-o"></i>
                            <strong>Tip:</strong> Quick Links only appear when "Static Link" item type is selected. They auto-fill the title only if the title field is empty.
                        </div>
                    </div>
                </div>
                
                {{-- Section 7: Dynamic Query Items --}}
                <div class="guide-section" id="section-dynamic">
                    <div class="guide-section-header" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                        <h3><span class="section-number">7</span> Dynamic Query Items</h3>
                    </div>
                    <div class="guide-section-body">
                        <p>Dynamic Query items allow you to create menu links that pull content from specific categories or subcategories. This is useful for creating filtered landing pages.</p>
                        
                        <h4 style="margin-top: 20px; color: #333;">Available Data Sources:</h4>
                        
                        <table class="item-type-table">
                            <thead>
                                <tr>
                                    <th>Source</th>
                                    <th>Categories</th>
                                    <th>Subcategories</th>
                                    <th>Use Case</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Offers</strong></td>
                                    <td>Offer Categories ✓</td>
                                    <td>Offer Subcategories ✓</td>
                                    <td>Real estate offers, property listings</td>
                                </tr>
                                <tr>
                                    <td><strong>Projects</strong></td>
                                    <td>Engineering Categories ✓</td>
                                    <td>Engineering Subcategories ✓</td>
                                    <td>Engineering projects, portfolio</td>
                                </tr>
                                <tr>
                                    <td><strong>Interior Design</strong></td>
                                    <td>Interior Categories ✓</td>
                                    <td>Not Available ✗</td>
                                    <td>Interior design gallery, showroom</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="guide-tip">
                            <i class="fa fa-lightbulb-o"></i>
                            <strong>Interior Design Note:</strong> Interior Design only supports category-level filtering. Subcategory filtering is not available for this source.
                        </div>
                        
                        <h4 style="margin-top: 30px; color: #333;">Creating a Dynamic Query Item:</h4>
                        
                        <div class="guide-step">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h5>Select "Dynamic Query" Type</h5>
                                <p>Choose "Dynamic Query: Custom Categories/Subcategories" from the Item Type dropdown.</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h5>Choose Data Source</h5>
                                <p>Select where to pull data from: Offers, Projects, or Interior Design.</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h5>Select Query Type</h5>
                                <ul style="margin-top: 10px; color: #666;">
                                    <li><strong>All Items:</strong> Returns all items from the source</li>
                                    <li><strong>Filter by Categories:</strong> Select specific categories to include</li>
                                    <li><strong>Filter by Subcategories:</strong> Select specific subcategories (if available)</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h5>Select Categories/Subcategories</h5>
                                <p>Use the multi-select dropdowns to choose one or more categories or subcategories.</p>
                            </div>
                        </div>
                        
                        <div class="guide-tip">
                            <i class="fa fa-lightbulb-o"></i>
                            <strong>Example:</strong> Create a "Villa Projects" menu item that only shows projects from the "Villas" category by selecting "Projects" as source, "Filter by Categories" as type, and selecting the "Villas" category.
                        </div>
                    </div>
                </div>
                
                {{-- Section 8: Visibility Controls --}}
                <div class="guide-section" id="section-visibility">
                    <div class="guide-section-header" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                        <h3><span class="section-number">8</span> Visibility Controls</h3>
                    </div>
                    <div class="guide-section-body">
                        <p>Control when and where menu items appear using these visibility options.</p>
                        
                        <h4 style="margin-top: 20px; color: #333;">Menu Item Visibility Options:</h4>
                        
                        <table class="item-type-table">
                            <thead>
                                <tr>
                                    <th>Option</th>
                                    <th>Values</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>Active / Inactive</td>
                                    <td>Master switch - inactive items are hidden everywhere</td>
                                </tr>
                                <tr>
                                    <td><strong>Visible on Desktop</strong></td>
                                    <td>Yes / No</td>
                                    <td>Show/hide on desktop screens (992px+)</td>
                                </tr>
                                <tr>
                                    <td><strong>Visible on Mobile</strong></td>
                                    <td>Yes / No</td>
                                    <td>Show/hide on mobile/tablet screens</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="guide-tip">
                            <i class="fa fa-lightbulb-o"></i>
                            <strong>Use Case:</strong> Create a "Call Us" button visible only on mobile, or hide complex dropdowns on mobile for better UX.
                        </div>
                        
                        <h4 style="margin-top: 25px; color: #333;">Dynamic Item Options:</h4>
                        
                        <div class="guide-step">
                            <div class="step-number"><i class="fa fa-sitemap"></i></div>
                            <div class="step-content">
                                <h5>Show Children</h5>
                                <p>For dynamic items (Services, Offers, Projects, etc.), this controls whether sub-items are displayed as a dropdown. Set to "No" for a direct link to the listing page.</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number"><i class="fa fa-list-ol"></i></div>
                            <div class="step-content">
                                <h5>Max Children</h5>
                                <p>Limit the number of dynamic children shown. Leave empty to show all. Useful for keeping menus compact.</p>
                            </div>
                        </div>
                        
                        <div class="guide-warning">
                            <i class="fa fa-exclamation-triangle"></i>
                            <strong>Note:</strong> If "Show Children" is set to "No" for a dynamic item, make sure the route is set to the listing page (e.g., <code>offers.index</code>).
                        </div>
                    </div>
                </div>
                
                {{-- Section 9: Drag & Drop --}}
                <div class="guide-section" id="section-dragdrop">
                    <div class="guide-section-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h3><span class="section-number">9</span> Drag & Drop Ordering</h3>
                    </div>
                    <div class="guide-section-body">
                        <p>The menu items page supports drag and drop for easy reordering and nesting.</p>
                        
                        <div class="guide-step">
                            <div class="step-number"><i class="fa fa-arrows-v"></i></div>
                            <div class="step-content">
                                <h5>Reorder Items</h5>
                                <p>Click and hold the drag handle (⋮⋮) on the left side of any item, then drag it to a new position.</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number"><i class="fa fa-level-down"></i></div>
                            <div class="step-content">
                                <h5>Create Nested Items</h5>
                                <p>Drag an item onto another item to make it a child (dropdown item). The item will be indented to show the hierarchy.</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number"><i class="fa fa-save"></i></div>
                            <div class="step-content">
                                <h5>Auto-Save</h5>
                                <p>Changes are automatically saved when you drop an item. A success message will confirm the save.</p>
                            </div>
                        </div>
                        
                        <div class="guide-success">
                            <i class="fa fa-check-circle"></i>
                            <strong>No limits:</strong> You can create as many nesting levels as needed. However, for usability, we recommend keeping dropdown menus to 2-3 levels maximum.
                        </div>
                    </div>
                </div>
                
                {{-- Section 10: Tips --}}
                <div class="guide-section" id="section-tips">
                    <div class="guide-section-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <h3><span class="section-number">10</span> Tips & Best Practices</h3>
                    </div>
                    <div class="guide-section-body">
                        
                        <div class="guide-tip">
                            <i class="fa fa-lightbulb-o"></i>
                            <strong>Keep Menus Simple:</strong> Limit top-level items to 7 or fewer for better user experience. Use dropdowns for additional items.
                        </div>
                        
                        <div class="guide-tip">
                            <i class="fa fa-lightbulb-o"></i>
                            <strong>Use Descriptive Titles:</strong> Make menu item titles clear and concise. Users should immediately understand where the link will take them.
                        </div>
                        
                        <div class="guide-tip">
                            <i class="fa fa-lightbulb-o"></i>
                            <strong>Test on Mobile:</strong> Always check how your menu appears on mobile devices. Use the mobile visibility toggle to hide desktop-only items.
                        </div>
                        
                        <div class="guide-tip">
                            <i class="fa fa-lightbulb-o"></i>
                            <strong>Use Icons Wisely:</strong> Icons can improve visual recognition, but don't overuse them. They work best for important or frequently-used items.
                        </div>
                        
                        <div class="guide-warning">
                            <i class="fa fa-exclamation-triangle"></i>
                            <strong>Avoid Deep Nesting:</strong> Menus with more than 3 levels become difficult to navigate. Consider using landing pages instead.
                        </div>
                        
                        <div class="guide-success">
                            <i class="fa fa-check-circle"></i>
                            <strong>Regular Review:</strong> Periodically review your menus to ensure all links are working and the structure still makes sense.
                        </div>
                        
                        <hr style="margin: 30px 0;">
                        
                        <div class="text-center">
                            <h4 style="color: #333; margin-bottom: 20px;">Ready to Get Started?</h4>
                            <a href="{{ route('admin.menu.index') }}" class="btn btn-primary btn-lg">
                                <i class="fa fa-bars"></i> Go to Menu Management
                            </a>
                            <a href="{{ route('admin.menu.create') }}" class="btn btn-success btn-lg ml-2">
                                <i class="fa fa-plus"></i> Create New Menu
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Smooth scroll for TOC links
    $('a[href^="#section-"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 20
            }, 500);
        }
    });
});
</script>
@endsection
