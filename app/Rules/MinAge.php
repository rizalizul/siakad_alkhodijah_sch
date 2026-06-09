<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class MinAge implements ValidationRule
{
    protected $minAge;

    public function __construct($minAge)
    {
        $this->minAge = $minAge;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $birthDate = Carbon::parse($value);
        if ($birthDate->diffInYears(Carbon::now()) < $this->minAge) {
            $fail('Calon siswa harus berusia minimal ' . $this->minAge . ' tahun.');
        }
    }
}

