<?php

use App\Models\Setting;

/**
 * Get constants of a class
 * @param $class
 * @param null $values
 * @return array
 */
function constants($class, $values = null): array
{
    try {
        $constants = (new ReflectionClass($class))->getConstants();
        if($values === true){
            return array_values($constants);
        }
        if($values === false){
            return array_keys($constants);
        }
        return $constants;
    } catch (ReflectionException $e) {
        return [];
    }
}

/**
 * Get readable constant name from an enum value
 * @param string $class
 * @param string|int $value
 * @param null $default
 * @return string
 */
function readable_constant($class, $value, $default = null): string
{
    $constants = array_flip(constants($class));
    if(!isset($constants[$value])){
        return $default;
    }
    return implode(' ', array_map('ucfirst', explode('_', strtolower($constants[$value]))));
}


/**
 * Get the setting for a given key
 * @param string $key
 * @param $default
 * @return array|mixed
 */
function setting(string $key, $default = null)
{
    $setting = \Illuminate\Support\Facades\Cache::rememberForever("setting-{$key}", function () use ($key) {
        return Setting::where('key', $key)->first();
    });

    return data_get($setting, 'value', $default);
}

/**
 * @see \setting()
 * @return int
 */
function setting_int(){
    return (int) setting(...func_get_args());
}

/**
 * @see \setting()
 * @return \Illuminate\Support\Collection
 */
function setting_collection(){
    return collect(setting(...func_get_args()));
}

/**
 * Calculate some percent of some value
 * @param int|float $target
 * @param float|int $percent
 * @return float|int
 */
function percent(int|float $target, float|int $percent)
{
    return $target * $percent / 100;
}

/**
 * Assign value to a variable conditionally
 * @param bool|callable $condition
 * @param $variable
 * @param mixed $value
 * @return bool
 */
function assign_if(bool|callable $condition, &$variable, mixed $value)
{
    if(is_callable($condition)){
        $condition = call_user_func($condition);
    }
    if(!$condition){
        return false;
    }
    if(is_callable($value)){
        $value = call_user_func($value);
    }
    $variable = $value;
    return true;
}
