@extends('web.layouts.master')

@section('content')
{{-- home page Slider --}}
@include('web.partials.home_page_slider)
@include('web.partials.home_welcome_section)
@include('web.partials.counter_section)
@include('web.partials.home_team_section)
@include('web.partials.home_portfolio_section)
@include('web.partials.home_gallery_section)
@include('web.partials.home_recent_activity_section)
@include('web.partials.home_upcoming_events_section)
@endsection
