<?php
//上傳VEDIO================================================================================================//
function upload_vedio($tmp_name,$file,$src) {
	$ftp_server = "172.104.121.210";
	$ftp_username   = "tttzcx";
	$ftp_password   =  "E7KGaiMFF5sZtxAF";
	// setup of connection
	$conn_id = ftp_connect($ftp_server) or die("could not connect to $ftp_server");
	// login
	if (@ftp_login($conn_id, $ftp_username, $ftp_password))
	{
	  echo "conectd as $ftp_username@$ftp_server\n";
	}
	else
	{
	  echo "could not connect as $ftp_username\n";
	}
	//RENAME
	$rand = mt_rand(0,9999);
	$sub_name1 = explode('.', $file);
	$sub_name = end($sub_name1);
    $ServerFilename=date("YmdHis").$rand.".".$sub_name;
    //UPLOAD
	ftp_chdir($conn_id, $src);
    ftp_put($conn_id,$ServerFilename, $tmp_name, FTP_BINARY);
    ftp_close($conn_id);
	return $ServerFilename;
	
}
//上傳檔案================================================================================================//
function upload_file($tmp_name,$file,$src) {
	$rand = mt_rand(0,9999);
	$sub_name1 = explode('.', $file);
	$sub_name = end($sub_name1);
	//$sub_name = end(explode('.', $file));
    $ServerFilename=date("YmdHis").$rand.".".$sub_name;
	$ServerFilename =$src.$ServerFilename;
	move_uploaded_file($tmp_name,$ServerFilename);//資料庫存檔儲存檔案路徑加檔案名
	return $ServerFilename;
	
}
//上傳固定檔名檔案(pdf)================================================================================================//
function upload_file2($tmp_name,$file,$src,$name) {
	
	$sub_name = end(explode('.', $file));
    $ServerFilename=$name."."."pdf";
	$ServerFilename =$src.$ServerFilename;
	move_uploaded_file($tmp_name,$ServerFilename);//資料庫存檔儲存檔案路徑加檔案名
	return $ServerFilename;
	
}
//刪除檔案================================================================================================//
function delete_file($ServerFilename) {
   if (file_exists($ServerFilename)){
			   unlink($ServerFilename);
	}
	
}
//新增新的記事本message寫入的內容================================================================================================//
function add_file($message,$file) {
	$name=date("YmdHis");
	$filename=$file.$name.".txt";//檔案名稱
	file_put_contents($filename,$message);
}
//縮圖================================================================================================//
function ImageResize($from_filename, $save_filename, $in_width, $in_height, $quality,$save_file)

{
    $allow_format = array('jpeg', 'png', 'gif');

    $sub_name = $t = '';
    // Get new dimensions
    $img_info = getimagesize($from_filename);
    $width    = $img_info['0'];
    $height   = $img_info['1'];
    $imgtype  = $img_info['2'];
    $imgtag   = $img_info['3'];
    $bits     = $img_info['bits'];
    $channels = $img_info['channels'];
    $mime     = $img_info['mime'];

    list($t, $sub_name) = explode('/', $mime);

    if ($sub_name == 'jpg') {
        $sub_name = 'jpeg';
    }


    if (!in_array($sub_name, $allow_format)) {
        return false;
    }
	
	$ServerFilename=$save_filename.".".$sub_name;
 

 //縮圖大小--------------------//
    // 取得縮在此範圍內的比例

    $percent = getResizePercent($width, $height, $in_width, $in_height);
    $new_width  = $width * $percent;
    $new_height = $height * $percent;
    // Resample
    $image_new = imagecreatetruecolor($new_width, $new_height);
	
	if ($sub_name=="jpeg"){
		//建立縮圖
		$image = imagecreatefromjpeg($from_filename);
	
		//開始縮圖
		imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	  
		imagejpeg($image_new, $save_file.$ServerFilename, $quality);
		 //釋放圖片記憶體
		imagedestroy($image_new);
		return $ServerFilename;
	}
	
	if (($sub_name=="png") or ($sub_name=="gif")){
	
		//建立縮圖
		$function_name = 'imagecreatefrom'.$sub_name;
		$image = $function_name($from_filename);
		
		// 建立背景
		$whiteBackground = imagecolorallocate($image_new, 255, 255, 255); //白色背景
		imagefill($image_new,0,0,$whiteBackground); // fill the background with white							
		
		//開始縮圖
		imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		
		
			
			
		imagejpeg($image_new, $save_file.$ServerFilename, $quality);
		 //釋放圖片記憶體
		imagedestroy($image_new);
		return $ServerFilename;
	}
     
}

function getResizePercent($source_w, $source_h, $inside_w, $inside_h)

{
    if ($source_w < $inside_w && $source_h < $inside_h) {
        return 1; // Percent = 1, 如果都比預計縮圖的小就不用縮
    }
    $w_percent = $inside_w / $source_w;
    $h_percent = $inside_h / $source_h;
    return ($w_percent > $h_percent) ? $h_percent : $w_percent;
	}
	
//刪除圖片檔案函式================================================================================================//

function deleteimg($file,$imgname){
	//$path = $_SERVER['DOCUMENT_ROOT'].$file.$imgname;
	$path1 = $file.$imgname;
	$path = realpath($path1);
	 if (file_exists($path)){
			   unlink($path);
	}
}
