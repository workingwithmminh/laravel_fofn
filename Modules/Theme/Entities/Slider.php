<?php

namespace Modules\Theme\Entities;

use Carbon\Carbon;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "sliders";

    protected $sortable = [
        'name',
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
    protected $fillable = ['name','image','link','active','arrange'];

    static public function uploadAndResize($image, $width = 1349, $height = null){
        if(empty($image)) return;
        $folder = "/images/sliders/";
        if(!\Storage::disk(config('filesystems.disks.public.visibility'))->has($folder)){
            \Storage::makeDirectory(config('filesystems.disks.public.visibility').$folder);
        }
        //getting timestamp
        $timestamp = Carbon::now()->toDateTimeString();
        $fileExt = $image->getClientOriginalExtension();
        $filename = str_slug(basename($image->getClientOriginalName(), '.'.$fileExt));
        $pathAvatar = str_replace([' ', ':'], '-', $folder.$timestamp. '-' .$filename.'.'.$fileExt);
        \Image::make($image->getRealPath())->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('/storage').$pathAvatar);

        return config('filesystems.disks.public.path').$pathAvatar;
    }
}
