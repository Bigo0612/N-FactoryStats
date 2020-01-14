<?php

function debug($tableau)
{
    echo '<pre>';
    print_r($tableau);
    echo '</pre>';
}

function clean ($string)
{
    return trim(strip_tags($string));
}
