<?php


namespace App\Console\Commands\Captcha;


use Illuminate\Console\Command;
use KubAT\PhpSimple\HtmlDomParser;

class PiaohuaDetail extends Command
{
    protected $signature = 'captcha:piaohua-detail';

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

    private function getUrl($a)
    {
        $url = $a->href;
        if (strstr($url,'java') || strstr($url,'piaohua')){
            $url = $a->plaintext;
        }

        if ($new =strstr($url,'path=')) {
            $url = substr($new,strlen('path='));
        }
        $url = trim($url);
        if (strstr($url,'ftp') || strstr($url,'thunder')|| strstr($url,'magnet')
            || strstr($url,'btbo')|| strstr($url,'fcd')
            || strstr($url,'ed2k')
        ) {
           return  $url;
        }
        if (strstr($url,'pan.baidu')) {
            return $url . ' ===== '.strip_tags(strstr($a->parent(),'密码'));
        }
        return '';
    }

    public function getDName($z)
    {
        $z  = str_replace('&nbsp;','',$z);
        $z  = str_replace('　','',$z);
        if(preg_match('/[\x7f-\xff]+/', $z)){
            $pattern = '/[a-zA-Z\.]/u';
            $z = preg_replace($pattern, '', $z);
        }
        $z = trim($z);
        $z = trim($z,"\t");
        return $z;
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $f = 1;
        while ($f==1)
        {
            $f=0;
            $list = \App\Models\Piaohua::where('type',0)->where('cate','!=','dianshiju')->limit(100)->get();

            foreach ($list as $item)
            {
                echo 'getdata';
                $f=1;
                $url = 'https://www.piaohua.com'.$item->url;
                echo $url;
		$htmlurl = $url;
		echo "\n".$item->id;
                try{
                    $dom = HtmlDomParser::file_get_html($url);
                }catch (\Exception $e)
                {
                    sleep(45);
                    $dom = HtmlDomParser::file_get_html($url);
                }

                $movie_info = $dom->find(".m-text1 .txt",0);
                $img = $movie_info->find('img',0);
                $cover = '';
                if ($img)
                {
                    $cover = $img->src;
                }
                $divs = $movie_info->find("div");
                $douban = '';
                $names=[];
                $country='';
                $cates=[];
                $imdb ='';
                $duration=0;
                $tags = [];
                $niandai='';
                $downloads = [];
                $i =0;

                for ($i=0;$i<count($divs);$i++)
                {
                    $div = $divs[$i];
                    $txt = str_replace('　','',$div->plaintext);
                    $txt = trim($txt);
                    if (strstr($txt,'◎译名')){
                        $yiming = substr($txt,strlen('◎译名'));
                        $names = explode('/',$yiming);
                    }
                    if (strstr($txt,'◎年代')){
                        $yiming = substr($txt,strlen('◎年代'));
                        $niandai = $yiming;
                        if (empty($niandai)){
                            echo $item->id;
                            echo $htmlurl."\n";
                            //die('no nian dai ');
                            $niandai='';
                        }
                    }
                    if (strstr($txt,'◎片名')){
                        $yiming = substr($txt,strlen('◎片名'));
                        $names[] = $yiming;
                    }
                    if (strstr($txt,'◎产地')){
                        $yiming = substr($txt,strlen('◎产地'));
                        $country = $yiming;
                    }
                    if (strstr($txt,'◎类别')){

                        $yiming = substr($txt,strlen('◎类别'));
                        $cates = explode('/',$yiming);
                    }
                    if (strstr($txt,'◎IMDb链接')){
                        $yiming = substr($txt,strlen('◎IMDb链接'));
                        $imdb = trim($yiming,'&nbsp;');
                    }
                    if (strstr($txt,'◎豆瓣链接')){
                        $douban = substr($txt,strlen('◎豆瓣链接'));
                    }
                    if (strstr($txt,'◎片长')){
                        $yiming = substr($txt,strlen('◎片长'));
                        $duration =  $yiming;
                    }
                    if (strstr($txt,'◎标签')){
                        // echo $div;exit;
                        //echo $txt."\n";
                        $yiming = substr($txt,strlen('◎标签'));
                        $tags = explode('|',$yiming);
                    }
                    if ($dy = strstr($div->plaintext,'◎导　　演')){
                        $yiming = substr($dy,strlen('◎导　　演'));
                        $yiming  = str_replace('　','',$yiming);
                        $yiming = trim($yiming);
                        $daoyan = explode('/',$yiming);
                    }
                    if ($zz = strstr($div->plaintext,'◎主　　演')){
                        $z = substr($zz,strlen('◎主　　演'));

                        $zhuyan[] = $this->getDName($z);
                        $i++;
                        while (strstr($divs[$i]->plaintext,'	　　　　')) {
                            $z = trim($divs[$i]->plaintext);
                            $zhuyan[] =  $this->getDName($z);
                            $i++;
                        }
                        $i--;
                        continue;
                    }
                    if (strstr($txt,'◎简')){
                        $i++;
                        $t = trim($divs[$i]->plaintext);
                        $t = str_replace('&nbsp;','',$t);
                        $t = trim($t);
                        while (empty($t)) {
                            $i++;
                            $t = trim($divs[$i]->plaintext);
                            $t = str_replace('&nbsp;','',$t);
                            $t = trim($t);
                        }
                        $desc =  trim($divs[$i]->plaintext);
                    }
                }
                foreach ($dom->find("div.bot  a") as $a)
                {


                    $url = $this->getUrl($a);
                    if ($url) {
                        $downloads[] =$url;
                    }

                }
                if (empty($downloads)) {
                    foreach ($dom->find(".m-text1 .txt table a") as $a)
                    {

                        $url = $this->getUrl($a);
                        if ($url) {
                            $downloads[] =$url;
                        }
                    }
                }
                if (empty($downloads)) {
                    echo $item->id;
                    echo $htmlurl."\n";
                    $item->type=10;
                    $item->save();
                    continue;
                }

                $data = [
                    'names'=>$names,
                    'tags'=>$tags,
                    'country'=>$country,
                    'cates'=>$cates,
                    'duration'=>$duration,
                    'imdb'=>$imdb,
                    'douban'=>$douban,
                    'downloads'=>$downloads,
                    'niandai'=>$niandai,
                    'cover'=>$cover,
                    'daoyan'=>$daoyan??[],
                    'zhuyan'=>$zhuyan??[],
                    'desc'=>$desc,
                ];
                $item->detail = json_encode($data);
                $item->type=2;
                $item->save();
                print_r($data);
                echo $item->id;
                echo $htmlurl;
                sleep(1);

            }
        }

    }

}
