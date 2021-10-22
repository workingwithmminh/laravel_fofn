<?php

namespace Modules\Theme\Http\Controllers;

use App\AboutUs;
use App\CompanySetting;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Category;
use Modules\Booking\Entities\Customer;
use Modules\Booking\Entities\Booking;
use App\News;
use App\Page;
use Modules\Product\Entities\CategoryProduct;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Review;
use Modules\Promotion\Entities\Promotion;
use App\SysMenu;
use Modules\Theme\Entities\DefineKeyword;
use Modules\Theme\Entities\Partner;
use Modules\Theme\Entities\Slider;
use Illuminate\Support\Facades\Auth;
use Session;


class FrontendController extends Controller
{
    public function __construct()
    {
        $mainMenus = $this->menu(1);
        $bottomMenus = $this->menu(2);
        $settings = Setting::allConfigsKeyValue();
        $sliders = Slider::where('active', config('settings.active'))->orderBy('arrange', 'ASC')->take(5)->get();
        $newsFocusSidebar = $this->getNewsFocus(config('settings.paginate.page5'));
        $pages = Page::all();
        \View::share([
            'mainMenus' => $mainMenus,
            'bottomMenus' => $bottomMenus,
            'settings' => $settings,
            'keywords' => $this->getKeyword(),
            'sliders' => $sliders,
            'newsFocusSidebar' => $newsFocusSidebar,
            'pages' => $pages
        ]);
    }

    public function getKeyword()
    {
        $keywords = DefineKeyword::defineKeywordKeyValue();
        return $keywords;
    }
    public function menu($position = 1)
    {
        $menus = SysMenu::with('parent')->where('position', 'LIKE', "%$position%")->orderBy('arrange', 'ASC')->get();
        return $menus;
    }

    public function getNewsFocus($perPage)
    {
        $newsLast = News::with('category')->where('image', '<>', '')->latest()->first();
        return News::with('category')->where(['active' => config('settings.active'), ['id', '<>', $newsLast->id], ['image', '<>', ''], 'is_focus' => config('settings.active')])->orderBy('updated_at', 'DESC')->take($perPage)->get();
    }


    public function index()
    {   
        $newsFocus = $this->getNewsFocus(config('settings.paginate.page8'));
        $newsLast = News::with('category')->where('image', '<>', '')->latest()->first();
        $partners = Partner::where('active', config('settings.active'))->orderBy('arrange', 'DESC')->take(config('settings.paginate.page8'))->get();
        return view('theme::front-end.layouts.home', compact('newsFocus', 'partners', 'newsLast'));
    }

    public function getListParents($slugParent)
    {
        $category = Category::where('slug', $slugParent)->first();
        $slugCategoryParent = !empty($category) ? $category->slug : '';
        switch ($slugParent) {
            case $slugCategoryParent:
                $categories = Category::where('parent_id', $category->id)->pluck('id')->toArray();
                $news = News::with('category')->whereIn('category_id', $categories)->where('active', config('settings.active'))->orderBy('updated_at', 'DESC')->paginate(config('settings.paginate.page12'));
                return view('theme::front-end.news.list-parent', compact('category', 'news'));
            default:
                return view("theme::front-end.404", compact('slugParent'));
        }
    }

    public function getListChild($slugParent, $slugChild)
    {
        $category = Category::where('slug', $slugParent)->first();
        $slugCategory = [];
        if ($category) {
            $slugCategory = Category::where('parent_id', $category->id)->pluck('slug')->toArray();
        }

        if (!empty($categoryProduct)) {
            $slugCategoryProduct = CategoryProduct::where('parent_id', $categoryProduct->id)->pluck('slug')->toArray();
        } else {
            $slugCategoryProduct = CategoryProduct::where('slug', $slugChild)->pluck('slug')->toArray();
        }
        switch ($slugChild) {
            case in_array($slugChild, $slugCategory):
                $category = Category::where('slug', $slugChild)->first();
                $news = News::with('category')->where(['active' => config('settings.active'), 'category_id' => $category->id])->orderBy('updated_at', 'DESC')->paginate(config('settings.paginate.page8'));
                return view('theme::front-end.news.list-child', compact('category', 'news'));
            case in_array($slugChild, $slugCategoryProduct):
                $category = CategoryProduct::where('slug', $slugChild)->first();
                $products = Product::with('category')->where(['category_id' => $category->id, 'active' => config('settings.active')])->orderBy('updated_at', 'DESC')->paginate(config('settings.paginate.page12'));
                return view('theme::front-end.products.list-child', compact('category', 'products'));
            default:
                return view("theme::front-end.404", compact('slugChild'));
        }
    }

    public function getDetail($slugParent, $slugDetail)
    {
        $slugMenu = SysMenu::where('slug', $slugParent)->pluck('slug')->toArray();
        $slugCategory = Category::where('slug', $slugParent)->pluck('slug')->toArray();

        switch ($slugParent) {
            case in_array($slugParent, $slugMenu):
                $menu = SysMenu::where(['slug' => $slugParent])->first();
                $page = Page::where([['slug', '=', $slugDetail], ['active', '=', config('settings.active')]])->first();
                return view('theme::front-end.pages.page', compact('page','menu'));
            case in_array($slugParent, $slugCategory):
                $category = Category::where(['slug' => $slugParent, 'active' => config('settings.active')])->first();
                $news = News::with('category')->where([['category_id', '=', $category->id], 'active' => config('settings.active')])->first();
                $otherNews = News::with('category')->where([['category_id', '=', $category->id], ['active', '=', config('settings.active')], ['id', '<>', $news->id]])->orderBy('updated_at', 'DESC')->take(config('settings.paginate.page6'))->get();
                return view("theme::front-end.news.detail", compact('slugParent', 'slugDetail', 'news', 'category', 'otherNews'));
            default:
                return view("theme::front-end.404", compact('slugParent', 'slugDetail'));
        }
    }

    public function getPage($slug)
    {
        $page = Page::where([['slug', '=', $slug], ['active', '=', config('settings.active')]])->first();
        $menu = SysMenu::where([['slug', '=', $slug]])->first();
        if($menu != null)
            return view('theme::front-end.pages.page', compact('page','menu'));
        else
            return view("theme::front-end.404");
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $news = new News();
        $news = $news->with('category');
        if (!empty($query)) {
            $news = $news->where('name', 'LIKE', "%$query%")
                ->orWhere('description', 'LIKE', "%$query%")
                ->orWhere('content', 'LIKE', "%$query%");
        }
        $news = $news->paginate(config('settings.paginate.page12'));

        return view('theme::front-end.products.search', compact('news', 'query'));
    }


}
