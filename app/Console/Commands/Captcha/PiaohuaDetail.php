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
        $z = str_replace('-','',$z);
        $z = str_replace('&nbsp;','',$z);
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
            $list = \App\Models\Piaohua::where('type',5)->where('cate','!=','dianshiju')->limit(100)->get();

            foreach ($list as $item)
            {
                echo 'getdata';
                $f=1;
                $url = 'https://www.piaohua.com'.$item->url;
//                $url = 'https://www.piaohua.com/html/juqing/2019/1220/42951.html';
//                $url = 'https://www.piaohua.com/html/dongzuo/2015/1006/30226.html';
                echo "\n".$url;
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
                    if (!strstr($cover,'http')) {
                        $cover='https://www.piaohua.com'.$cover;
                    }
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
                $daoyan = $zhuyan =[];

                if (count($divs)>4) {
                    for ($i=0;$i<count($divs);$i++)
                    {
                        $div = $divs[$i];
                        $txt = str_replace('　','',$div->plaintext);
                        $txt = str_replace('演员','主演',$txt);
                        $txt = trim($txt);

                        if ($dd = strstr($txt,'译名')){
                            $yiming = substr($dd,strlen('译名'));
                            $names = explode('/',$yiming);
                        }
                        if ($dd = strstr($txt,'年代')){
                            $yiming = substr($dd,strlen('年代'));
                            $niandai = $yiming;
                            if (empty($niandai)){
                                echo $item->id;
                                echo $htmlurl."\n";
                                //die('no nian dai ');
                                $niandai='';
                            }
                        }
                        if ($dd = strstr($txt,'片名')){
                            $yiming = substr($dd,strlen('片名'));
                            $names[] = $yiming;
                        }
                        if ($dd = strstr($txt,'产地')){
                            $yiming = substr($dd,strlen('产地'));
                            $country = $yiming;
                        }
                        if ($dd = strstr($txt,'类别')){

                            $yiming = substr($dd,strlen('类别'));
                            $cates = explode('/',$yiming);
                        }
                        if ($dd = strstr($txt,'IMDb链接')){
                            $yiming = substr($dd,strlen('IMDb链接'));
                            $imdb = trim($yiming,'&nbsp;');
                        }
                        if (strstr($txt,'豆瓣链接')){
                            $douban = substr($txt,strlen('豆瓣链接'));
                        }
                        if ($dd = strstr($txt,'片长')){
                            $yiming = substr($dd,strlen('片长'));
                            $duration =  $yiming;
                        }
                        if ($dd = strstr($txt,'标签')){
                            // echo $div;exit;
                            //echo $txt."\n";
                            $yiming = substr($dd,strlen('标签'));
                            $tags = explode('|',$yiming);
                        }
                        if (($dy = strstr($txt,'导演')) &&empty($daoyan)){
                            $yiming = substr($dy,strlen('导演'));
                            $yiming  = str_replace('　','',$yiming);
                            $yiming = trim($yiming);
                            $daoyan = explode('/',$yiming);
                        }
                        if (($zz = strstr($txt,'主演')) &&empty($zhuyan)){
                            $z = substr($zz,strlen('主演'));
                            $z = $this->getDName($z);
                            $zhuyan = [];
                            if (strstr($z,"|")) {
                                $zhuyan = explode('|',$z);
                            }else{
                                $zhuyan = explode('/',$z);
                            }

                            $i++;
                            $str = $divs[$i]->plaintext;
                            $str = str_replace('&nbsp;','',$str);
                            while (strstr($str,'	　　　　') || empty(trim($str))) {
                                $z = ($str);
                                $i++;
                                $str = $divs[$i]->plaintext;
                                $str = str_replace('&nbsp;','',$str);
                                if (empty(trim($z))){
                                    continue;
                                }
                                $zhuyan[] =  $this->getDName($z);

                            }
                            $i--;
                            continue;
                        }
                        if ($jj = strstr($txt,'简')){
                            $i++;
                            if (!isset($divs[$i])) {
                                $desc = substr($jj,strlen('简'));
                            }else{
                                $t = trim($divs[$i]->plaintext);
                                $t = str_replace('&nbsp;','',$t);
                                $t = trim($t);
                                while (empty($t)) {
                                    $i++;
                                    if (!isset($divs[$i])) break;
                                    $t = trim($divs[$i]->plaintext);
                                    $t = str_replace('&nbsp;','',$t);
                                    $t = trim($t);
                                }
                                $desc =  isset($divs[$i])?trim($divs[$i]->plaintext):$movie_info->plaintext;
                            }

                        }
                    }


                }else{
                                   $txt = $movie_info->plaintext;;
                    $lines = explode("\n",$txt);
                    $i = 0;
                    for ($i=0;$i<count($lines);$i++){


                            $div = $lines[$i];
                            $txt = str_replace('　','',$div);
                        $txt = str_replace('演员','主演',$txt);
                            $txt = trim($txt);
                            if ($dd = strstr($txt,'译名')){
                                $yiming = substr($dd,strlen('译名'));
                                $names = explode('/',$yiming);
                            }
                            if ($dd = strstr($txt,'年代')){
                                $yiming = substr($dd,strlen('年代'));
                                $niandai = $yiming;
                                if (empty($niandai)){
                                    echo $item->id;
                                    echo $htmlurl."\n";
                                    //die('no nian dai ');
                                    $niandai='';
                                }
                            }
                            if ($dd = strstr($txt,'片名')){
                                $yiming = substr($dd,strlen('片名'));
                                $names[] = $yiming;
                            }
                            if ($dd=strstr($txt,'产地')){
                                $yiming = substr($dd,strlen('产地'));
                                $country = $yiming;
                            }
                            if ($dd = strstr($txt,'类别')){

                                $yiming = substr($dd,strlen('类别'));
                                $cates = explode('/',$yiming);
                            }
                            if ($dd = strstr($txt,'IMDb链接')){
                                $yiming = substr($dd,strlen('IMDb链接'));
                                $imdb = trim($yiming,'&nbsp;');
                            }
                            if ($dd = strstr($txt,'豆瓣链接')){
                                $douban = substr($dd,strlen('豆瓣链接'));
                            }
                            if ($dd = strstr($txt,'片长')){
                                $yiming = substr($dd,strlen('片长'));
                                $duration =  $yiming;
                            }
                            if ($dd =strstr($txt,'标签')){
                                // echo $div;exit;
                                //echo $txt."\n";
                                $yiming = substr($dd,strlen('标签'));
                                $tags = explode('|',$yiming);
                            }
                            if (($dy = strstr($txt,'导演')) && empty($daoyan)){
                                $yiming = substr($dy,strlen('导演'));
                                $yiming  = str_replace('　','',$yiming);
                                $yiming = trim($yiming);
                                $daoyan = explode('/',$yiming);
                            }
                            if (($zz = strstr($txt,'主演')) &&empty($zhuyan)){
                                $z = substr($zz,strlen('主演'));
                                $zhuyan = [];
                                $z = $this->getDName($z);
                                if (strstr($z,"|")) {
                                    $zhuyan = explode('|',$z);
                                }else{
                                    $zhuyan = explode('/',$z);
                                }

                                $i++;
                                $str = $lines[$i];
                                $str = str_replace('&nbsp;','',$str);
                                while (strstr($str,'　　　　')!==false || empty(trim($str))) {
                                    $z = ($str);

                                    $i++;
                                    $str = $lines[$i];
                                    $str = str_replace('&nbsp;','',$str);
                                    if (empty(trim($z))){
                                        continue;
                                    }
                                    $zhuyan[] =  $this->getDName($z);

                                }
                                $i--;
                                continue;
                            }
                            if ($jj = strstr($txt,'简')){
                                $i++;
                                if (!isset($lines[$i])) {
                                    $desc = substr($jj,strlen('简'));
                                }else{
                                    $t = trim($lines[$i]);
                                    $t = str_replace('&nbsp;','',$t);
                                    $t = trim($t);
                                    while (empty($t)) {
                                        $i++;
                                        if (!isset($lines[$i])) break;
                                        $t = trim($lines[$i]);
                                        $t = str_replace('&nbsp;','',$t);
                                        $t = trim($t);
                                    }
                                    $desc =  trim($lines[$i]??'');
                                }

                            }

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
                    'desc'=>(isset($desc)&&$desc)?$desc:$movie_info->plaintext,
                ];
                print_r($data);
//                exit;
                $item->detail = json_encode($data);
                $item->type=2;
                $item->save();

                echo $item->id;
                echo $htmlurl;
                sleep(1);

            }
        }

    }

}
