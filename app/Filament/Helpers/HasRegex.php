<?php

namespace App\Filament\Helpers;

use App\Rules\LingualRegexRule;

trait HasRegex
{
    public function languageRule(): static
    {
//        $english_pattern = "/^[^a-zA-Z0-9]+$/i";
//        $arabic_pattern = "/[a-zA-Z0-9\s\p{P}]+$/i";
//        $locale = last(explode('.', $this->name));
//        if ($locale == "en")
//            $this->rules([
//                new LingualRegexRule($english_pattern)
//            ]);
//        else if ($locale == "ar")
//            $this->rules([
//                new LingualRegexRule($arabic_pattern)
//            ]);
        return $this;
    }

}