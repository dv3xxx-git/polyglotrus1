<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPHtmlParser\Dom;
use Storage;
use DOMDocument;
use DOMXPath;


class ParseController extends Controller
{
    public function parseWordByWord()
    {
        $url = 'https://word-by-word.ru/ratings/';

        $cefrs = [];
        $fileName = 'wordByWordcefr-a1.txt';
        $file = Storage::disk('local')->get($fileName);

        if(!empty($file))
        {
            $data = $this->analyzeDoc($file);
            dd($data);
        }
        else
        {
            getPage($url, $fileName);
            $file = Storage::disk('local')->get($fileName);
            $data = $this->analyzeDoc($file);
        }

    }

    private function analyzeDoc($file)
    {
        $data = [];

        $dom = new DOMDocument;
        // Подавлеяем предупреждения libxml
        @$dom->loadHTML($file); // Загружаем HTML в объект DOM

        $xpath = new DOMXPath($dom);

        // Подготавливаем запрос для выбора всех элементов с тегом 'tag'
        $cefrNavs = $xpath->query(".//*[@class='cefr-nav']");
        dd($cefrNavs->count());
        foreach ($cefrNavs as $cefrNav) {
            dd($cefrNav->textContent);
        }
        dd($xpath);
        return $data;
    }

    private function getPage(string $url, string $fileName)
    {
        $headers = array(
            'cache-control: max-age=0',
            'upgrade-insecure-requests: 1',
            'user-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36',
            'sec-fetch-user: ?1',
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'x-compress: null',
            'sec-fetch-site: none',
            'sec-fetch-mode: navigate',
            'accept-encoding: deflate, br',
            'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
        );

        $ci = curl_init("$url/cefr-a1");

        curl_setopt($ci, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
        curl_setopt($ci, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ci, CURLOPT_HEADER, true);

        $html = curl_exec($ci);
        curl_close($ci);

        Storage::disk('local')->put($fileName, $html);
        dd($html);
    }
    // public function parseWordByWord()
    // {
    //     $levels = [];

    //     $url = 'https://word-by-word.ru/ratings';
    //     $firstLevel = '/cefr-a1';

    //     $dom = new Dom;
    //     $dom->loadFromUrl($url . $firstLevel);

    //     $pageUls = $this->setPageWords($dom->find("ul"));
    //     //$this->setPageWords($dom->find("ul .word-list"));

    //     $navLevel = $dom->find('.cefr-nav');

    //     $tmpLevels = $navLevel->find('a');

    //     foreach ($tmpLevels as $lev)
    //     {
    //         $key = 1;
    //         $value = $lev->getAttribute('href');

    //         $levels[$key] = $value;
    //     }
    // }

    // public function setPageWords($listWord)
    // {
    //     foreach ($listWord as $ul)
    //     {

    //     }
    //     $test = $listWord[3]->getTag();
    //     dd($test->getAttribute());
    // }
}
