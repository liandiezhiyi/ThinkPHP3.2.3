<?php 

//删除编辑器上传的图片
 function delete_img($content){
 	//return $content;die;
	//匹配并删除图片
 	$img_path='/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/';
	$matches = array();
	preg_match_all($img_path, $content, $matches);//匹配图片路径
	
	//return $matches[1];die;
	//	循环匹配图片路径
	foreach($matches[1] as $img_url){
		
		//strpos(a,b) 匹配a字符串中是否包含b字符串 包含返回true
		if(strpos($img_url, 'emoticons')===false){
			$host = 'http://' . $_SERVER['HTTP_HOST'];
		
			$filepath = str_replace($host,'',$img_url);
			//return $filepath;
			//if($filepath == $img_url) $filepath = substr($img_url, 1);
		
			if(stripos($filepath,'ttp:') || stripos($filepath,'ttps:')== false)
			{
				
				//echo 1;
				$root = __ROOT__;
				if(strlen($root)>1){
					$imgp = str_replace($root,'.',$filepath);
				
				}
			}
			//$newimg = substr($imgp,0,strlen($imgp)-6);
			if(file_exists($imgp))
			{
				//return $imgp;
				unlink($imgp);
			}
		}

	}
 }
 
 
 //修改编辑器上传的图片
 function upimgs($infoimg,$data){
 	$img_path='/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/';
 	$matches = array();
 	$newmatches = array();
 	preg_match_all($img_path, $infoimg, $matches);
 	preg_match_all($img_path, $data, $newmatches);

 	//计算数组的差集
 	$resimg = array_diff($matches[1],$newmatches[1]);
 	//return $resimg;die;
 	if(!empty($resimg))
 	{
 	
 	
 		foreach($resimg as $img_url){
 			//strpos(a,b) 匹配a字符串中是否包含b字符串 包含返回true
 			if(strpos($img_url, 'emoticons')===false){
 				$host = 'http://' . $_SERVER['HTTP_HOST'];
 				$filepath = str_replace($host,'',$img_url);
 			//	if($filepath == $img_url) $filepath = substr($img_url, 1);
 				if(stripos($filepath,'ttp:') || stripos($filepath,'ttps:')== false)
 				{
 					$root = __ROOT__;
 					if(strlen($root)>1){
 						$imgp = str_replace($root,'.',$filepath);
 					}
 				}
 	
 				//$newimg = substr($imgp,0,strlen($imgp)-6);
 				if(file_exists($imgp))
 				{
 					//return $imgp;
 					unlink($imgp);
 				}
 			}
 	
 		}
 	
 	
 	
 	}
 }
 
?>