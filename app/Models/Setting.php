<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * @property string $key
 * @property array $value
 * @method static Builder key(string $key)
 */
class Setting extends Model {

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = ['value' => 'array'];

    protected static function boot() {
        parent::boot();

        // Once we update the setting in db, we should remove it from cache
        static::updated(function ($setting) {
            Cache::forget("setting-{$setting->key}");
        });
    }

    /**
     * Scope for key
     */
    public function scopeKey($query, $key) {
        $query->where('key', $key);
    }
}
