<?php

namespace App\Http\Controllers;

use App\Agent;
use Modules\Booking\Entities\Booking;
use Modules\Booking\Entities\Customer;
use App\User;
use Illuminate\Http\Request;
use App\News;
use Modules\Product\Entities\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::count();
        $news = News::count();
        $usersCount = User::count();
        $orders = Booking::count();
        return view('adminlte::home', compact('news', 'products', 'usersCount', 'orders'));
    }
}
