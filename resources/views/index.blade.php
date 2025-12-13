@extends('layouts.master')
@section('title' , 'SVG')
@section('content')

	<main>
		@include('home.slider')
		@include('home.about')
		@include('home.services')
		
		{{-- Smart Fallback: Show showcases, if empty show process instead --}}
		@if(isset($showcases) && $showcases->count() > 0)
			@include('home.showcases')
		@elseif(isset($defaultProcess) && isset($processCards) && $processCards->count() > 0)
			@include('home.defaults.process')
		@endif
		
		@include('home.chooseus')
		
	{{-- Smart Fallback: Show projects, if empty show facts instead --}}
	@if(isset($engineeringProjects) && $engineeringProjects->count() > 0)
		@include('home.engineeringproject')
	@elseif(isset($facts) && $facts->count() > 0)
		@include('home.defaults.facts')
	@endif
	
	{{-- Smart Fallback: Show team and portfolio, if both empty show default banner instead --}}
	@if((isset($teamMembers) && $teamMembers->count() > 0) || (isset($portfolios) && $portfolios->count() > 0))
		@if(isset($teamMembers) && $teamMembers->count() > 0)
			@include('home.team')
		@endif
		@if(isset($portfolios) && $portfolios->count() > 0)
			@include('home.portfolio')
		@endif
	@elseif(isset($defaultBanner))
		@include('home.defaults.banner')
	@endif
	
	@include('home.contact')
	@include('home.blogs')
		
		

		
	</main>
@endsection
@section('js')
<script>
jQuery(document).ready(function($) {
    // Portfolio filter - use direct event delegation
    $("#portfolio-filter-buttons").on("click", "button", function (e) {
        e.preventDefault();
        e.stopPropagation();
        
        var $this = $(this);
        var filterValue = $this.attr("data-filter");
        
        console.log('Filter clicked:', filterValue);
        
        // Update active class
        $("#portfolio-filter-buttons button").removeClass("active");
        $this.addClass("active");
        
        // Apply filter
        var $grid = $("#portfolio-grid");
        if ($grid.data('isotope')) {
            $grid.isotope({ filter: filterValue });
        } else {
            // Initialize if not already done
            $grid.imagesLoaded(function () {
                $grid.isotope({
                    itemSelector: '.portfolio-filter-item',
                    layoutMode: 'masonry',
                    masonry: {
                        columnWidth: '.portfolio-sizer',
                        gutter: '.gutter-sizer'
                    },
                    percentPosition: true,
                    filter: filterValue
                });
            });
        }
    });
});
</script>
@endsection
