
@php
$template = $pageDetail->template;

@endphp

@switch($template)
    @case('home')
        @include('web.home.index')
        @break
    @case('contact')
        @include('web.contact.index')
        @break
    @case('gallery')
        @include('web.gallery.index')
        @break
    @case('recent_activity')
        @include('web.activity.index')
        @break
    @case('upcoming_events')
        @include('web.events.index')
        @break
    @case('notice_board')
        @include('web.notice_board.index')
        @break
    @case('tc_view_form')
        @include('web.tc.index')
        @break
    @case('alumani')
        @include('web.alumani.index')
        @break
    @case('admission')
        @include('web.admission.index')
        @break
    @case('faculty')
        @include('web.faculty.index')
        @break
    @case('shop')
        @include('web.shop.index')
        @break
    @case('detail')
        @include('web.pages.index')
        @break
    @case('blog')
        @include('web.blog.index')
        @break
    @case('blog_detail')
        @include('web.blog.details')
        @break
    @case('service')
        @include('web.services.index')
        @break

    @default
       @include('web.pages.index')
        @break
@endswitch


