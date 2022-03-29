<?php

namespace App\Filament\Filters;

use Filament\Forms\Components\Concerns\CanSpanColumns;
use Filament\Forms\Concerns\HasColumns;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class SelectFilter extends \Filament\Tables\Filters\SelectFilter
{
    use CanSpanColumns;
    use HasColumns;

    public function getRelationshipKey(): string
    {
        $relationship = $this->getRelationship();

        if ($relationship instanceof MorphToMany) {
            $keyColumn = $relationship->getParentKeyName();
        } elseif ($relationship instanceof HasOneThrough){
            $keyColumn = $relationship->getQualifiedForeignKeyName();
        } else {
            /** @var BelongsTo $relationship */
            $keyColumn = $relationship->getOwnerKeyName();
        }

        return $keyColumn;
    }
}
