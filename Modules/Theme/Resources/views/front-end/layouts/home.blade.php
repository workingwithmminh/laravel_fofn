@extends('theme::front-end.master')
@section('content')
    <section class="news__hot container mt-2">
        <div class="row">
            @forelse($newsHot as $item)
                <div class="col-sm-6 col-md-4">
                    <div class="image-responsive">
                        <img class="img-fluid image-responsive--lg lazyload"
                             data-src="{{ asset($item->image) }}"
                             alt="{{ $item->title }}">
                    </div>
                    <div class="news__content">
                        <a class="news__title--lg" href="{{ url($item->category->slug . '/' .$item->slug) }}.html" class="news__content__title">{{ \Illuminate\Support\Str::limit($item->title, 70)}}</a>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <small>{{ trans('frontend.data_updated') }}</small>
                </div>
            @endforelse
        </div>
    </section>

    <section class="news__market container py-4">
        @foreach($categories as $key => $item)
            <div class="row">
                <div class="col-md-9">
                    <div class="news__title">
                        <a href="{{ url($item->slug) }}" class="news__title--active">{{ $item->title }}</a>
                        @php($categories_sub = \App\Category::with('parent')->where('parent_id', $item->id)->get())
                        @foreach($categories_sub as $itemSub)
                            <a href="{{ url($item->slug."/".$itemSub->slug) }}">{{ $itemSub->title }}</a>
                        @endforeach
                    </div>
                    @php($categoryIds = \App\Category::with('parent')->where('parent_id', $item->id)->pluck('id')->toArray())
                    @php($news = \App\News::with('category')->whereIn('category_id', $categoryIds)->orWhere('category_id', $item->id)->latest()->get())
                    @php($news_small = $news->take(-1))
                    <div class="row news__market--wrap">
                        @if($news->count() >0)
                            <div class="col-md-6">
                                @if($news != null)
                                    <div class="image-responsive">
                                        <img class="img-fluid image-responsive--lg lazyload"
                                             data-src="{{ asset($news[0]->image) }}"
                                             alt="{{ $news[0]->title }}">
                                    </div>
                                    <a href="{{ url($news[0]->category->slug . '/' .$news[0]->slug) }}.html"
                                       class="news__title--lg">{{ $news[0]->title }}</a>
                                   <div>
                                        <span class="news__date">
                                            <a class="item-link"
                                               href="{{ url(optional($news[0]->category)->slug) }}">{{ optional($news[0]->category)->title }}</a>
                                            <span>-&nbsp;&nbsp;</span>
                                            <span>{{ _("Cập nhật ").Carbon\Carbon::parse($news[0]->updated_at)->format(config('settings.format.date')) }}</span>
                                    </span>
                                   </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @foreach($news_small as $item)
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="image-responsive">
                                                <img class="img-fluid image-responsive--lg lazyload"
                                                     data-src="{{ asset($item->image) }}"
                                                     alt="{{ $item->title }}">
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <a href="{{ url($item->category->slug . '/' .$item->slug) }}.html"
                                               class="news__title--small news__title--small--viewer">{{ $item->title }}</a>
                                            <span class="news__date">
                                                <span> {{ _("Cập nhật ").Carbon\Carbon::parse($item->updated_at)->format(config('settings.format.date')) }}</span>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="col-md-12 text-center">
                                <small>{{ trans('frontend.data_updated') }}</small>
                            </div>
                        @endif
                    </div>
                </div>
                @if($key == 0)
                    <div class="col-md-3">
                        <div class="news__viewer">
                            <h2 class="news__viewer__title">Xem nhiều nhất</h2>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="product-thumb image-responsive">
                                        <img src="http://asiagroup.huesoft.net/storage/images/categories/news-demo.jpg"
                                             data-src="http://asiagroup.huesoft.net/storage/images/categories/news-demo.jpg"
                                             alt="/storage/images/89656309_109544857340126_5427112630751854592_o.jpg"
                                             class="image-responsive--lg lazyloaded"
                                             src="/storage/images/89656309_109544857340126_5427112630751854592_o.jpg">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <a href="#" class="news__title--small news__title--small--viewer">PHỤ HUYNH CÓ
                                        THỂ
                                        GỬI
                                        YÊU CẦU HỖ
                                        TRỢ ‘’ĐỒ DÙNG HỌC TẬP’’ CHO CON ...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        @endforeach
    </section>
@endsection

