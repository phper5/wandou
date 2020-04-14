<?php

declare(strict_types=1);

namespace App\Console\Commands\Captcha;

use App\Models\Console;
use Artisan;
use Composer\Semver\Comparator;
use File;
use Illuminate\Console\Command;
use KubAT\PhpSimple\HtmlDomParser;
use function simple_html_dom\str_get_html;

class See57 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'captcha:see57';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //$str = file_get_contents("../../nums/nums.txt");
        $start =1;
        //$nums = \Opis\Closure\unserialize($str);
        while($start<15000) {
            $url = "http://www.57see.com/movie/index".$start.".html";
            $dom = HtmlDomParser::file_get_html( $url );
            echo $dom;

//            $movie = $dom->find(".MovieIntro");
//            print_r($movie);
//            $start++;
            break;
        }



    }
}
