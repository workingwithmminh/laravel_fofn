@extends('theme::front-end.master')
@section('title')
    <title>{{ $category->title . ' | ' . $settings['meta_title'] }}</title>
    <meta name="description"
          content="{{ !empty($category->description) ? $category->description : trans('frontend.description') }}"/>
    <meta name="keywords"
          content="{{ !empty($category->keywords) ? $category->keywords : $settings['meta_keyword'] }}"/>
@endsection
@section('schema')
    <script type="application/ld+json">
        {
         "@context": "http://schema.org",
         "@type": "BreadcrumbList",
         "itemListElement":
         [
          {
           "@type": "ListItem",
           "position": 1,
           "item":
           {
            "@id": "{{ url('/')}}",
            "name": "{{ trans('theme::frontend.home.home') }}"
            }
          },
          {
           "@type": "ListItem",
          "position": 2,
          "item":
           {
             "@id": "{{ Request::fullUrl() }}",
             "name": "{{ $category->title }}"
           }
          }
         ]
        }

    </script>
@endsection
@section('breadcrumb')
    <div class="bread__crumb clearfix container">
        <h5 class="news__title--lg text-uppercase">{{ $category->title }}</h5>
        <a href="{{ url('/')}}"><i class="fa fa-home"></i></a> / <strong>{{ $category->title }}</strong>
    </div>
@endsection
@section('content')
    <div class="article article-list container">
        <div class="row">
            @if($news->count() > 0)
                <div class="col-12 col-lg-9">
                    <div class="row news-items">
                        @foreach($news as $item)
                            <div class="col-12 col-sm-6 col-md-4 item mb-15">
                                <a href="{{ url(optional($item->category)->slug . '/' .$item->slug) }}.html"
                                   class="image-responsive image-responsive--md">
                                    <img class="image-responsive--lg lazyload" data-src="{{ asset($item->image) }}"
                                         class="card-img-top" alt="{{ $item->title }}">
                                </a>
                                <div class="item-body">
                                    <h3 class="item-title">
                                        <a class="item-link"
                                           href="{{ url(optional($item->category)->slug . '/' .$item->slug) }}.html">{{ $item->title }}</a>
                                    </h3>
                                    <span class="item-postdate">
                                        <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($item->updated_at)->format(config('settings.format.date')) }}
                                    </span>
                                    @empty(!$item->description)
                                        <p class="item-text">{{ \Illuminate\Support\Str::limit($item->description, 70) }}</p>
                                    @endempty
                                </div>

                            </div>
                        @endforeach
                    </div>
                    <div class="pagination-fixed d-flex justify-content-center">
                        {!! $news->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>
                @include('theme::front-end.news.sidebar')
            @else
                <div class="col-12 col-lg-12 text-center">
                    {{ trans('frontend.data_updated') }}
                </div>
            @endif

        </div>
    </div>
@endsection