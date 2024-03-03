<?php

namespace App\Filament\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueIgnoreId implements Rule
{
    protected string $column;
    protected string $table;
    protected int $id;

    public function __construct(string $column, int $id)
    {
        $this->column = $column;
        $this->id = $id;

        $this->rule = function () use ($column, $id) {
            return fn ($attribute, $value, $fail) => $value !== $id
                ? $this->table
                ::where($this->column, '=', $value)
                ->doesntExist()
                : true;
        };
    }

    public function passes($attribute, $value)
    {
        return $this->table
            ::where($this->column, '=', $value)
            ->where($this->column, '!=', $this->id)
            ->doesntExist();
    }

    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}