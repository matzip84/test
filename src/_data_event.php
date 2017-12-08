<?
// 테스트
include $_SERVER['DOCUMENT_ROOT']."/include/include_common.php";
aaaaaaaaaaaaaaaa
sssssssssssa
@extract($_dGET); 
@extract($_POST);

$seq_arr = $_REQUEST['mode'];
$num = $_REQUEST['num'];
$mode = $_REQUEST['mode'];

$image_dir = rtrim($img_dir['event'],"/");

if($mode =="file_attach"){
	
	//파일 첨부 가져옴
	if($_FILES['attach']['size'] > 2000000){
		echo json_encode(array("success"=>"false","msg"=>"exceed file limit (2MB)"));
		exit;
	}
	
	if($_FILES['attach']['tmp_name']){
		$file_name = replace_img_name($_FILES['attach']['name']);
		//파라미터:  tmp_name , 넣을 파일명 , 넣을경로(base경로/파일명) , 업로드 용량
		$img_flag = func_imgup($_FILES['attach']['tmp_name'], time()."_".$file_name,$image_dir, 2000000);
	}
	if($img_flag['flag'] =="yes"){
		echo json_encode(array("success"=>"success","img"=>IMGBASE_URL."/".$image_dir."/".$img_flag['img_url2'],"img_name"=>$img_flag['img_url2']));
		exit;
	}else{
		echo json_encode(array("success"=>"false","msg"=>"failed"));
		exit;
	}
}else if($mode =="img_del"){
	$src = $_REQUEST['src'];
	
	if($src){
		$path = $image_dir."/".$src;
		
		$return = file_unlink($path);
		
		echo json_encode(array("success"=>"Y","result"=>$return));
		exit;
	}else{
		echo json_encode(array("success"=>"N","result"=>""));
		exit;
	}
}else if($mode =="world_event"){

	if(!$event_name){
		alert_go("제목을 입력하세요 ","back","");
		exit;
	}	
	if(count($tag_name) > 0){
		$tag_name2 = implode("|", $tag_name);
	}
	
	
	$sql =  "insert into tb_koko_wall_event set ";
	$sql .= "event_name='$event_name'";
	$sql .= ", event_is_active='$event_is_active' ";
	$sql .= " , event_regidate = now()";
	$sql .= ", tag_name= '$tag_name2'";
	$sql .= ", event_start = '$event_start'";
	$sql .= ", event_end ='$event_end'";
	$sql .= ", input_date=now()";
	$sql .= ", thumbnail='$thumbnail'";
	$sql .= ", image_1='$image_1'";
	$sql .= ", image_2='$image_2'";
	$sql .= ", image_3='$image_3'";
	$sql .= ", image_4='$image_4'";
	$sql .= ", image_5='$image_5'";
	$sql .= ", image_m_1='$image_m_1'";
	$sql .= ", image_m_2='$image_m_2'";
	$sql .= ", image_m_3='$image_m_3'";
	$sql .= ", image_m_4='$image_m_4'";
	$sql .= ", image_m_5='$image_m_5'";
	$sql .= ", link='$link'";
	$sql .= ", attach_file='$attach_file'";
	$sql .= ",vod ='$vod'";
	$sql .= ", mode='$world_mode'";
	$sql .= ", lang='$lang'";


	$result = mysql_query($sql);
	$affect = mysql_affected_rows();
	
	$insert_seq = mysql_insert_id();
	
	if($affect > 0){
		alert_go("success","go","world_event_write.php?event_seq={$insert_seq}");
	}
	
}else if($mode =="world_event_modify"){
	
	if(!$event_name){
		alert_go("제목을 입력하세요 ","back","");
		exit;
	}
	if($event_seq <= 0 || !$event_seq){
		alert_go("필수값이 없습니다. ","back","");
		exit;
	}
	if(count($tag_name) > 0){
		$tag_name2 = implode("|", $tag_name);
	}
	
	
	$sql =  "update tb_koko_wall_event set ";
	$sql .= "event_name='$event_name'";
	$sql .= ", event_is_active='$event_is_active' ";
	$sql .= ", tag_name= '$tag_name2'";
	$sql .= ", event_start = '$event_start'";
	$sql .= ", event_end ='$event_end'";
	$sql .= ", input_date=now()";
	$sql .= ", thumbnail='$thumbnail'";
	$sql .= ", image_1='$image_1'";
	$sql .= ", image_2='$image_2'";
	$sql .= ", image_3='$image_3'";
	$sql .= ", image_4='$image_4'";
	$sql .= ", image_5='$image_5'";
	$sql .= ", image_m_1='$image_m_1'";
	$sql .= ", image_m_2='$image_m_2'";
	$sql .= ", image_m_3='$image_m_3'";
	$sql .= ", image_m_4='$image_m_4'";
	$sql .= ", image_m_5='$image_m_5'";
	$sql .= ", link='$link'";
	$sql .= ", attach_file='$attach_file'";
	$sql .= ",vod ='$vod'";
	$sql .= ", mode='$world_mode'";
	$sql .= ", lang='$lang'";
	$sql .=" where event_seq='$event_seq'";
//echo $sql;
	
	$result = mysql_query($sql);
	$affect = mysql_affected_rows();

	
	if($affect > 0){
		alert_go("success","go","world_event_write.php?event_seq={$event_seq}");
	}
	
}else if($mode =="event_del"){
	if(!$nm){
		alert_go("필수값이 없습니다. ","back","");
		exit;
	}
	$sql ="delete from tb_koko_wall_event where event_seq = '$nm'";
	$result = mysql_query($sql);
	
	if(mysql_affected_rows() > 0){
		echo json_encode(array("success"=>"Y","msg"=>"삭제되었습니다."));
		exit;
	}
	
}else if($mode =="event_display"){
	
}

?>