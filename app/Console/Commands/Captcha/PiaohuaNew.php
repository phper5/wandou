<?php


namespace App\Console\Commands\Captcha;


use Illuminate\Console\Command;
use KubAT\PhpSimple\HtmlDomParser;

class PiaohuaNew extends Command
{
    protected $signature = 'captcha:piaohua-new';

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


        $url = "https://www.piaohua.com/html/dianying.html";
        $dom = HtmlDomParser::file_get_html($url);
//            echo $dom;

        $movie_lsit = $dom->find(".col-md-9 ul.ul-imgtxt2 li.col-md-6");
        foreach ($movie_lsit as $movie) {
            //echo $movie;
            $pic = $movie->find(".pic img",0);
            $src =  $pic->src;
            $title = $movie->find("h3 b",0);
            if (!$title) {
                $title = $movie->find("h3 font",0);
            }
            if (!$title) {
                $title = $movie->find("h3 a",0);
            }
            $title = $title->plaintext;
            echo $title.' ';
            $url = $movie->find("h3 a",0);
            $url = $url->href;

            if (!\App\Models\Piaohua::where('url',$url)->first()) {
                $ph = new \App\Models\Piaohua();
                $ph->title = $title;
                $ph->cover = $src;
                $ph->url = $url;
                $ph->cate = '';
                $ph->page = 0;
                $ph->save();
            }

        }
        sleep(1);


    }

}
