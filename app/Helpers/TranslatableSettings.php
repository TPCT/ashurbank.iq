<?php

namespace App\Helpers;

use Spatie\LaravelSettings\Settings;

trait TranslatableSettings
{
    public function translate($name)
    {
        if (is_array(parent::__get($name)) && in_array($name, $this->translatable))
            return parent::__get($name)[app()->getLocale()];
        return parent::__get($name); // TODO:
    }
}
