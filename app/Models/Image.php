<?php

namespace App\Models;

use App\Helpers\EloquentAutoComplete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class Image
 * @package App\Models
 */
class Image extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        static::deleting(function (Image $image){
            Storage::delete($image->name);
        });
    }

    /**
     * @param Model $parent
     * @param UploadedFile $image
     * @param string $type
     * @return mixed
     */
    public static function upload($parent, $image, $type = null)
    {
        $name = $image->store('images');

        return static::create([
            'name' => $name,
            'parent_id' => $parent->id,
            'parent_type' => get_class($parent),
            'type' => $type
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function parent()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->name);
    }

    public function toArray()
    {
        return $this->only(['id', 'url']);
    }
}
