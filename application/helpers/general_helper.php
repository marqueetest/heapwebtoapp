<?php 
function seo_friendly_url($str){
	$str = remove_illegal_offset($str);
	$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
	$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
	$str = strtolower( trim($str, '-') );
	return $str;
}
function remove_illegal_offset($str){
$regex = <<<'END'
/
  (
    (?: [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
    |   [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
    |   [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
    |   [\xF0-\xF7][\x80-\xBF]{3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3 
    ){1,100}                        # ...one or more times
  )
| .                                 # anything else
/x
END;
return $str = preg_replace($regex, '$1', $str);
}
function get_snippet( $str, $wordCount = 10 ) {
  return implode( 
    '', 
    array_slice( 
      preg_split(
        '/([\s,\.;\?\!]+)/', 
        $str, 
        $wordCount*2+1, 
        PREG_SPLIT_DELIM_CAPTURE
      ),
      0,
      $wordCount*2-1
    )
  );
}
function orderTotalRound($Total=0){
	$x = @explode("." , $Total);
	$y = @substr( $x[1] ,-1);
	$round_up	= round($Total*20)/20;
	$round_down = floor($Total*20)/20;
	if($y>0 && $y<=2){
		$Total = $round_down;
	}
	elseif($y>2 && $y<=4){
		$Total = $round_up;
		}
	elseif($y>5 && $y<=7){
		$Total = $round_down;
		}
	elseif($y>7 && $y<=9){
		$Total = $round_up;
	}
	return number_formate_without_comma($Total);
}
function number_formate_without_comma($value=0){
	return number_format($value, 2, '.', '');
}
function number_formate_with_comma($value=0){
	return number_format($value, 2, '.', ',');
}
function DBin($string){
	return  trim(htmlspecialchars($string,ENT_QUOTES));
}

function DBout($string){
	$string = remove_illegal_offset($string);
	$string = trim(html_entity_decode($string, ENT_QUOTES));
	return $string;
}
function getSingleColumn($filed,$qry){
	$ci =& get_instance();
	$ci->load->database();
	$res = $ci->db->query($qry);
	if(count($res->result_array())>0){
		foreach($res->result_array() as $row){
			return $row[$filed];
		}
	}
}
function check_file_exists($file){
	$file = str_replace(" ","%20",$file);
	$ch = curl_init($file);    
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
       $status = true;
    }else{
      $status = false;
    }
    curl_close($ch);
   	return $status;
	
}
function images_base_url(){
	$ci =& get_instance();
	if(get_cookie('supplier_id')>0)
		return $ci->config->item('supplier_images_base_url');
	else
		return $ci->config->item('oneapp_images_base_url');
}
function default_images_base_url(){
	$ci =& get_instance();
	return $ci->config->item('oneapp_images_base_url');
}
function supplier_images_base_url(){
	$ci =& get_instance();
	return $ci->config->item('supplier_images_base_url');
}
function getcardType($number){
    $number=preg_replace('/[^\d]/','',$number);
    if (preg_match('/^3[47][0-9]{13}$/',$number))
    {
        return 'American Express';
    }
    elseif (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',$number))
    {
        return 'Diners Club';
    }
    elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/',$number))
    {
        return 'Discover';
    }
    elseif (preg_match('/^(?:2131|1800|35\d{3})\d{11}$/',$number))
    {
        return 'JCB';
    }
    elseif (preg_match('/^5[1-5][0-9]{14}$/',$number))
    {
        return 'MasterCard';
    }
    elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/',$number))
    {
        return 'Visa';
    }
    else
    {
        return 'Unknown';
    }
}
function getcardTypeClass($card_type){
  	switch($card_type):
		case 'Visa':
			return 'visa_icon';
		break;
		case 'MasterCard':
			return 'mastercard_icon';
		break;
		case 'JCB':
			return 'jcb_icon';
		break;
		case 'Discover':
			return 'discover_icon';
		break;
		case 'Diners Club':
			return 'diners_icon';
		break;
		case 'American Express':
			return 'americanexpress_icon';
		break;
		default:
			return 'unknown_card_icon';
		break;
	endswitch;
}
function fullDateTime($data){
    if($data!=''){
		$specified_date_beg = new DateTime($data);
		return $specified_date_beg->format('j F Y | g:i A');
	}
	else
		return '';
}
function fullDate($data){
	if($data!=''){
   		$specified_date_beg = new DateTime($data);
		return $specified_date_beg->format('j F Y');
	}
	else
		return '';
}
function fullTime($data){
    if($data!=''){
		$specified_date_beg = new DateTime($data);
		return $specified_date_beg->format('g:i A');
	}
	else
		return '';
}
function fomrmatedDate($data){
	if($data!='' && $data!='0000-00-00'){
   	 	$specified_date_beg = new DateTime($data);
		return $specified_date_beg->format('m/d/Y'); 
	}
	else
		return '';
}
function standardDate($data){
	if($data!=''){
   	 	$specified_date_beg = new DateTime($data);
		return $specified_date_beg->format('Y-m-d'); 
	}
	else
		return '';
}
function current_full_url(){
    $CI =& get_instance();

    $url = $CI->config->site_url($CI->uri->uri_string());
    return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
}

function search_multiple_array($value, $key, $array) {
   foreach ($array as $k => $val) {
       if ($val[$key] == $value) {
           return $k;
       }
   }
   return null;
}
function view_next_delivery_day($days_array=array()){
	
	if($days_array!='' && count($days_array)>0){
		$ars		= @explode(",",$days_array);
		// Name to numeric
		foreach($ars as $a)
			$ar[]	= date('w',strtotime($a));
		asort($ar);
		$today	= date('w');
		$deliveryDay	= date('l', strtotime("Sunday +".min($ar)." days"));
		foreach($ar as $d)
			if($d > $today){
				$deliveryDay	= date('l', strtotime("Sunday +".$d." days"));
			break;
		}
	}
	else{
		$next_day	= date("w",strtotime("+1 day"));
		if($next_day==6 || $next_day==0)
			$deliveryDay	= "Monday";
		else
			$deliveryDay	= "Tomorrow";
	}
	return $deliveryDay;
}
function compressImage($source, $destination, $quality=75) {
	$response = @getimagesize($source);
    if ($response["mime"] == 'image/jpeg') 
        $image = @imagecreatefromjpeg($source);
	elseif ($response["mime"] == 'image/gif') 
        $image = @imagecreatefromgif($source);
	elseif ($response["mime"] == 'image/png') 
        $image = @imagecreatefrompng($source);
	
	@imagejpeg($image, $destination, $quality);

    return $destination;
}
function resizeImage($source,$destination,$width=80,$height=80,$quality=75,$crop_setting = 'landscape'){
	include_once APPPATH.'php-image-magician/php_image_magician.php';
	$destination_img = 'uploads/products_images/'.$destination;
	$source 		 = @str_replace('https://', 'http://', $source); 
	$imageLibObj 	 = new imageLib($source);
	$imageLibObj->resizeImage($width, $height, 'landscape');
	$imageLibObj->saveImage($destination_img, $quality);
	return base_url().$destination_img;
}
function getImageExtentation($mime){
	switch ($mime) { 
		case "image/gif": 
			$imageExtentation =  ".gif"; 
		break; 
		case "image/jpeg": 
			$imageExtentation =  ".jpg"; 
		break; 
		case "image/png": 
			$imageExtentation =  ".png"; 
		break; 
		case "image/bmp": 
			$imageExtentation =  ".bmp"; 
		break; 
		case "application/x-shockwave-flash": 
			$imageExtentation =  ".swf"; 
		break;
		case "image/psd": 
			$imageExtentation =  ".psd"; 
		break;
		case "image/tiff": 
			$imageExtentation =  ".tiff"; 
		break;
		case "application/octet-stream": 
			$imageExtentation =  ".jpc"; 
		break; 
		case "image/jp2": 
			$imageExtentation =  ".jp2"; 
		break;
		case "application/octet-stream": 
			$imageExtentation =  ".jpx"; 
		break; 
		case "application/octet-stream": 
			$imageExtentation =  ".jb2"; 
		break;
		case "image/iff": 
			$imageExtentation =  ".iff"; 
		break;
		case "image/vnd.wap.wbmp": 
			$imageExtentation =  ".wbmp"; 
		break; 
		case "image/xbm": 
			$imageExtentation =  ".xbm"; 
		break;
		case "image/xbm": 
			$imageExtentation =  ".xbm"; 
		break;
		case "image/webp": 
			$imageExtentation =  ".webp"; 
		break;
		case "image/vnd.microsoft.icon": 
			$imageExtentation =  ".icon"; 
		break;
		default:
			$imageExtentation = '';
		break;    
			
	} 
	return $imageExtentation;
}
function onezoo_curl($CURL_URL,$postvars){
		$ci =& get_instance();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$CURL_URL);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $ci->config->item('CURL_USER').":".$ci->config->item('CURL_PW'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$postvars);
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		return $response = json_decode($response, true);
		
}
function shorten_url( $longUrl ) {
	//$longUrl	= $invitation_link;
	$apiKey		= 'AIzaSyCxBZz0F15Wak6-fubcSMP7Ne0S7m9Hn0M';
	$postData = array('longUrl' => $longUrl);
	$jsonData = json_encode($postData);
	$curlObj = curl_init();
	curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$apiKey);
	curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curlObj, CURLOPT_HEADER, 0);
	curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
	curl_setopt($curlObj, CURLOPT_POST, 1);
	curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
	$response = curl_exec($curlObj);
	$json = json_decode($response,true);
	curl_close($curlObj);

	if($json['id'])
		$longUrl	= $json['id'];
	
	return $longUrl;
}

function tep_decrypt_impersonate($data){

	$output = '';

    if( $data != '' ) {
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'DBle23!no';
		$secret_iv = 'ChA770';

		// hash
		$key = hash('sha512', $secret_key);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha512', $secret_iv), 0, 16);

		return $output = trim(openssl_decrypt(base64_decode($data), $encrypt_method, $key, 0, $iv));

	} else {
		return '';
	}
}
?>