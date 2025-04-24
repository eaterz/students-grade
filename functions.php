<?php

function dd($data)
{
    echo "<pre>";
    echo var_dump($data);
    echo "</pre>";
    die();
}