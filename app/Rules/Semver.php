<?php

namespace EmergencyExplorer\Rules;

use Illuminate\Contracts\Validation\Rule;
use vierbergenlars\SemVer\version;

class Semver implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            return ((new version($value, false))->valid() !== null);
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid semver pattern (see https://semver.org/)';
    }
}