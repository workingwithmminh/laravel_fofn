<div class="col-12 col-lg-3 sidebar">
    <div class="row">
        <div class="col-12 col-sm-6 col-lg-12">
            <h5 class="sidebar-title text-uppercase">
                <i class="fas fa-bars"></i>{{ trans('theme::frontend.news_focus') }}
            </h5>
            @foreach($newsFocusSidebar as $item)
                <div class="row box-row mb-15 d-flex align-items-center">
                    <div class="col-5 col-sm-4 col-md-3 col-lg-5">
                        <a href="{{ url(optional($item->category)->slug . '/' .$item->slug) }}.html" class="image-responsive">
                            <img class="image-responsive--lg lazyload" data-src="{{ asset($item->image) }}" alt="{{ $item->title }}">
                        </a>
                    </div>
                    <div class="col-7 col-sm-8 col-md-9 col-lg-7 pl-0">
                        <a class="box-info--link" href="{{ url(optional($item->category)->slug . '/' .$item->slug) }}.html"
                           title="{{ $item->title }}">
                            {{ \Illuminate\Support\Str::limit($item->title, 50) }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>