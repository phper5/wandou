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

        $movie_lsit = $dom->find(".ul-imgtxt1.row   li.col-sm-4");
        $i=0;
        foreach ($movie_lsit as $movie) {
            //echo $movie;
            $pic = $movie->find(".pic img",0);
            $src =  $pic->src;
            $title = $movie->find(".txt font",0);
//            if (!$title) {
//                $title = $movie->find("h3 font",0);
//            }
            if (!$title) {
                $title = $movie->find("h3",0);
            }
            $title = $title->plaintext;
            echo $title.' ';
            $url = $movie->find("a",0);
            $url = $url->href;

            echo $src;echo $title;echo $url;
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
