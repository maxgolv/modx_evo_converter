<?php 

require_once('manager/includes/config.inc.php');
require_once('manager/includes/protect.inc.php');
define('MODX_API_MODE', true);
require_once('manager/includes/document.parser.class.inc.php');
$modx = new DocumentParser;
$modx->db->connect();
$modx->getSettings();
	
  // Получаем текущие курсы валют в rss-формате с сайта www.cbr.ru 
  $content = get_content(); 
  // Разбираем содержимое, при помощи регулярных выражений 
  $pattern = "#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i"; 
  preg_match_all($pattern, $content, $out, PREG_SET_ORDER); 
  $dollar = ""; 
  $euro = ""; 
  foreach($out as $cur) 
  { 
    if($cur[2] == 840) $dollar = str_replace(",",".",$cur[4]); 
    if($cur[2] == 978) $euro   = str_replace(",",".",$cur[4]); 
  } 
  echo "Доллар - ".$dollar."<br>"; 
  echo "Евро - ".$euro."<br>"; 
  function get_content() 
  { 
    // Формируем сегодняшнюю дату 
    $date = date("d/m/Y"); 
    // Формируем ссылку 
    $link = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$date"; 
    // Загружаем HTML-страницу 
    $fd = fopen($link, "r"); 
    $text=""; 
    if (!$fd) echo "Запрашиваемая страница не найдена"; 
    else 
    { 
      // Чтение содержимого файла в переменную $text 
      while (!feof ($fd)) $text .= fgets($fd, 4096); 
    } 
    // Закрыть открытый файловый дескриптор 
    fclose ($fd); 
		return $text;

  } 


$dollar = round($dollar, 2);
$euro = round($euro, 2);

//доллар
$modx->db->query( 'UPDATE `modx_site_tmplvar_contentvalues` SET `value`= '.$dollar.' WHERE `contentid` = 1 AND `tmplvarid` = 26' );

// contentid - id шаблона; tmplvarid - id тв-параметра для курса валют (тип - text, относятся к главному шаблону). Для того, что бы тв появились в базе они должны быть заполнены, т.е. необходим ввести значение по-умолчанию. 

//евро
$modx->db->query( 'UPDATE `modx_site_tmplvar_contentvalues` SET `value`= '.$euro.' WHERE `contentid` = 1 AND `tmplvarid` = 27' );


?>
