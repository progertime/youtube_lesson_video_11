<?
$arParams = [];

$arParams['EMPTY_ERROR_TEMPLATE'] = 'Не заполнено поле "#FIELD_TITLE#"';
$arParams['NOT_REG_ERROR_TEMPLATE'] = 'Не корректно заполнено поле "#FIELD_TITLE#"';
$arParams['ALL_FIELDS_VALID_ONCE'] = 'Y';
$arParams['MESSAGE_SUCCESS_TEXT'] = 'Сообщение отправлено!';
$arParams['MODE_OUT_ERRORS'] = 'every-field';
$arParams['ADD_ERROR_CLASS'] = 'Y';
$arParams['REG_LIST'] = [
	 'email' => [
			'expression'=> "/[0-9a-z]+@[a-z]/"
	 ],
	 'phone' => [
			'expression'=> "/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/"
	 ],
];

$arParams['FIELDS'] = [
	 [
			'CODE'=>'NAME',
			'TYPE'=>'input',
			'TITLE'=>'Имя',
			'IS_REQUIRED'=>'Y',
	 ],
	 [
			'CODE'=>'PHONE',
			'TITLE'=>'Телефон',
			'TYPE'=>'input',
			'VALID'=>['phone'],
	 ],
	 [
			'CODE'=>'EMAIL',
			'TITLE'=>'Email',
			'TYPE'=>'input',
			'VALID'=>['email'],
	 ],
	 [
			'CODE'=>'COUNTRY',
			'TITLE'=>'Страна',
			'TYPE'=>'select',
			'IS_REQUIRED'=>'Y',
			'VALUES'=>[
				 "RU" => 'Россия',
				 "USA"=> 'Америка',
				 "CHINA"=>'Китай'
			],
	 ],
	 [
			'CODE'=>'COMMENT',
			'TITLE'=>'Комментарий',
			'TYPE'=>'textarea',
	 ],
	 [
			'CODE'=>'AGREEMENT',
			'TITLE'=>'Согласен на обработку моих персональных данных',
			'TYPE'=>'checkbox',
	 ],
];


if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$jsonParams = [
		 'POST'=> $_POST,
	   'status'=> 'N',
	   'errors'=> [],
	   'message'=>''
	];

	$jsonParams['mode_out_errors'] = $arParams['MODE_OUT_ERRORS'];
	$jsonParams['add_error_class'] = $arParams['ADD_ERROR_CLASS'];


	foreach($arParams['FIELDS'] as $arField){
		$val = $jsonParams['POST']['FIELDS'][$arField['CODE']];
		$isValid = true;

		if(empty($val) && $arField['IS_REQUIRED'] == 'Y'){
			$ERROR_TEMPLATE = ($arField['EMPTY_ERROR_TEMPLATE']) ? $arField['EMPTY_ERROR_TEMPLATE'] : $arParams['EMPTY_ERROR_TEMPLATE'];
			$isValid = false;
		}else if(!empty($val) && is_array($arField['VALID']) && !empty($arField['VALID'])){
			foreach($arField['VALID'] as $validCode){
				if (array_key_exists($validCode, $arParams['REG_LIST']) && !preg_match($arParams['REG_LIST'][$validCode]['expression'], $val)) {
					$ERROR_TEMPLATE = ($arField['NOT_REG_ERROR_TEMPLATE']) ? $arField['NOT_REG_ERROR_TEMPLATE'] : $arParams['NOT_REG_ERROR_TEMPLATE'];
					$isValid = false;
				}
			}
		}
		if(!$isValid){
			$arReplaceMacroses = [
				 '#FIELD_TITLE#' => $arField['TITLE']
			];

			$jsonParams['errors'][$arField['CODE']] = [
				 'text' => str_replace(array_keys($arReplaceMacroses), array_values($arReplaceMacroses), $ERROR_TEMPLATE)
			];

			if($arParams['ALL_FIELDS_VALID_ONCE'] != 'Y'){
				break;
			}
		}

		unset($error);
	}

	if(empty($jsonParams['errors'])){
		$jsonParams['status'] = 'Y';
		$jsonParams['message'] = $arParams['MESSAGE_SUCCESS_TEXT'];
	}

	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($jsonParams);
	die();
}
?>