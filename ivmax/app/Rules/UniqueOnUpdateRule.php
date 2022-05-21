<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueOnUpdateRule implements Rule {

    private $model;
    private $id;
    private $column;

    public function __construct($model, $id, $column = 'name') {
        $this->model = "App\Models\\$model";
        $this->id = $id;
        $this->column = $column;
    }

    public function passes($attribute, $value) : bool {
        return !(bool) $this->model::query()
            ->where('id', '!=', $this->id)
            ->where($this->column, '=', $value)
            ->count();
    }

    public function message() : string {
        return "The $this->column has already been taken.";
    }

}
