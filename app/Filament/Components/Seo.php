<?php

namespace App\Filament\Components;

use App\Helpers\Utilities;
use Filament\Facades\Filament;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Seo
{
    public static function make($locales, $only = ['image', 'title', 'description', 'author', 'robots', 'keywords']){
        $tabs = [];
        foreach ($locales as $locale => $language){
            $tabs[] = Tab::make($language)->schema(Arr::only([
                'image' => \Filament\Forms\Components\FileUpload::make("image.{$locale}")
                    ->label(__("SEO Image") . "[$language]")
                    ->image()
                    ->imageEditor()
                    ->formatStateUsing(function($state, $record, $component){
                        if (!$record || !$record->image)
                            return $state;
                        if (is_array($record->image))
                            return $record->image;
                        $image_data = [];
                        foreach(config('app.locales') as $locale => $language)
                            $image_data[$component->getId()] = $record->image;
                        return $image_data;
                    }),

                'title' => \Filament\Forms\Components\TextInput::make("title.{$locale}")
                    ->label(__("SEO Title") . "[{$language}]")
                    ->maxLength(255),

                'description' => \Filament\Forms\Components\TextInput::make("description.{$locale}")
                    ->label(__("SEO Description") . "[$language]")
                    ->formatStateUsing(function($state){
                        return Utilities::trimParagraph($state);
                    }),

                'author' => \Filament\Forms\Components\TextInput::make("author.{$locale}")
                    ->label(__("SEO Author") . "[$language]")
                    ->maxLength(255)
                    ->formatStateUsing(function($record){
                        return $record?->author->name ?? Filament::auth()->user()->name;
                    }),

                'keywords' => \Filament\Forms\Components\TagsInput::make("keywords.{$locale}")
                    ->label(__("SEO Keywords") . "[{$language}]")
                    ->separator(','),

                'canonical_url' => \Filament\Forms\Components\TextInput::make("canonical_url.{$locale}")
                    ->label(__("SEO Canonical Url") . "[{$language}]")
                    ->maxLength(255),

                'robots' => \Filament\Forms\Components\Select::make("robots")
                    ->label(__("SEO Robots"))
                    ->options(\App\Models\Seo::getRobots())
                    ->multiple()
                    ->native(false)
                    ->preload(),

            ], $only));
        }
        return Group::make([
                Tabs::make()->tabs($tabs)
            ])
            ->afterStateHydrated(function (Group $component, ?Model $record, Get $get) use ($only, $locales): void {
                $component->getChildComponentContainer()->fill((function() use ($record, $only, $locales, $get){
                    $values = [];
                    foreach ($only as $attribute){
                        $values[$attribute] = [];
                        if ($record?->seo) {
                            foreach ($locales as $locale => $language){
                                if (in_array($attribute, $record->seo->translatable))
                                    $values[$attribute][$locale] = $record?->seo->getTranslation($attribute, $locale) ?: $get("{$attribute}.{$locale}");
                                else
                                    $values[$attribute] = $record?->seo->$attribute ?: $get("{$attribute}");
                            }
                        }
                    }
                    return $values;
                })());
            })

            ->statePath('seo')
            ->dehydrated(false)
            ->saveRelationshipsUsing(function (Model $record, array $state) use ($only): void {
                $state = collect($state)->only($only)->map(fn ($value) => $value ?: null)->all();
                if ($record->seo && $record->seo->exists) {
                    $state['image'] = [];
                    if ($record->image && is_string($record->image)){
                        foreach(config('app.locales') as $locale => $language){
                            $state['image'][$locale]['data.seo.image.' . $locale] = is_array($record->image) ? $record->image[$locale] : $record->image;
                        }
                    }
                    $record->seo->update($state);
                }
            });
    }
}

