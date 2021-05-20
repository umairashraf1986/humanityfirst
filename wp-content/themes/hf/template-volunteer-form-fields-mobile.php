<?php
/*
*
* Template Name: Volunteer form fields Mobile (REST API)
*
*/

$final_arr=array();
$models = Ninja_Forms()->form( 2 )->get_fields();

$textTypes = array('firstname','lastname','address','city','zip','phone');
$selectTypes = array('listselect','liststate');
$skippedFeilds = array('volunteer_password','volunteer_password_confirm','volunteer_other','submit','recaptcha');
$i=0;

if(!empty($models) && is_array($models)){
	foreach ($models as $key => $form) {
		$settingsArr = $form->get_settings();
		if((!empty($settingsArr['key']) && !in_array($settingsArr['key'], $skippedFeilds)) && (!empty($settingsArr['type']) && !in_array($settingsArr['type'], $skippedFeilds))){
			$final_arr[$i]['label'] =	!empty($settingsArr['label']) ? $settingsArr['label'] : '';
			$final_arr[$i]['key'] 	=	!empty($settingsArr['key']) ? $settingsArr['key'] : '';

			$type = !empty($settingsArr['type']) ? $settingsArr['type'] : '';
			if(in_array($type, $textTypes)){
				$type = 'textbox';
			}else if(in_array($type, $selectTypes)){
				$type = 'listselect';
			}
			$final_arr[$i]['type'] =	$type;
			if($type == 'listradio' || $type == 'listselect' || $type == 'listcheckbox'){
				if(!empty($settingsArr['options']) && is_array($settingsArr['options'])){
					foreach ($settingsArr['options'] as $key => $option) {
						$label	=	!empty($option["label"]) ? $option["label"] : '';
						$value	=	!empty($option["value"]) ? $option["value"] : '';
						$final_arr[$i]['options'][] =  array(
							'label' => $label,
							'value' => $value
						);
					}
				}
			}
			$i++;
		}
	}
}
header('Content-Type: application/json');
echo json_encode($final_arr, JSON_PRETTY_PRINT);
exit;
?>