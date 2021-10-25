@extends('theme::front-end.master')
@section('title')
    <title>{{ $news->title }}</title>
    <meta name="description"
          content="{{ !empty($news->description) ? \Illuminate\Support\Str::limit($news->description, 200) : $settings['meta_description'] }}"/>
    <meta name="keywords" content="{{ !empty($news->title) ? $news->title : $settings['meta_keyword'] }}"/>
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
   <div class="container mt-4">
       <div class="row">
           <div class="col-12 col-lg-9">
               <h5 class="news__title--lg text-uppercase">{{ $news->title }}</h5>
               <div class="news__detail--title">
                   <a class="item-link" href="{{ url(optional($news->category)->slug) }}">{{ optional($news->category)->title }}</a>
                   <span>
                        &nbsp;<i class="far fa-calendar-alt" aria-hidden="true"></i>&nbsp;{{ Carbon\Carbon::parse($news->updated_at)->format(config('settings.format.date')) }}
                    </span>
                   <span>&nbsp;<i class="fa fa-eye"></i>&nbsp;{{ $news->view ._(" lượt xem") }}</span>
               </div>
               <div>
                   @if(!empty($news->description))
                       <p class="article-summary">
                           <i>{!! $news->description !!}</i>
                       </p>
                   @endif
                   <div class="article-content">
                       {!! $news->content !!}
                   </div>
               </div>
           </div>
           @include('theme::front-end.news.sidebar')
       </div>
       <hr>
       @if($otherNews->count() > 0)
           @include('theme::front-end.news.other')
       @endif
   </div>
@endsection