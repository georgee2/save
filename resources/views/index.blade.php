@extends('layouts.master')
@section('title' , 'SVG')
@section('content')

	@include('home.slider')
	@include('home.subcategory')
	@include('home.partials.section-divider')
	@include('home.featuredprojects')
	@include('home.partials.section-divider')
	@include('home.offers')
	@include('home.partials.section-divider')
	@include('home.about')
	@include('home.partials.section-divider')
	@include('home.services')
	@include('home.partials.section-divider')
	@include('home.whychooseus')
@endsection

