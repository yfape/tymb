<?php
namespace app\admin\controller\assist;

use think\facade\Db;
use think\facade\Request;

use app\admin\model\Article as ArticleModel;
use app\admin\model\ArticleContent;
use app\admin\model\ArticleCheck;
use app\admin\model\ArticleViewnum;
use app\admin\model\ArticleAudit;

class Assist {

	public function importArticle(){
		$data = Request::post();
		$start = isset($data['start'])?$data['start']:false;
		$end = isset($data['end'])?$data['end']:false;
		$baseurl = 'http://www.scdjw.com.cn/portal.php?mod=view&aid=';

		if(!$start){
			return;
		}

		if(!$end){
			$res = $this->importOne($baseurl.$start,$start);
			return suc($res);
		}
	}

	protected function importOne($url,$aid){
		$html = file_get_contents($url);
		$html = iconv("GBK", "UTF-8", $html);

		if(strpos($html,'您指定要查看的文章不存在或正在审核')){
			return false;
		}

		$title = $this->getTitle($html);
		$col = $this->getCol($html);
		$editor = $this->getEditor($html);
		$source = $this->getSource($html);
		$createdate = $this->getCreatedate($html);
		$content = htmlspecialchars($this->getContent($html));

		$artclemodel = new ArticleModel;
		$d1 = ['aid'=>$aid,'title'=>$title,'source'=>$source,'createdate'=>$createdate
			,'editor'=>$editor,'col'=>$col,'status'=>10,'style'=>1];
		$res1 = $artclemodel->replace()->save($d1);
		$res1 = $res1?true:false;

		$articleaudit = new ArticleAudit;
		$d2 =['aid'=>$aid,'auditor'=>99,'posttime'=>time()];
		$res2 = $articleaudit->replace()->save($d2);
		$res2 = $res1?true:false;

		$articlecheck = new ArticleCheck;
		$d3 = ['aid'=>$aid,'check'=>''];
		$res3 = $articlecheck->replace()->save($d3);
		$res3 = $res1?true:false;

		$articlecontent = new ArticleContent;
		$d4 = ['aid'=>$aid,'content'=>$content];
		$res4 = $articlecontent->replace()->save($d4);
		$res4 = $res1?true:false;

		$articleview = new ArticleViewnum;
		$d5 = ['aid'=>$aid,'viewnum'=>0];
		$res5 = $articleview->replace()->save($d5);
		$res5 = $res1?true:false;

		return ['code'=>200,'data'=>['main'=>$res1,'audit'=>$res2,'check'=>$res3,'content'=>$res4,'viewnum'=>$res5]];
	}

	protected function getTitle($html){
		$s = strpos($html,'<title>')+7;
		$e = strpos($html,'-',$s);
		$title = substr($html,$s,$e-$s);
		return trim($title);
	}

	protected function getCol($html){
		$s = strpos($html,'<title>')+7;
		$e = strpos($html,'-',$s)+1;
		$e1 = strpos($html,'-',$e);
		$col = substr($html,$e,$e1-$e);

		$colobj = Db::table('col')->where('col',trim($col))->find();
		if(!$colobj){
			$col = 106;
		}else{
			$col = $colobj['cid'];
		}

		return $col;
	}

	protected function getEditor($html){
		$s = strpos($html,'发布者: ')+5;
		$e = strpos($html,'>',$s)+1;
		$e1 = strpos($html,'<',$e);
		$editor = substr($html,$e,$e1-$e);

		$user = Db::table('user')->where('nickname',trim($editor))->find();
		if($user){
			$editor = $user['uid'];
		}else{
			$editor = 99;
		}

		return $editor;
	}

	protected function getSource($html){
		$s = strpos($html,'</span>来自:')+14;
		$e = strpos($html,'<',$s);
		$source = substr($html,$s,$e-$s);
		return trim($source);
	}

	protected function getCreatedate($html){
		$s = strpos($html,'<p class="xg1">')+16;
		$e = strpos($html,'<',$s)-6;
		$createdate = substr($html,$s,$e-$s);
		$createdate = strtotime($createdate);
		return $createdate;
	}

	protected function getContent($html){
		$s = strpos($html,'article_content')+18;
		$e = strpos($html,'<div class="o cl ptm pbm">',$s)-79;
		$content = substr($html,$s,$e-$s);
		$content = $this->repeatImg($content);
		return trim($content);
	}

	protected function repeatImg($content){
		if(strpos($content,'<img') === false){
			return $content;
		}

		$s = strpos($content,'<img')+4;
		$e = strpos($content,'src="',$s)+5;
		$e1 = strpos($content,'"',$e);
		$img = substr($content,$e,$e1-$e);

		$img1 = 'http://www.scdjw.com.cn/'.$img;
		if(strpos($img,'http')||strpos($img,'http')===0){
			return $content;
		}

		Assist::mkdirs(config('upload.move').'/old/');
		$filename = uniqid().'.jpg';
		$this->saveImage($img1,config('upload.move').'/old/'.$filename);
		$newimg = config('domain.file').'/old/'.$filename;

		$content = str_replace($img, $newimg, $content);
		return $content;
	}

	protected function saveImage($path, $image_name) {
	    $ch = curl_init ($path);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	    $img = curl_exec ($ch);
	    curl_close ($ch);
	    $fp = fopen($image_name,'w');//保存的文件名称用的是链接里面的名称
	    fwrite($fp, $img);
	    fclose($fp);
	}

}