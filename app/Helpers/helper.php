<?php

use App\Models\Menu;

if (!function_exists('json')) {
    function json($data)
    {
        return json_encode($data);
    }
}


if (!function_exists('dataLocale')) {
    function dataLocale($data, $attrs)
    {
        $result = [];
        foreach ($data as $key => $value) {
            $row = collect($value)->toArray();
            $keys = array_keys($row);
            $result[] = [];
            $serializedKeys = [];
            foreach ($keys as $index => $value) {
                if (Str::of($value)->contains('_en')) {
                    if (app()->getLocale() == 'en') {
                        $transKey = Str::of($value)->replace('_ar', '');
                        $transKey = Str::of($value)->replace('_en', '');
                        $arkey = $transKey . '_ar';
                        $enkey = $transKey . '_en';
                        if (!in_array($arkey, $serializedKeys) && !in_array($enkey, $serializedKeys)) {
                            $serializedKeys[] = $enkey;
                        }
                    } else {
                        $transKey = Str::of($value)->replace('_ar', '');
                        $transKey = Str::of($value)->replace('_en', '');
                        $arkey = $transKey . '_ar';
                        $enkey = $transKey . '_en';
                        if (!in_array($arkey, $serializedKeys) && !in_array($enkey, $serializedKeys)) {
                            $serializedKeys[] = $arkey;
                        }
                    }
                } else if (Str::of($value)->contains('_ar')) {
                    $transKey = Str::of($value)->replace('_en', '');
                    $transKey = Str::of($value)->replace('_ar', '');
                    $arkey = $transKey . '_ar';
                    $enkey = $transKey . '_en';
                    if (!in_array($arkey, $serializedKeys) && !in_array($enkey, $serializedKeys)) {
                        $serializedKeys[] = $arkey;
                    }
                } else {
                    $serializedKeys[] = $value;
                }
            }
            foreach ($serializedKeys as $v => $iterator) {
                $result[$key][$attrs[$v]] = $row[$iterator];
            }
        }
        return collect($result)->toArray();
    }
}


if (!function_exists('tags')) {
    function tags($data)
    {
        $tags = "";
        $tagsToArray = json_decode($data);
        foreach ($tagsToArray as $key => $tag) {
            if ($key + 1 !== count($tagsToArray)) {
                $tags .= $tag->value . ', ';
            } else {
                $tags .= $tag->value;
            }
        }

        return $tags;
    }
}

/**
 * Menu Helper Functions
 */

if (!function_exists('getMenu')) {
    /**
     * Get a menu by slug
     * 
     * @param string $slug
     * @return Menu|null
     */
    function getMenu(string $slug): ?Menu
    {
        return Menu::getBySlug($slug);
    }
}

if (!function_exists('getMenuByLocation')) {
    /**
     * Get a menu by location
     * 
     * @param string $location
     * @return Menu|null
     */
    function getMenuByLocation(string $location): ?Menu
    {
        return Menu::getByLocation($location);
    }
}

if (!function_exists('getHeaderMenu')) {
    /**
     * Get the header menu with fallback logic:
     * 1. If primary menu is active, use it
     * 2. If primary is inactive, use the last active custom menu
     * 
     * @return Menu|null
     */
    function getHeaderMenu(): ?Menu
    {
        return Menu::getHeaderMenu();
    }
}

if (!function_exists('getPrimaryMenu')) {
    /**
     * Get the primary menu (only if active)
     * 
     * @return Menu|null
     */
    function getPrimaryMenu(): ?Menu
    {
        return Menu::getPrimaryMenu();
    }
}

if (!function_exists('getMenuItems')) {
    /**
     * Get hierarchical menu items by slug
     * 
     * @param string $slug
     * @return \Illuminate\Support\Collection
     */
    function getMenuItems(string $slug): \Illuminate\Support\Collection
    {
        $menu = Menu::getBySlug($slug);
        return $menu ? $menu->getHierarchicalItems() : collect();
    }
}

if (!function_exists('getAllActiveMenus')) {
    /**
     * Get all active menus
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function getAllActiveMenus(): \Illuminate\Database\Eloquent\Collection
    {
        return Menu::getAllActive();
    }
}

if (!function_exists('getActiveMenusByLocation')) {
    /**
     * Get all active menus for a specific location
     * 
     * @param string $location
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function getActiveMenusByLocation(string $location): \Illuminate\Database\Eloquent\Collection
    {
        return Menu::getActiveMenusByLocation($location);
    }
}
