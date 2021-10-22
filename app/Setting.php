<?php

namespace App;

use App\Traits\ImageResize;
use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Setting extends Model
{
    use Cachable, ImageResize;
    public static $imageFolder = "settings";
    public static $imageMaxWidth = 400;
    public static $imageMaxHeight = 400;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

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
    protected $fillable = ['key', 'value','description', 'user_id'];

    protected static function boot() {
        parent::boot(); // TODO: Change the autogenerated stub
        self::creating(function ($model){
            if(\Auth::check()) $model->user_id = \Auth::user()->id;
        });
        self::updating(function ($model){
            if(\Auth::check()) $model->user_id = \Auth::user()->id;
        });
    }
    public static function configsDefault(){
        return config('settings.settings_site');
    }

    public static function allConfigs(){
        $settingConfigs = self::configsDefault();

        $data = [];
        $settings = Setting::get();
        foreach ($settingConfigs as $sc){
            if($settings->count()>0) {
                foreach ( $settings as $s ) {
                    if ( $s->key === $sc['key'] ) {
                        $sc['value'] = $s->value;
//			            $sc['description'] = $s->description;
                        break;
                    }
                }
            }
            $data[$sc["group_data"]][] = $sc;
        }
        return $data;
    }
    public static function allConfigsKeyValue(){
        $settingConfigs = self::configsDefault();

        $data = [];
        $settings = Setting::get();
        foreach ($settingConfigs as $sc){
            if($settings->count()>0) {
                foreach ( $settings as $s ) {
                    if ( $s->key === $sc['key'] ) {
                        $sc['value'] = $s->value;
//			            $sc['description'] = $s->description;
                        break;
                    }
                }
            }
            $data[$sc['key']] = $sc['value'];
        }
        return $data;
    }
}
