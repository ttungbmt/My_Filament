<?php
namespace App\Filament\Filters;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\Concerns;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TextInputFilter extends Filter
{
    use Concerns\HasPlaceholder;
    use Concerns\HasRelationship;

    protected string | array $column = [];

    protected bool $strict = false;

    public function apply(Builder $query, array $data = []): Builder
    {
        if ($this->hasQueryModificationCallback()) {
            return parent::apply($query, $data);
        }

        if (blank($data['value'] ?? null)) {
            return $query;
        }

        return $query->where(function ($query) use ($data) {
            $model = $query->getModel();
            $connectionType = $query->getModel()->getConnection()->getDriverName();

            $operator = $this->strict ? '=' : ($connectionType == 'pgsql' ? 'ilike' : 'like');

            $query->orWhere(function ($query) use ($data, $model, $operator) {
                foreach ($this->getColumn() as $column) {
                    $qSearch = $data['value'];

                    if(Str::of($column)->contains('.')){
                        $relationshipKey = $this->getRelationshipKey($column);

                        if(!$this->strict){
                            $relationshipKey = "UPPER($relationshipKey)";
                            $qSearch = "%".mb_strtoupper($qSearch)."%";
                        }

                        return $query->orWhereRelation(
                            $this->getRelationshipName($column),
                            DB::raw($relationshipKey),
                            $operator,
                            $qSearch,
                        );
                    }

                    $qColumn = $model->qualifyColumn($column);

                    if(!$this->strict){
                        $qColumn = "UPPER($qColumn)";
                        $qSearch = "%".mb_strtoupper($qSearch)."%";
                    }

                    return $query->orWhereRaw("$qColumn $operator ?", [$qSearch]);
                }
            });
        });
    }

    public function strict(bool $strict = true): static
    {
        $this->strict = $strict;

        return $this;
    }

    public function getColumn(): array
    {
        return !empty($this->column) ? $this->column : [$this->getName()];
    }

    public function column(string | array $column): static
    {
        if (!is_array($column)) $column = [$column];

        $this->column = $column;

        return $this;
    }

    public function getFormSchema(): array
    {
        return $this->formSchema ?? [
                TextInput::make('value')
                    ->type('search')
                    ->label($this->getLabel())
                    ->placeholder($this->getPlaceholder())
                    ->default($this->getDefaultState()),
            ];
    }

    protected function getRelationship($column): Relation
    {
        $model = app($this->getTable()->getModel());

        return $model->{$this->getRelationshipName($column)}();
    }

    protected function getRelationshipName($column): string
    {
        return (string) Str::of($column)->beforeLast('.');
    }

    public function getRelationshipKey($column): string
    {
        $relationship = $this->getRelationship($column);

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
