<?php

namespace App\Models\Traits;

trait HasActiveColumn
{
    public function initializeHasActiveColumn()
    {
        $this->fillable[] = $this->getActiveColumn();
        $this->casts[$this->getActiveColumn()] = 'boolean';
    }

    public function scopeActive($query)
    {
        return $query->where($this->getTable() . '.' . $this->getActiveColumn(), 1);
    }

    public function getActiveColumn(): string
    {
        if (!property_exists(self::class, 'active_column')) {
            return 'active';
        }

        return $this->active_column;
    }
}
