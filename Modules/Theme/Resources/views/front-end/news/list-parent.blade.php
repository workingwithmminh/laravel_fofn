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
    @if($categories->count() == 0)
        <div class="article article-list container">
            <div class="row">
                @php($news = \App\News::with('category')->where([['category_id', $category->id], ['active', config('settings.active')]])->orderBy('updated_at', 'DESC')->paginate(config('settings.paginate.page12')))
                @if($news->count() > 0)
                    <div class="col-12 col-lg-9">
                        <div class="row news-items">
                            @foreach($news as $item)
                                <div class="col-12 col-md-6 mb-15">
                                    <a href="{{ url(optional($item->category)->slug . '/' .$item->slug) }}.html"
                                       class="image-responsive">
                                        <img class="image-responsive--lg img-fluid lazyload"
                                             data-src="{{ asset($item->image) }}"
                                             alt="{{ $item->title }}">
                                    </a>
                                    <div class="item-body">
                                        <h5 class="news__title--lg">
                                            <a href="{{ url($item->slug) }}.html"
                                               class="news__title--lg">{{ $item->title }}</a>
                                        </h5>
                                        <span class="news__date">
                                            <a class="item-link"
                                               href="{{ url(optional($item->category)->slug . '/' .$item->slug) }}.html">{{ optional($item->category)->title }}</a>
                                            <span>-&nbsp;&nbsp;</span>
                                            <span>{{ Carbon\Carbon::parse($item->updated_at)->format(config('settings.format.date')) }}</span>
                                        </span>
                                        @empty(!$item->description)
                                            <p class="news__description">{{ \Illuminate\Support\Str::limit($item->description, 70) }}</p>
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
                        <small>{{ trans('frontend.data_updated') }}</small>
                    </div>
                @endif
            </div>
        </div>
    @else
        @foreach($categories as $item)
            <div class="article article-list container">
                <div class="news__title">
                    <a href="{{ url($item->slug) }}" class="news__title--active">{{ $item->title }}</a>
                </div>
                <div class="row">
                    @php($news = \App\News::with('category')->where([['category_id', $item->id], ['active', config('settings.active')]])->orderBy('updated_at', 'DESC')->paginate(config('settings.paginate.page12')))
                    @if($news->count() > 0)
                        <div class="col-12 col-lg-9">
                            <div class="row news-items">
                                @foreach($news as $itemX)
                                    <div class="col-12 col-md-6 mb-15">
                                        <a href="{{ url(optional($itemX->category)->slug . '/' .$itemX->slug) }}.html"
                                           class="image-responsive">
                                            <img class="image-responsive--lg img-fluid lazyload"
                                                 data-src="{{ asset($itemX->image) }}"
                                                 alt="{{ $itemX->title }}">
                                        </a>
                                        <div class="item-body">
                                            <h5 class="news__title--lg">
                                                <a href="{{ url($itemX->slug) }}.html"
                                                   class="news__title--lg">{{ $itemX->title }}</a>
                                            </h5>
                                            <span class="news__date">
                                        <a class="item-link"
                                           href="{{ url(optional($item->category)->slug . '/' .$item->slug) }}.html">{{ $item->title }}</a>
                                        <span>-&nbsp;&nbsp;</span>
                                        <span>{{ Carbon\Carbon::parse($item->updated_at)->format(config('settings.format.date')) }}</span>
                                    </span>
                                            @empty(!$itemX->description)
                                                <p class="news__description">{{ \Illuminate\Support\Str::limit($itemX->description, 70) }}</p>
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
                            <small>{{ trans('frontend.data_updated') }}</small>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

    @endif
@endsection