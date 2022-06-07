<?php
namespace app\admin\controller\assist;
use think\facade\Request;

use baiduApi\AipImageCensor;
use baiduApi\AipNlp;
use baiduApi\AipSpeech;
// use FFMpeg\FFMpeg;


class Intelligent {

	protected $appid;
	protected $appkey;
	protected $appsecret;

	public function __construct(){
		$this->appid = config('admin.baidu.appid');
		$this->appkey = config('admin.baidu.appkey');
		$this->appsecret = config('admin.baidu.appsecret');
	}

	public function textCensor(){
		$basecontent = Request::post('content');
		$content = $this->formateContent($basecontent,1400);
		$client = new AipImageCensor($this->appid,$this->appkey,$this->appsecret);
		$textcensor = $client->textCensorUserDefined($content);

		$content = $this->formateContent($basecontent,250);
		$client = new AipNlp($this->appid,$this->appkey,$this->appsecret);
		$ecnet = $client->ecnet($content);

		return suc(['textcensor'=>$textcensor?$textcensor:true,'ecnet'=>$ecnet?$ecnet:true],'审核成功');
	}

	/*
	文字转语音 讯飞api
	 */
	public function textToAudio()
	{
		//转化内容
		$content = Request::post('content/s');
		$content = htmlspecialchars_decode($content);
		$content = str_replace('</p>', '。</p>', $content);
		$content = str_replace('&ldquo;', '', $content);
		$content = str_replace('&rdquo;', '', $content);
		$content = strip_tags($content);

	    //获取科大讯飞参数
	    $app_id = config('admin.xunfei.appid');
	    $api_key = config('admin.xunfei.apikey');
	    $api_secret = config('admin.xunfei.apisecret');

	    //文件地址
	    $date = date('Ymd');
	    $uniqid = uniqid();

	    $fileaddr = config('admin.file'). '/audio/'. $date;
	    mkdirs($fileaddr);
        $file_name = $uniqid. '.mp3';
        $web_addr = config('app.domain.file'). '/audio/'. $date. '/'. $file_name;

	    //获取链接及消息参数
	    $url = $this->createUrl($api_key, $api_secret);
	    $message = $this->createMsg($app_id, $speed=50, $volume=50, $pitch=50, $content);
	    $client = new \WebSocket\Client($url);
	    try {
	        $client->send(json_encode($message, true));
	        
	        //需要以追加的方式进行写文件
	        $audio_file = fopen($fileaddr. '/'. $file_name, 'ab');
	        $response = $client->receive();
	        $response = json_decode($response, true);
	        // 科达讯飞会分多次发送消息
	        do {
	            if ($response['code']) {
	                return $response;
	            }
	            //返回的音频需要进行base64解码
	            $audio = base64_decode($response['data']['audio']);
	            fwrite($audio_file, $audio);
	            //继续接收消息
	            $response = $client->receive();
	            $response = json_decode($response, true);
	        } while ($response['data']['status'] != 2);
	        fclose($audio_file);
	        // if (file_exists($fileaddr. '/' . $file_name)) {
	        //     //TODO 变声强度设置
	        //     exec(config('admin.ffmpeg'). ' -f s16le -ar 16000 -ac 1 -i ' . $fileaddr. '/' . $file_name . ' ' . $fileaddr. '/' . $file_name_wav);
	        // }
	        return suc($web_addr ,'合成成功');
	    } catch (Exception $e) {
	        return err($e->getMessage());
	    } finally {
	        $client->close();
	    }
	}
	/**
	* 拼接签名
	* @param $api_key
	* @param $api_secret
	* @param $time
	* @return string
	*/
	private function sign($api_key, $api_secret, $time)
	{
	    $signature_origin = 'host: ws-api.xfyun.cn' . "\n";
	    $signature_origin .= 'date: ' . $time . "\n";
	    $signature_origin .= 'GET /v2/tts HTTP/1.1';
	    $signature_sha = hash_hmac('sha256', $signature_origin, $api_secret, true);
	    $signature_sha = base64_encode($signature_sha);
	    $authorization_origin = 'api_key="' . $api_key . '", algorithm="hmac-sha256", ';
	    $authorization_origin .= 'headers="host date request-line", signature="' . $signature_sha . '"';
	    $authorization = base64_encode($authorization_origin);
	    return $authorization;
	}

	/**
	* 生成Url
	* @param $api_key
	* @param $api_secret
	* @return string
	*/
	private function createUrl($api_key, $api_secret)
	{
	    $url = 'wss://tts-api.xfyun.cn/v2/tts';
	    $time = date('D, d M Y H:i:s', strtotime('-8 hour')) . ' GMT';
	    $authorization = $this->sign($api_key, $api_secret, $time);
	    $url .= '?' . 'authorization=' . $authorization . '&date=' . urlencode($time) . '&host=ws-api.xfyun.cn';
	    return $url;
	}

	/**
	* 生成要发送的消息体
	* @param $app_id
	* @param $speed
	* @param $volume
	* @param $pitch
	* @param $draft_content
	* @return array
	*/
	private function createMsg($app_id, $speed, $volume, $pitch, $draft_content)
	{
	    return [
	        'common' => [
	            'app_id' => $app_id,
	        ],
	        'business' => [
	            'aue' => 'lame',
	            'sfl' => 1,
	            'auf' => 'audio/L16;rate=16000',
	            'vcn' => 'xiaoyan',
	            'speed' => (int)$speed,
	            'volume' => (int)$volume,
	            'pitch' => (int)$pitch,
	            'tte' => 'utf8',
	        ],
	        'data' => [
	            'status' => 2,
	            'text' => base64_encode($draft_content),
	        ],
	    ];
	}

	//************辅助
	protected function formateContent($content,$num){
		$content = htmlspecialchars_decode($content);
        $content = strip_tags($content);
        $content = $this->StringToText($content,20000);
        $textarr = $this->utf8_str_split($content,$num);
        return $textarr;
	}
	protected function StringToText($string,$num){
	    if($string){
	        //返回字符串中的前$num字符串长度的字符
	        return mb_strlen($string,'utf-8') > $num ? mb_substr($string, 0, $num, "utf-8").'....' : mb_substr($string, 0, $num, "utf-8");
	    }else{
	        return $string;
	    }
	}
	protected function utf8_str_split($str, $split_len = 1){
	    if (!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1)
	        return FALSE;
	 
	    $len = mb_strlen($str, 'UTF-8');
	    if ($len <= $split_len)
	        return array($str);
	 
	    preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);
	 
	    return $ar[0];
	}
}