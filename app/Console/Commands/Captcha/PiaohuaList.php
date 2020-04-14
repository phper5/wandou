<?php


namespace App\Console\Commands\Captcha;


use Illuminate\Console\Command;
use KubAT\PhpSimple\HtmlDomParser;

class PiaohuaList extends Command
{
    protected $signature = 'captcha:piaohua-list';

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
        $start = 1;
        $cate ='lianxuju';//xiju aiqing kehuan
        //$nums = \Opis\Closure\unserialize($str);
        $flag = 1;
        while ($start < 291) {
            $url = "https://www.piaohua.com/html/".$cate."/list_" . $start . ".html";
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
                if ($url == '/html/'.$cate.'/2018/0303/33265.html')
                {
                    $flag = 1;
                    echo "start";
                }
                if (!$flag) {
                    continue;
                }
                //echo $url;exit;
                $ph = new \App\Models\Piaohua();
                $ph->title = $title;
                $ph->cover = $src;
                $ph->url = $url;
                $ph->cate = $cate;
                $ph->page = $start;
                $ph->save();

            }
            sleep(1);
            echo $start."\n";
//            print_r($movie);
            $start++;
//            break;
        }
    }

}
