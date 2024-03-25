<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ParseController extends Controller
{
    public function parseWordByWord()
    {
        $test = file_get_html('https://word-by-word.ru/ratings/cefr-a1')->plaintext;
        str_get_ht
        dd($test);
    }
}
