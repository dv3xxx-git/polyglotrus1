<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ParseWordByWord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-word-by-word';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Парсим слова по уровням и типам';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        return 1;
    }
}
