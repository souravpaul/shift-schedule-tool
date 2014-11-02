<?php

class Validation {

    function isNotBlank($value) {
        if ($value == "" || $value == NULL) {
            return false;
        }
        return true;
    }

    function checkMinLength($value, $min) {
        if (strlen($value) < $min) {
            return false;
        }
        return true;
    }

    function checkMaxLength($value, $max) {
        if (strlen($value) > $max) {
            return false;
        }
        return true;
    }

    function isAlphaNumeric($value, $extra_char = "") {
        $exp = "/[^a-zA-Z0-9" . $extra_char . "]/";
        if (preg_match($exp, $value)) {
            return false;
        }
        return true;
    }

    function isNumeric($value, $extra_char = "") {
        $exp = "/[^0-9" . $extra_char . "]/";
        if (preg_match($exp, $value)) {
            return false;
        }
        return true;
    }

    function isAlpha($value, $extra_char = "") {
        $exp = "/[^a-zA-Z" . $extra_char . "]/";
        if (preg_match($exp, $value)) {
            return false;
        }
        return true;
    }

    function isValidURL($url) {
        if (!preg_match("#^[a-z0-9-_.]+\.[a-z]{2,4}$#i", $url)) {
            return FALSE;
        }
        return TRUE;
    }

}
