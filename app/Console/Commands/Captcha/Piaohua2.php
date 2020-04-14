<?php


namespace App\Console\Commands\Captcha;


use App\Models\Actor;
use App\Models\Article;
use App\Models\ArticleActor;
use App\Models\ArticleAliase;
use App\Models\ArticleArea;
use App\Models\ArticleCate;
use App\Models\ArticleDirector;
use App\Models\ArticleDownload;
use App\Models\ArticleTag;
use App\Models\ArticleWriter;
use App\Models\Category;
use App\Models\Tag;
use Faker\Provider\Uuid;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use KubAT\PhpSimple\HtmlDomParser;

class Piaohua2 extends Command
{
    protected $signature = 'captcha:piaohua2';

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

    public function download($url,$path)
    {
//        $data = $this->http_request($url);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-FORWARDED-FOR:220.181.38.148', 'CLIENT-IP:220.181.38.148']);
        $header=[
            'Cookie:ll="118282"; bid=vki26dkFPvw; _pk_id.100001.4cf6=755dbb7ab0c6c5d1.1586822201.3.1586833532.1586826199.; __utma=30149280.299594622.1586822202.1586826126.1586832878.3; __utmc=30149280; __utmz=30149280.1586822202.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utma=223695111.774689596.1586822202.1586826131.1586832878.3; __utmc=223695111; __utmz=223695111.1586822202.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); _vwo_uuid_v2=D38CFD9F00C564B5762C5194FB867CEE9|4f33f85989667085e5543b4976313228; _pk_ses.100001.4cf6=*; ap_v=0,6.0; __utmb=30149280.0.10.1586832878; __utmb=223695111.0.10.1586832878',
            'Host: movie.douban.com',
            'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0'
        ];
        $curl = curl_init();
        if(!empty($header)){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
//            curl_setopt($curl, CURLOPT_HEADER, 0);//返回response头部信息
        }
        $data = curl_exec($ch);
        curl_close($ch);

        //$data = file_get_contents($url);
        $tmp = explode('.',$url);
        $uuid = Uuid::uuid().'.jpg';
        $downloaded_file = $path."/".$uuid;
//        $downloaded_file = fopen($path."/".$uuid, 'w');
//        fwrite($downloaded_file, $data);
//        fclose($downloaded_file);
        sleep(1);
        Storage::disk('public')->put($downloaded_file, $data);
        $path = Storage::url($downloaded_file);
        return $path;
    }

    public function http_request($url, $data = null, $header = null){

        $header=[
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Cookie:ll="118282"; bid=vki26dkFPvw; _pk_id.100001.4cf6=755dbb7ab0c6c5d1.1586822201.3.1586833532.1586826199.; __utma=30149280.299594622.1586822202.1586826126.1586832878.3; __utmc=30149280; __utmz=30149280.1586822202.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utma=223695111.774689596.1586822202.1586826131.1586832878.3; __utmc=223695111; __utmz=223695111.1586822202.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); _vwo_uuid_v2=D38CFD9F00C564B5762C5194FB867CEE9|4f33f85989667085e5543b4976313228; _pk_ses.100001.4cf6=*; ap_v=0,6.0; __utmb=30149280.0.10.1586832878; __utmb=223695111.0.10.1586832878',
            'Host: movie.douban.com',
            'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0'
        ];
        $curl = curl_init();
        if(!empty($header)){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_HEADER, 0);//返回response头部信息
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-FORWARDED-FOR:220.181.38.148', 'CLIENT-IP:220.181.38.148']);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_HTTPGET, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($data));
        }
//        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
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
            $list = \App\Models\Piaohua::where('type',2)
                ->where('cate','!=','dianshiju')
                ->where('cate','!=','lianxiju')
                ->where('type',2)
//                ->where('id',14244)
                ->orderBy(\DB::raw('RAND()'))
                ->limit(10)->get();

            foreach ($list as $item)
            {
                $movie = [];
                $detail = json_decode($item->detail,true);
                if (!$detail)continue;
                $url =$detail['douban'];
                $f=1;





		        echo "\n".$item->id."\n";
                print_r($item);
                print_r($detail);
                //echo $url;;
                if (empty($url)) continue;
                $url = str_replace('&bnsp;','',$url);
                $url = str_replace('&nbsp;','',$url);
                $url = trim($url);
                $url = str_replace('http:','https:',$url);
                if (substr($url,-1)!='/') {
                    $url .= '/';
                }
                //echo '--'.$url;exit;

//                try{
//                    $dom = HtmlDomParser::file_get_html($url);
//                }catch (\Exception $e)
//                {
//                    sleep(15);
//                    $dom = HtmlDomParser::file_get_html($url);
//                }
                try{
                    $string = $this->http_request($url);
                }catch (\Exception $e)
                {
                    sleep(15);
                    $string = $this->http_request($url);
                }
                $dom = HtmlDomParser::str_get_html($string);

                $small_cover = $dom->find(".nbgnbg img",0);

                $small_cover = $small_cover->src;
                //$small_cover = $item->cover;
                $small_cover = str_replace('webp','jpg',$small_cover);
                $small = $this->download($small_cover,'images/cover');
                $movie['thumb'] = $small;
                $cover = str_replace('s_ratio_poster','l',$small_cover);
                $cover = $this->download($cover,'images/cover');
                $movie['cover'] = $cover;

                $title = $dom->find("span[property=v:itemreviewed]",0);
                if (!$title) {
                    $title = $dom->find("span[property=v:itemreviewed]",0);
                }
                $title = $title->plaintext;
                $movie['title'] = $title;
                $desc = $dom->find("#link-report .all.hidden",0);
                if (!$desc){
                    $desc = $dom->find("#link-report",0);
                }
                if ($desc)
                {
                    $desc = $desc->plaintext;
                }
                else{
                    $desc = '';
                }
                $movie['desc'] = trim($desc);
                $info = $dom->find("#info",0)->nodes;


                for ($i=0;$i<count($info);$i++)
                {
                    $div = $info[$i];

                    $txt =  $div->plaintext;
                    $txt = str_replace(' ','',$txt);
                    if (strstr($txt,'导演:'))
                    {
                        $movie['daoyan'] = substr($txt,strlen('导演:'));
                    }
                    elseif (strstr($txt,'编剧:'))
                    {
                        $movie['bianju'] = substr($txt,strlen('编剧:'));
                    }
                    elseif (strstr($txt,'主演:'))
                    {
                        $zhuyan = substr($txt,strlen('主演:'));
                        $movie['zhuyan'] = explode("/",$zhuyan);
                    }

                    elseif (strstr($txt,'类型')) {
                    $cate = [];
                        $i++;
                        $txt = trim($info[$i]->plaintext);

                        while(!strstr($txt,'地区') && !strstr($txt,'官方')&& $info[$i]->class!='pl') {

                            if ($txt && $txt!='/')
                            {
                                $cate[]=$txt;
                            }
                            $i++;
                            $txt = trim($info[$i]->plaintext);
                        }
                        $movie['cate'] = $cate;
                        $i--;
                    }
                    elseif (strstr($txt,'地区')) {
                        $i++;
                        while (trim($info[$i]->plaintext) == '') {
                            $i++;
                        }
                        $movie['area'] =  trim($info[$i]->plaintext);
                    }
                    elseif (strstr($txt,'语言')) {
                        $i++;
                        while (trim($info[$i]->plaintext) == '') {
                            $i++;
                        }
                        $movie['language'] =  trim($info[$i]->plaintext);
                    }
                    elseif (strstr($txt,'上映')) {
                        $i++;
                        while (trim($info[$i]->plaintext) == '') {
                            $i++;
                        }
                        $movie['release'] =  trim($info[$i]->plaintext);
                    }
                    elseif (strstr($txt,'片长')) {
                        $i++;
                        while (trim($info[$i]->plaintext) == '') {
                            $i++;
                        }
                        $movie['duration'] =  trim($info[$i]->plaintext);
                    }
                    elseif (strstr($txt,'又名')) {
                        $i++;
                        while (trim($info[$i]->plaintext) == '') {
                            $i++;
                        }
                        $movie['alias'] =  explode("/",trim($info[$i]->plaintext));
                    }
                    elseif (strstr($txt,'IMDb')) {
                        $i++;
                        while (trim($info[$i]->plaintext) == '') {
                            $i++;
                        }
                        $movie['imdb'] =  trim($info[$i]->plaintext);
                    }
                }
                $movie['imdb'] = $movie['imdb']??$detail['imdb']??'';
                $movie['tags'] = $detail['tags'];
                foreach ($detail['names'] as $name)
                {
                    if (is_array($name)) {
                        foreach ($name as $n){
                            $movie['alias'][] = $n;
                        }
                    }else{
                        $movie['alias'][] = $name;
                    }
                }
                $movie['downloads'] = $detail['downloads'];
                print_r($item);
                print_r($movie);
                //exit;
                $article = new Article();
                $article->title = $movie['title'];
                $article->html = $movie['desc'];
                $article->markdown = $movie['desc'];
                $article->release_time = $movie['release'];
                $article->cover = $movie['cover'];
                $article->thumb = $movie['thumb'];
                $article->language = $movie['language'];
                $article->duration = $movie['duration']??0;
                $article->imdb = $movie['imdb'];
                $article->slug = $movie['title'];
                $article->save();
                $item->artice_id=$article->id;
                $item->save();
                //daoyan
                $actor = Actor::where('name',$movie['daoyan'])->first();
                if (!$actor){
                    $actor = new Actor();
                    $actor->name=$movie['daoyan'];
                    $actor->save();
                }
                if (!ArticleDirector::where('article_id',$article->id)->where('actor_id',$actor->id)->first()){
                    $ad = new ArticleDirector();
                    $ad->article_id = $article->id;
                    $ad->actor_id = $actor->id;
                    $ad->save();
                }
                //bianju
                if(isset($movie['bianju']))
                {
                    $actor = Actor::where('name',$movie['bianju'])->first();
                    if (!$actor){
                        $actor = new Actor();
                        $actor->name=$movie['bianju'];
                        $actor->save();
                    }
                    if (!ArticleWriter::where('article_id',$article->id)->where('actor_id',$actor->id)->first()){
                        $ad = new ArticleWriter();
                        $ad->article_id = $article->id;
                        $ad->actor_id = $actor->id;
                        $ad->save();
                    }
                }
                if (isset($movie['zhuyan'] )) {
                    foreach ($movie['zhuyan'] as $zhuyan) {
                        $actor = Actor::where('name',$zhuyan)->first();
                        if (!$actor){
                            $actor = new Actor();
                            $actor->name=$zhuyan;
                            $actor->save();
                        }
                        if (!ArticleActor::where('article_id',$article->id)->where('actor_id',$actor->id)->first()){
                            $ad = new ArticleActor();
                            $ad->article_id = $article->id;
                            $ad->actor_id = $actor->id;
                            $ad->save();
                        }
                    }
                }

                //cate
                foreach ($movie['cate'] as $cate) {
                    $actor = Category::where('name',$cate)->first();
                    if (!$actor){
                        $actor = new Category();
                        $actor->name=$cate;
                        $actor->save();
                    }
                    if (!ArticleCate::where('article_id',$article->id)->where('category_id',$actor->id)->first()){
                        $ad = new ArticleCate();
                        $ad->article_id = $article->id;
                        $ad->category_id = $actor->id;
                        $ad->save();
                    }
                }
                //area
                $aa = ArticleArea::where('title',$movie['area'])->where('article_id',$article->id)->first();
                if (!$aa){
                    $aa = new ArticleArea();
                    $aa->title=$movie['area'];
                    $aa->article_id=$item->id;
                    $aa->save();
                }
                //tag
                foreach ($movie['tags'] as $tag) {
                    $actor = Tag::where('name',$tag)->first();
                    if (!$actor){
                        $actor = new Tag();
                        $actor->name=$tag;
                        $actor->slug=$tag;
                        $actor->save();
                    }
                    if (!ArticleTag::where('article_id',$article->id)->where('tag_id',$actor->id)->first()){
                        $ad = new ArticleTag();
                        $ad->article_id = $article->id;
                        $ad->tag_id = $actor->id;
                        $ad->save();
                    }
                }
                //alias
                foreach ($movie['alias'] as $title) {
                    if (!ArticleAliase::where('article_id',$article->id)->where('title',$title)->first()){
                        $ad = new ArticleAliase();
                        $ad->article_id = $article->id;
                        $ad->title = $title;
                        $ad->save();
                    }
                }
                //download
                foreach ($movie['downloads'] as $url) {
                    if (!ArticleDownload::where('article_id',$article->id)->where('url',$url)->first()){
                        $ad = new ArticleDownload();
                        $ad->article_id = $article->id;
                        $ad->url = $url;
                        $ad->site = 'piaohua';
                        $ad->save();
                    }
                }
                echo "end\n";
                $item->type=3;
                $item->save();
                sleep(5);



            }
        }

    }

}
