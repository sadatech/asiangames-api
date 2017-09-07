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

    /**
     * Replace space for uploading images
     *
     * @param $text
     * @return string
     */
    public function replaceSpace($text)
    {    
        return str_replace(' ', '', $text);
    }

    /**
     * Give random path
     *
     * @param $text
     * @return string
     */
    public function getRandomPath()
    {    
        return str_random(30).time().str_random(30);
    }

}