<div class="col-12 col-lg-3">
    <div class="news__viewer">
        <h2 class="news__viewer__title">Xem nhiều nhất</h2>
        @forelse($news_viewer as $item)
            <div class="row mb-2">
                <div class="col-12 col-md-5">
                    <a href="{{ url(optional($item->category)->slug . '/' .$item->slug) }}.html"
                       class="image-responsive">
                        <img class="image-responsive--lg img-fluid lazyload"
                             data-src="{{ asset($item->image) }}"
                             alt="{{ $item->title }}">
                    </a>
                </div>
                <div class="col-12 col-md-7">
                    <a class="news__title--small news__title--small--viewer" href="{{ url(optional($item->category)->slug . '/' .$item->slug) }}.html">
                        {{ \Illuminate\Support\Str::limit($item->title, 30) }}
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center">
                <small>{{ trans('frontend.data_updated') }}</small>
            </div>
        @endforelse
    </div>
</div>