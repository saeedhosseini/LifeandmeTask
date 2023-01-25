<?php


use Illuminate\Contracts\Validation\Validator;

if (!function_exists('show_error_validation')) {
    function show_error_validation(Validator $validator, bool $all = false): string
    {
        return $all ?
            implode(' , ', array_merge(...array_values($validator->errors()->messages())))
            : $validator->errors()->messages()[array_key_first($validator->errors()->messages())][0];
    }
}

if (!function_exists('replace_space')) {
    function replace_space(string $name): string
    {
        return str_replace(" ", '-', strtolower($name));
    }
}

