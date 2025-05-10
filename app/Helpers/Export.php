<?php

namespace App\Helpers;

use pxlrbt\FilamentExcel\Columns\Column;

trait Export
{

    protected function fetchAttributes()
    {
        $model = new ($this->model);
        $this->attributes = \Schema::getColumnListing($model->getTable());
        $this->translatable = $model->translatable ?? [];
    }

    protected function ignore($exclude_timestamp = true): array
    {
        $this->fetchAttributes();

        $this->attributes = array_filter($this->attributes, function($attribute) use ($exclude_timestamp){
            if (str_ends_with($attribute, '_id') || ($exclude_timestamp && in_array($attribute, $this->timestamps))){
                $this->exclude[] = $attribute;
                return false;
            }

            return !in_array($attribute, array_merge($this->exclude, $this->translatable));
        });


        $this->translatable = array_filter($this->translatable, function($attribute) use ($exclude_timestamp){
            if (str_ends_with($attribute, '_id') || ($exclude_timestamp && in_array($attribute, $this->timestamps))){
                $this->exclude[] = $attribute;
                return false;
            }
            return !in_array($attribute, $this->exclude);
        });

        return array_merge($this->exclude, $this->translatable);
    }

    protected function translate($attribute, &$output)
    {
        foreach (config('app.locales') as $locale => $language)
            $this->column($attribute, $output, $locale, $language);
    }

    protected function column($attribute, &$output, $locale = null, $language = null)
    {
        $output[] = Column::make($locale ? "{$attribute}.{$locale}" : "{$attribute}")
            ->heading(function () use ($attribute, $language, $locale) {
                if ($language)
                    return "{$attribute}" . "_{$locale}";
                return "{$attribute}";
            })
            ->formatStateUsing(function ($state){
                return str_replace('/storage/', '', $state);
            })
            ->getStateUsing(function ($record) use ($attribute, $locale) {
                $data = $locale ? $record->getTranslation($attribute, $locale) : $record->{$attribute};
                if (in_array($attribute, $record->upload_attributes ?? []) && $data)
                    return config('app.uploads_dir') . $data;
                return $data;
            });
    }
}
