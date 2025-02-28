<?php

namespace App\Actions;

class GenerateAutoID
{
    protected string $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function getGeneratedNumber($last_code = null, $length)
    {
        $number = $this->getSerialNumber(1, $length);
        if ($last_code) {
            $number = $this->calculateAutoNumber(exist_code: $last_code, length: $length);           
        }
        return $number;
    }

    public function calculateAutoNumber(string $exist_code, $length)
    {
        $code_part = intval(substr(strrchr($exist_code, '-'), 1)); // Convert to integer explicitly
    
        $next_value = ($code_part + 1);
    
        return $this->getSerialNumber($next_value, $length);
    }

    public function getSerialNumber($next_value, $length)
    {
        $code = substr(str_pad($next_value,  $length, '0', STR_PAD_LEFT), -$length);
        
        return $this->prefix . '-' . $code;
    }
}
