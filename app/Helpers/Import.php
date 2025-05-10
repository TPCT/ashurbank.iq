<?php

namespace App\Helpers;


trait Import
{
    private int $row_index = 0;
    private function transform($header): array
    {
        $modified_header = [];
        foreach ($header as $header_key) {
            if (!$header_key)
                continue;
            $header_key = \Arr::get($this->transforms, $header_key, $header_key);
            if (is_string($header_key)) {
                $header_key = str_replace('[KU]', '[FA]', $header_key);
                $modified_header[] = \Str::slug(str_replace(['[', ']'], [' ', ''], $header_key), '_');
            }
        }
        return $modified_header;
    }

    private function translate($collection){
        foreach ($this->translatable as $item){
            foreach (config('app.locales') as $locale => $language){
                if ($item == "description" || $item == "content")
                    $collection[$item][$locale] = "<p>" . strip_tags($collection[$item . "_" . $locale]) . "</p>";
                else
                    $collection[$item][$locale] = str_replace('/storage/', '', $collection[$item. "_" . $locale]);
                unset($collection[$item. "_" . $locale]);
            }
        }
        return $collection;
    }

    private function trim($collection){
        foreach ($collection as $label => $item){
            if (!$label || in_array($label, ['id', 'created_at', 'status', 'updated_at', 'published_at', 'slug']))
                unset($collection[$label]);
        }
        return $collection;
    }
}
