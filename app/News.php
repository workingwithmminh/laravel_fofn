<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class News extends Model
{
    use Sortable, SoftDeletes;

    const ID_NEWS = 2;

    static public $ID_NEWS = 1;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'news';

    public $sortable = [
        'title',
        'category_id',
        'updated_at'
    ];

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title','category_id','slug','image', 'description','content','active','is_focus'];

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function creator(){
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function editor(){
        return $this->belongsTo('App\User', 'editor_id');
    }

    public static function getListActive(){
        $arr = [1 => 'Hiển thị', 2 => 'Không hiển thị'];
        return $arr;
    }

    static public function uploadAndResize($image, $width = 450, $height = null){
        if(empty($image)) return;
        $folder = "/images/news/";
        if(!\Storage::disk(config('filesystems.disks.public.visibility'))->has($folder)){
            \Storage::makeDirectory(config('filesystems.disks.public.visibility').$folder);
        }
        //getting timestamp
        $timestamp = Carbon::now()->toDateTimeString();
        $fileExt = $image->getClientOriginalExtension();
        $filename = str_slug(basename($image->getClientOriginalName(), '.'.$fileExt));
        $pathImage = str_replace([' ', ':'], '-', $folder.$timestamp. '-' .$filename.'.'.$fileExt);

        $img = \Image::make($image->getRealPath())->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img->save(storage_path('app/public').$pathImage);

        return config('filesystems.disks.public.path').$pathImage;
    }

    public static function boot(){
        parent::boot();
        self::creating(function ($model){
            $model->creator_id = \Auth::user()->id;
            $model->editor_id = \Auth::user()->id;
        });
        self::updating(function ($model){
            $model->editor_id = \Auth::user()->id;
        });
    }
}
