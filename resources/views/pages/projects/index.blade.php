@extends('layouts.master')
@section('title', __('lang.projects_page_title'))

@section('css')
<style>
/* Sidebar Styles */
.filter-sidebar {
  background: #fff;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.08);
  padding: 35px 25px;
  position: sticky;
  top: 100px;
  overflow: hidden;
}

.sidebar-header {
  margin-bottom: 30px;
  padding-bottom: 20px;
  border-bottom: 3px solid #ff5722;
}

.sidebar-header h4 {
  font-size: 22px;
  font-weight: 700;
  color: #1a1a1a;
  margin: 0;
  display: flex;
  align-items: center;
}

.sidebar-header h4 i {
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%);
  color: white;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 12px;
  font-size: 18px;
}

.filter-section {
  margin-bottom: 25px;
  padding-bottom: 20px;
  border-bottom: 1px solid #f0f0f0;
  position: relative;
  width: 100%;
}

.filter-section:last-child {
  border-bottom: none;
  margin-bottom: 0;
  padding-bottom: 0;
}

.filter-title {
  font-size: 13px;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 12px;
  display: flex;
  align-items: flex-start;
  text-transform: uppercase;
  letter-spacing: 0.3px;
  width: 100%;
  position: relative;
}

.filter-title i {
  width: 26px;
  height: 26px;
  background: #fff5f2;
  color: #ff5722;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 8px;
  font-size: 13px;
  flex-shrink: 0;
  margin-top: 0;
}

.filter-title span {
  flex: 1;
  line-height: 1.3;
  white-space: normal;
  word-wrap: break-word;
  margin-top: 0;
  padding-top: 10px;
}

.filter-sidebar form {
  width: 100%;
  position: relative;
}

.filter-sidebar .form-control,
.filter-sidebar .form-select {
  border: 2px solid #f0f0f0;
  border-radius: 10px;
  padding: 12px 16px;
  font-size: 14px;
  transition: all 0.3s ease;
  background: #fafafa;
  width: 100%;
}

.filter-sidebar .form-control:focus,
.filter-sidebar .form-select:focus {
  border-color: #ff5722;
  box-shadow: 0 0 0 0.2rem rgba(255, 87, 34, 0.1);
  background: #fff;
}

.filter-sidebar .btn-primary {
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%);
  border: none;
  border-radius: 10px;
  padding: 14px 30px;
  font-weight: 700;
  width: 100%;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-size: 14px;
}

.filter-sidebar .btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(255, 87, 34, 0.4);
}

.filter-sidebar .btn-secondary {
  background: #f0f0f0;
  color: #666;
  border: none;
  border-radius: 10px;
  padding: 12px 25px;
  font-weight: 600;
  width: 100%;
  margin-top: 10px;
  transition: all 0.3s ease;
}

.filter-sidebar .btn-secondary:hover {
  background: #e0e0e0;
  color: #333;
}

.range-inputs {
  display: flex;
  gap: 10px;
  align-items: center;
}

.range-inputs .form-control {
  flex: 1;
}

.range-inputs span {
  color: #ff5722;
  font-weight: 700;
  font-size: 16px;
}

.spec-value-input {
  margin-top: 12px;
  display: none;
}

.spec-value-input.active {
  display: block;
  animation: slideDown 0.3s ease;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Project Item Styles */
.project-item {
  transition: all 0.4s ease;
  border-radius: 15px;
  overflow: hidden;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.project-item:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.project-item .project-img {
  height: 320px;
  overflow: hidden;
  position: relative;
}

.project-item .project-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.project-item:hover .project-img img {
  transform: scale(1.1);
}

.project-item .project-content {
  padding: 25px;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.project-item .categories {
  margin-bottom: 12px;
}

.project-item .categories a {
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%);
  color: white;
  padding: 6px 16px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  transition: all 0.3s ease;
}

.project-item .categories a:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(255, 87, 34, 0.3);
}

.project-item .title {
  font-size: 20px;
  font-weight: 700;
  margin-bottom: 0;
  line-height: 1.4;
}

.project-item .title a {
  color: #1a1a1a;
  transition: color 0.3s ease;
}

.project-item:hover .title a {
  color: #ff5722;
}

/* Results Count */
.results-header {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-radius: 12px;
  padding: 20px 25px;
  margin-bottom: 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.results-header h5 {
  margin: 0;
  color: #2c3e50;
  font-weight: 700;
  font-size: 16px;
}

.results-header h5 span {
  color: #ff5722;
  font-weight: 800;
}

/* Empty State */
.empty-state {
  text-align: center;
  padding: 80px 40px;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-radius: 15px;
}

.empty-state i {
  font-size: 64px;
  color: #ff5722;
  margin-bottom: 20px;
  opacity: 0.8;
}

.empty-state h4 {
  font-size: 24px;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 15px;
}

.empty-state p {
  font-size: 16px;
  color: #666;
  margin: 0;
}

/* Pagination Styles */
.tj-pagination ul {
  display: flex;
  align-items: center;
  gap: 10px;
  list-style: none;
  padding: 0;
  margin: 0;
}

.tj-pagination ul li {
  margin: 0;
}

.tj-pagination ul li a,
.tj-pagination ul li span {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 45px;
  height: 45px;
  padding: 0 15px;
  background: #fff;
  color: #2c3e50;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
}

.tj-pagination ul li a:hover {
  background: #ff5722;
  color: white;
  border-color: #ff5722;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(255, 87, 34, 0.3);
}

.tj-pagination ul li span.current {
  background: #ff5722;
  color: white;
  border-color: #ff5722;
  box-shadow: 0 4px 12px rgba(255, 87, 34, 0.3);
}

.tj-pagination ul li.disabled span {
  background: #f5f5f5;
  color: #ccc;
  border-color: #e0e0e0;
  cursor: not-allowed;
}

.tj-pagination ul li a i {
  font-size: 14px;
}

/* Mobile Filter Toggle */
.mobile-filter-toggle {
  display: none;
  width: 100%;
  padding: 15px 20px;
  background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%);
  color: white;
  border: none;
  border-radius: 10px;
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 20px;
  cursor: pointer;
  box-shadow: 0 4px 15px rgba(255, 87, 34, 0.3);
  transition: all 0.3s ease;
}

.mobile-filter-toggle:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 87, 34, 0.4);
}

.mobile-filter-toggle i {
  margin-right: 10px;
  transition: transform 0.3s ease;
}

.mobile-filter-toggle.active i {
  transform: rotate(180deg);
}

/* Responsive Styles */
@media (max-width: 991px) {
  .mobile-filter-toggle {
    display: block;
  }
  
  .filter-sidebar {
    max-height: 0;
    overflow: hidden;
    padding: 0 25px;
    transition: all 0.4s ease;
  }
  
  .filter-sidebar.show {
    max-height: 2000px;
    padding: 35px 25px;
    margin-bottom: 30px;
  }
  
  .projects-listing {
    margin-top: 0;
  }
}

@media (max-width: 767px) {
  .filter-title {
    font-size: 12px;
  }
  
  .filter-title i {
    width: 24px;
    height: 24px;
    font-size: 12px;
  }
  
  .sidebar-header h3 {
    font-size: 20px;
  }
}
</style>
@endsection

@section('content')

<!-- start: Breadcrumb Section -->
<section class="tj-page-header section-gap-x" data-bg-image="{{ $pageBanner && $pageBanner->cover ? asset($pageBanner->cover) : asset('assets/images/bg/pheader-bg.webp') }}">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="tj-page-header-content text-center">
          <h1 class="tj-page-title">{{ __('lang.projects_page_title') }}</h1>
          <div class="tj-page-link">
            <span><i class="tji-home"></i></span>
            <span>
              <a href="{{ url('/') }}">{{ __('lang.home') }}</a>
            </span>
            <span><i class="tji-arrow-right"></i></span>
            <span>
              {{ __('lang.projects') }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-header-overlay" data-bg-image="{{ asset('pic/shape/pheader-overlay.webp') }}"></div>
</section>
<!-- end: Breadcrumb Section -->

<!-- start: Project Section -->
<section class="tj-project-section section-gap">
  <div class="container">
    
    <!-- Mobile Filter Toggle Button -->
    <button type="button" class="mobile-filter-toggle" id="mobileFilterToggle">
      <i class="fa fa-filter"></i>
      {{ __('lang.show_filters') }}
    </button>
    
    <div class="row">
      
      <!-- Sidebar Filter -->
      <div class="col-lg-3">
        <div class="filter-sidebar" id="filterSidebar">
          <div class="sidebar-header">
            <h4>
              <i class="fa fa-filter"></i>
              @if(App::getLocale() == 'en')
                Filter Projects
              @else
                تصفية المشاريع
              @endif
            </h4>
          </div>
          
          <form action="{{ route('projects.index') }}" method="GET" id="filterForm">
            
            <!-- Category Filter -->
            <div class="filter-section">
              <div class="filter-title">
                <i class="fa fa-folder"></i>
                <span>
                  @if(App::getLocale() == 'en')
                    Category
                  @else
                    الفئة
                  @endif
                </span>
              </div>
              <select name="category_id" class="form-select" onchange="this.form.submit()">
                <option value="">
                  @if(App::getLocale() == 'en')
                    All Categories
                  @else
                    جميع الفئات
                  @endif
                </option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    @if(App::getLocale() == 'en')
                      {{ $category->title_english }}
                    @else
                      {{ $category->title_arabic }}
                    @endif
                  </option>
                @endforeach
              </select>
            </div>
            
            <!-- Sub Category Filter -->
            <div class="filter-section">
              <div class="filter-title">
                <i class="fa fa-folder-open"></i>
                <span>
                  @if(App::getLocale() == 'en')
                    Sub Category
                  @else
                    الفئة الفرعية
                  @endif
                </span>
              </div>
              <select name="subcategory_id" class="form-select" onchange="this.form.submit()">
                <option value="">
                  @if(App::getLocale() == 'en')
                    All Sub Categories
                  @else
                    جميع الفئات الفرعية
                  @endif
                </option>
                @foreach($subcategories as $subcategory)
                  <option value="{{ $subcategory->id }}" {{ request('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                    @if(App::getLocale() == 'en')
                      {{ $subcategory->title_english }}
                    @else
                      {{ $subcategory->title_arabic }}
                    @endif
                  </option>
                @endforeach
              </select>
            </div>
            
            <!-- Project Style Filter -->
            <div class="filter-section">
              <div class="filter-title">
                <i class="fa fa-paint-brush"></i>
                <span>
                  @if(App::getLocale() == 'en')
                    Project Style
                  @else
                    نمط المشروع
                  @endif
                </span>
              </div>
              <select name="style_id" class="form-select" onchange="this.form.submit()">
                <option value="">
                  @if(App::getLocale() == 'en')
                    All Styles
                  @else
                    جميع الأنماط
                  @endif
                </option>
                @foreach($styles as $style)
                  <option value="{{ $style->id }}" {{ request('style_id') == $style->id ? 'selected' : '' }}>
                    @if(App::getLocale() == 'en')
                      {{ $style->title_english }}
                    @else
                      {{ $style->title_arabic }}
                    @endif
                  </option>
                @endforeach
              </select>
            </div>
            
            <!-- SQFT Range -->
            <div class="filter-section">
              <div class="filter-title">
                <i class="fa fa-arrows-alt"></i>
                <span>
                  @if(App::getLocale() == 'en')
                    Area (SQFT)
                  @else
                    المساحة (قدم مربع)
                  @endif
                </span>
              </div>
              <div class="range-inputs">
                <input type="number" name="sqft_from" class="form-control" placeholder="From" value="{{ request('sqft_from') }}">
                <span>-</span>
                <input type="number" name="sqft_to" class="form-control" placeholder="To" value="{{ request('sqft_to') }}">
              </div>
            </div>
            
            <!-- SQM Range -->
            <div class="filter-section">
              <div class="filter-title">
                <i class="fa fa-expand"></i>
                <span>
                  @if(App::getLocale() == 'en')
                    Area (SQM)
                  @else
                    المساحة (متر مربع)
                  @endif
                </span>
              </div>
              <div class="range-inputs">
                <input type="number" name="sqm_from" class="form-control" placeholder="From" value="{{ request('sqm_from') }}">
                <span>-</span>
                <input type="number" name="sqm_to" class="form-control" placeholder="To" value="{{ request('sqm_to') }}">
              </div>
            </div>
            
            <!-- Keyword Search -->
            <div class="filter-section">
              <div class="filter-title">
                <i class="fa fa-search"></i>
                <span>
                  @if(App::getLocale() == 'en')
                    Keyword Search
                  @else
                    البحث بالكلمات
                  @endif
                </span>
              </div>
              <input type="text" name="keyword" class="form-control" placeholder="Search by title or tags..." value="{{ request('keyword') }}">
            </div>
            
            <!-- Specifications Filter -->
            <div class="filter-section">
              <div class="filter-title">
                <i class="fa fa-list-alt"></i>
                <span>
                  @if(App::getLocale() == 'en')
                    Specifications
                  @else
                    المواصفات
                  @endif
                </span>
              </div>
              <select name="specification_id" id="specificationSelect" class="form-select" onchange="showSpecValue(this)">
                <option value="">
                  @if(App::getLocale() == 'en')
                    Select Specification
                  @else
                    اختر المواصفة
                  @endif
                </option>
                @foreach($specifications as $specification)
                  <option value="{{ $specification->id }}" {{ request('specification_id') == $specification->id ? 'selected' : '' }}>
                    @if(App::getLocale() == 'en')
                      {{ $specification->title_english }}
                    @else
                      {{ $specification->title_arabic }}
                    @endif
                  </option>
                @endforeach
              </select>
              <div id="specValueContainer" class="spec-value-input {{ request('specification_id') ? 'active' : '' }}" style="{{ request('specification_id') ? 'display: block;' : 'display: none;' }}">
                <input type="text" name="specification_value" id="specificationValue" class="form-control" 
                  placeholder="@if(App::getLocale() == 'en')Enter value...@else أدخل القيمة...@endif" 
                  value="{{ request('specification_value') }}">
              </div>
            </div>
            
            <!-- Filter Buttons -->
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-filter"></i>
              @if(App::getLocale() == 'en')
                Apply Filters
              @else
                تطبيق التصفية
              @endif
            </button>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">
              <i class="fa fa-times"></i>
              @if(App::getLocale() == 'en')
                Clear All
              @else
                مسح الكل
              @endif
            </a>
          </form>
        </div>
      </div>
      
      <!-- Projects Listing -->
      <div class="col-lg-9">
        
        <!-- Results Count -->
        <div class="results-header">
          <h5>
            @if(App::getLocale() == 'en')
              Showing <span>{{ $projects->count() }}</span> of <span>{{ $projects->total() }}</span> projects
            @else
              عرض <span>{{ $projects->count() }}</span> من <span>{{ $projects->total() }}</span> مشروع
            @endif
          </h5>
        </div>
        
        <!-- Projects Grid -->
        <div class="row row-gap-4">
          @forelse($projects as $index => $project)
          <div class="col-md-6">
            <div class="project-item wow fadeInUp" data-wow-delay=".{{ ($index % 3 + 1) * 2 }}s">
              <div class="project-img">
                @if($project->main_image)
                  <img src="{{ asset('storage' . $project->main_image) }}" alt="{{ App::getLocale() == 'en' ? $project->title_english : $project->title_arabic }}">
                @else
                  <img src="{{ asset('assets/images/project/default.webp') }}" alt="Project">
                @endif
              </div>
              <div class="project-content">
                @if($project->category)
                <span class="categories">
                  <a href="{{ route('projects.index', ['category_id' => $project->category->id]) }}">
                    @if(App::getLocale() == 'en')
                      {{ $project->category->title_english }}
                    @else
                      {{ $project->category->title_arabic }}
                    @endif
                  </a>
                </span>
                @endif
                <div class="project-text">
                  <h4 class="title">
                    <a href="{{ route('projects.show', ['slug' => $project->slug]) }}">
                      @if(App::getLocale() == 'en')
                        {{ $project->title_english }}
                      @else
                        {{ $project->title_arabic }}
                      @endif
                    </a>
                  </h4>
                  <a class="project-btn" href="{{ route('projects.show', ['slug' => $project->slug]) }}">
                    <i class="tji-arrow-right-big"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          @empty
          <div class="col-12">
            <div class="empty-state">
              <i class="fa fa-folder-open"></i>
              <h4>
                @if(App::getLocale() == 'en')
                  No Projects Found
                @else
                  لا توجد مشاريع
                @endif
              </h4>
              <p>
                @if(App::getLocale() == 'en')
                  Try adjusting your filters to find what you're looking for.
                @else
                  حاول تعديل التصفية للعثور على ما تبحث عنه.
                @endif
              </p>
            </div>
          </div>
          @endforelse
        </div>
        
        <!-- Pagination -->
        @if($projects->hasPages())
        <div class="tj-pagination d-flex justify-content-center mt-5">
          <ul>
            {{-- Previous Page Link --}}
            @if ($projects->onFirstPage())
              <li class="disabled"><span><i class="tji-arrow-left"></i></span></li>
            @else
              <li><a href="{{ $projects->appends(request()->query())->previousPageUrl() }}"><i class="tji-arrow-left"></i></a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($projects->appends(request()->query())->getUrlRange(1, $projects->lastPage()) as $page => $url)
              @if ($page == $projects->currentPage())
                <li><span aria-current="page" class="page-numbers current">{{ $page }}</span></li>
              @else
                <li><a class="page-numbers" href="{{ $url }}">{{ $page }}</a></li>
              @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($projects->hasMorePages())
              <li><a class="next page-numbers" href="{{ $projects->appends(request()->query())->nextPageUrl() }}"><i class="tji-arrow-right"></i></a></li>
            @else
              <li class="disabled"><span><i class="tji-arrow-right"></i></span></li>
            @endif
          </ul>
        </div>
        @endif
        
      </div>
      
    </div>
  </div>
</section>
<!-- end: Project Section -->

@endsection

@section('js')
<script>
  // Simple inline function to show/hide specification value input
  function showSpecValue(select) {
    const container = document.getElementById('specValueContainer');
    const input = document.getElementById('specificationValue');
    
    if (select.value) {
      container.style.display = 'block';
      container.classList.add('active');
      setTimeout(function() {
        input.focus();
      }, 100);
    } else {
      container.style.display = 'none';
      container.classList.remove('active');
      input.value = '';
    }
  }
  
  document.addEventListener('DOMContentLoaded', function() {
    const valueInput = document.getElementById('specificationValue');
    
    if (valueInput) {
      // Submit form on Enter key in specification value input
      valueInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          this.closest('form').submit();
        }
      });
    }
    
    // Mobile filter toggle
    const mobileToggle = document.getElementById('mobileFilterToggle');
    const filterSidebar = document.getElementById('filterSidebar');
    
    if (mobileToggle && filterSidebar) {
      mobileToggle.addEventListener('click', function() {
        this.classList.toggle('active');
        filterSidebar.classList.toggle('show');
        
        // Update button text
        const isShowing = filterSidebar.classList.contains('show');
        @if(App::getLocale() == 'en')
          this.innerHTML = '<i class="fa fa-filter"></i> ' + (isShowing ? 'Hide Filters' : 'Show Filters');
        @else
          this.innerHTML = '<i class="fa fa-filter"></i> ' + (isShowing ? 'إخفاء الفلاتر' : 'إظهار الفلاتر');
        @endif
      });
    }
  });
</script>
@endsection
