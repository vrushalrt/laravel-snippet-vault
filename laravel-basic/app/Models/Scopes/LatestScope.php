<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LatestScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // This is the default scope for all models.
         
         // $builder->orderBy('created_at', 'desc');
        $builder->orderBy($model::CREATED_AT, 'desc');
    }
}
