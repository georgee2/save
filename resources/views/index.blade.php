@extends('layouts.master')
@section('title' , 'SVG')
@section('content')

{{-- Dynamic Home Sections --}}
@if(isset($homeSections) && count($homeSections) > 0)
	@foreach($homeSections as $section)
		@include($section->blade_view)
		@if($section->show_divider == 0)
			@include('home.partials.section-divider')
		@endif
	@endforeach
@else
	{{-- Fallback to static sections if no dynamic sections configured --}}
	@include('home.slider')
	@include('home.subcategory')
	@include('home.partials.section-divider')
	@include('home.featuredprojects')
	@include('home.partials.section-divider')
	@include('home.offers')
	@include('home.partials.section-divider')
	@include('home.about')
	@include('home.partials.section-divider')
	@include('home.interior-gallery')
	@include('home.partials.section-divider')
	@include('home.services')
	@include('home.partials.section-divider')
	@include('home.whychooseus')
	@include('home.partials.section-divider')
	@include('home.projects')
	@include('home.partials.section-divider')
	@include('home.team')
	@include('home.partials.section-divider')
	@include('home.contactfaq')
	@include('home.partials.section-divider')
	@include('home.news')
	@include('home.government-partners')
@endif
@endsection

