<div class="header__top container py-1">
    <div class="row">
        <div class="header__top__left col-sm-12 col-md-6">
            <span>Email: <a href="#" class="text-danger"><small>kienthuckinhte@ekcorp.vn</small></a></span>
        </div>
        <div class="header__top__right col-sm-12 col-md-6 d-flex align-items-center justify-content-end">
            <div class="header__top__right__search">
                <form method="GET" action="{{ route('tim-kiem') }}" class="search-form">
                    <input type="text" name="query" placeholder="Tìm kiếm...">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <ul class="list-inline-block">
                <a target="_blank" rel="nofollow" href=""><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                <a target="_blank" rel="nofollow" href=""><i class="fab fa-twitter" aria-hidden="true"></i></a>
                <a target="_blank" rel="nofollow" href=""><i class="fab fa-instagram" aria-hidden="true"></i></a>
                <a target="_blank" rel="nofollow" href="https://www.youtube.com/user/nobitapt">
                    <i class="fab fa-youtube" aria-hidden="true"></i>
                </a>
            </ul>
        </div>
    </div>
</div>
<div class="header__logo py-2">
    <div class="container">
        <div class="row">
            <div class="header__logo col-sm-12 col-md-4">
                <img src="https://kienthuckinhte.vn/styles/website/images/logo.png?v=1" alt="" class="img-fluid">
            </div>
            <div class="col-sm-12 col-md-8">
                <a class="sidebarBtn d-block d-xl-none">
                    <i class="sidebar-icon fas fa-bars"></i>
                </a>
                <div class="header__menu">
                    <ul class="list-inline-block clearfix d-none d-xl-block">
                        @foreach($mainMenus as $item)
                            @php($menuChild = \App\Menu::with('parent')->where('parent_id', $item->id)->get())
                            @if($item->parent_id == null)
                                @if($item->slug == 'trang-chu')
                                    <li class="active"><a
                                                href="{{ url($item->slug) }}{{ $item->type_id == 0 ? '' : '.html' }}"
                                                class="hidden-sm hidden-xs"><i
                                                    class="fa fa-home"></i></a></li>
                                @else
                                    <li class="{{ $menuChild->count() > 0 ? 'pn-dropdown' : '' }} ">
                                        <a href="{{ url($item->slug) }}{{ $item->type_id == 0 ? '' : '.html' }}">{{ $item->title }}</a>
                                        {!! $menuChild->count() > 0 ? '<span class="fa fa-angle-down"></span>' : ''  !!}
                                        @if($menuChild->count() > 0)
                                            <ul class="list-inline-block">
                                                @foreach($menuChild as $itemChild)
                                                    @php($menuChildren = \App\Menu::with('parent')->where('parent_id', $itemChild->id)->get())
                                                    <li>
                                                        <a href="{{ url($item->slug . '/' .$itemChild->slug) }}{{ $itemChild->type_id == 0 ? '' : '.html' }}">{{ $itemChild->title }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="sidebar">
                    <div class="flex-container" >
                        <a class="sidebarBtn">
                            <i class="sidebar-icon fas fa-times"></i>
                        </a>
                    </div>
                    <ul class="group-item">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">{{ __('theme::frontend.home.home') }}</a>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
