<?php

namespace App\Traits;

trait StringTrait {

    /**
     * Replace single quote ' to #39; in text => for escaping character
     *
     * @param $text
     * @return string
     */
    public function replaceSingleQuote($text)
    {    
        return str_replace("'", "&#39;", $text);
    }

}