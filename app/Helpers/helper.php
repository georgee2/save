<?php

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
