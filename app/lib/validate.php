<?php
namespace PHPMVC\LIB;

trait Validate
{
    private $_regexPatterns = [
        "number"        => '/^[0-9]+(?:\.[0-9]+)?$/',
        'int'           => '/^[0-9]+$/',
        'float'         => '/^[0-9]+\.[0-9]+$/',
        'alpha'         => '/^[a-zA-Z\p{Arabic}]+$/u',
        'alphanum'      => '/^[a-zA-Z\p{Arabic}0-9]+$/u',
        'Validdate'     => '/^[1-2][0-9][0-9][0-9]-(?:(?:0[1-9])|(?:1[0-2]))-(?:(?:0[1-9])|(?:(?:1|2)[0-9])|(?:3[0-1]))$/',
        'email'         => '/^([\w0-9_\-\.]+)@([\w\-]+\.)+[\w]{2,6}$/',
        'url'           => '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w\.-]*)*\/?$/'
    ];

    public function EmptyValue ($value)
    {
        return '' == $value || empty($value);
    }

    public function Number($value)
    {
        return (bool) preg_match($this->_regexPatterns['number'], $value);
    }

    public function IntNumber($value)
    {
        return (bool) preg_match($this->_regexPatterns['int'], $value);
    }

    public function FloatNumber($value)
    {
        return (bool) preg_match($this->_regexPatterns['float'],$value);
    }

    public function alpha($value)
    {
        return (bool) preg_match($this->_regexPatterns['alpha'], $value);
    }

    public function alphaNumber($value)
    {
        return (bool) preg_match($this->_regexPatterns['alphanum'], $value);
    }

    public function lessThan($value, $matchNumber)
    {
        if(is_numeric($value)) {
            return $value < $matchNumber;
        } elseif (is_string($value)) {
            return mb_strlen($value) < $matchNumber;
        }
    }

    public function greaterThan($value, $matchNumber)
    {
        if(is_numeric($value)) {
            return $value > $matchNumber;
        } elseif (is_string($value)) {
            return mb_strlen($value) > $matchNumber;
        }
    }

    public function min($value, $min)
    {
        if(is_numeric($value)) {
            return $value >= $min;
        } elseif (is_string($value)) {
            return mb_strlen($value) >= $min;
        }
    }

    public function max($value, $max)
    {
        if(is_numeric($value)) {
            return $value <= $max;
        } elseif (is_string($value)) {
            return mb_strlen($value) <= $max;
        }
    }

    public function between($value, $min, $max)
    {
        if(is_numeric($value)) {
            return $value >= $min && $value <= $max;
        } elseif (is_string($value)) {
            return mb_strlen($value) >= $min && mb_strlen($value) <= $max;
        }
    }

    public function floatLike($value, $beforeDP, $afterDP)
    {
        if(!$this->FloatNumber($value)) {
            return false;
        }
        $pattern = '/^[0-9]{' . $beforeDP . '}\.[0-9]{' . $afterDP . '}$/';
        return (bool) preg_match($pattern, $value);
    }

    public function validDate($value)
    {
        return (bool) preg_match($this->_regexPatterns['Validdate'], $value);
    }

    public function validEmail($value)
    {
        return (bool) preg_match($this->_regexPatterns['email'], $value);
    }

    public function url($value)
    {
        return (bool) preg_match($this->_regexPatterns['url'], $value);
    }


}