<?php
namespace FilamentPro\Resources;

class Resource extends \Filament\Resources\Resource
{
    public static function getPluralLabel(): string
    {
        return static::getLabel();
    }
}
