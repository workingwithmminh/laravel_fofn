@extends('theme::front-end.master')
@section('title')
<title>{{ $news->title }}</title>
<meta name="description" content="{{ !empty($news->description) ? \Illuminate\Support\Str::limit($news->description, 200) : $settings['meta_description'] }}" />
<meta name="keywords" content="{{ !empty($news->keywords) ? $news->keywords : $settings['meta_keyword'] }}" />
@endsection

@section('schema')
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "item": {
                    "@id": "{{ url('/')}}",
                    "name": "{{ trans('theme::frontend.home.home') }}"
                }
            },
            {
                "@type": "ListItem",
                "position": 2,
                "item": {
                    "@id": "{{ url(optional($category->parent)->slug . '/' . $category->slug) }}",
                    "name": "{{ $category->title }}"
                }
            },
            {
                "@type": "ListItem",
                "position": 3,
                "item": {
                    "@id": "{{ Request::fullUrl() }}",
                    "name": "{{ $news->title }}"
                }
            }
        ]
    }
</script>
@endsection

@section('content')
<div class="row">
    <div class="article article-detail">
        <div class="col-12">
            <div class="breadcrumb breadcrumb-fixed justify-content-center">
                <a href="{{ url('/')}}">{{ trans('theme::frontend.home') }}</a>
                <span class="mr_lr">&nbsp;<i class="fa fa-angle-right"></i>&nbsp;</span>
                <a href="{{ url($category->slug)}}">{{ $category->title }}</a>
                <span class="mr_lr">&nbsp;<i class="fa fa-angle-right"></i>&nbsp;</span>
                {{ $news->title }}
            </div>
            <div class="pl-30">
                <p class="fb-like" data-href="{{ Request::fullUrl() }}" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true"></p>
                <p class="article-postdate">
                    <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($news->updated_at)->format(config('settings.format.date')) }}
                </p>
                @if(!empty($news->description))
                <p class="article-summary">
                    <i>{!! $news->description !!}</i>
                </p>
                @endif
                <div class="article-content">
                    {!! $news->content !!}
                    <div class="fb-comments" data-href="{{ Request::fullUrl() }}" data-width="100%" data-numposts="5"></div>
                </div>
            </div>
        </div>
        @include('theme::front-end.news.sidebar')
    </div>
    <div class="container">
        @if($otherNews->count() > 0)
        @include('theme::front-end.news.other')
        @endif
    </div>
</div>
@endsection