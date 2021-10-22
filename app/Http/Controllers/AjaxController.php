<?php
namespace App\Http\Controllers;

use App\Agent;
use App\Customer;
use App\Guide;
use App\Http\Requests;
use App\Journey;
use App\Menu;
use App\ModuleInfo;
use App\Tour;
use Carbon\Carbon;
use Modules\Product\Entities\Review;
use function foo\func;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
	/**
	 * Gọi ajax: sẽ gọi đến hàm = tên $action
	 * @param Request $action
	 * @param Request $request
	 * @return mixed
	 */
	public function index($action, Request $request)
	{
		return $this->{$action}($request);
	}

	/**
	 * Get list agent by company id
	 * action: getAgentsByCompanyID
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse|null
	 */
	private function getAgents(Request $request){

		$agents = Agent::select('name','id')->get();

		return response()->json($agents);
	}

    /**
     * Get list service in view report
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|null
     */
	public function getServiceReport(Request $request){
	    if ($request->module == null){
	        return response()->json();
        }
        $moduleInfo = new ModuleInfo($request->module);
        $service = $moduleInfo->getBookingServiceInfo();
        if ($request->module == 'car' || $request->module == 'bike'){
            $list_services = $service['namespaceModel']::pluck('number_plate', 'id');
        }else{
            $list_services = $service['namespaceModel']::pluck('name', 'id');
        }

        return response()->json($list_services);
    }

    /*
     * activeSliders
     * @param: $request
     * */
    public function activeReview(Request $request){
        $ids = $request->ids;
        $arrId = explode(',', $ids,-1);
        foreach ($arrId as $item){
            $review = Review::findOrFail($item);
            $active = $review->active == config('settings.active') ? config('settings.inactive') : config('settings.active');
            \DB::table('reviews')->where('id', $review->id)->update(['active' => $active]);
        }
        return \response()->json(['success' => 'ok']);
    }

    /*
     * deleteSliders
     * @param: $request
     * */
    public function deleteReview(Request $request){
        $ids = $request->ids;
        $arrId = explode(',', $ids,-1);
        foreach ($arrId as $item){
            Review::destroy($item);
        }
        return \response()->json(['success' => 'ok']);
    }
    /*
     * DeleteMenus
     * @param: $request
     * */
    public function deleteMenus(Request $request){
        $ids = $request->ids;
        $arrId = explode(',', $ids,-1);
        foreach ($arrId as $item){
//            $menu = Menu::findOrFail($item);
//            switch ($menu->keywords){
//                case 'pages':
//                    Page::where('slug', $menu->slug)->delete();
//                    break;
//                case 'categories':
//                    Category::where('slug', $menu->slug)->delete();
//                    break;
//                case 'media':
//                    MediaCategory::where('slug', $menu->slug)->delete();
//                    break;
//            }
            \Modules\SysMenu\Entities\Menu::destroy($item);
        }
        return \response()->json(['success' => 'ok']);
    }
}