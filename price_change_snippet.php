<?php
$vlt; //тип валюты
$price; //изначальная цена
$marge; //наценка

$output='';
$id = 1;
if($vlt=='eur'){
	$name = 'eur';
}
elseif($vlt=='usd'){
	$name = 'usd';
}
elseif($vlt=='rur'){
	echo $price;
	return false;
}


//берем значение тв с главной страницы
if(!isset($name)){
	return false;
}
if(!isset($id)||$id==''){
	$id = $modx->documentIdentifier;
}
$tv = $modx->getTemplateVar($name,'*',$id);
$output = $tv['value'];




//высчитываем курс
$price = $price * ($output * $marge);
$price = round($price, 2);

echo $price;
?>
