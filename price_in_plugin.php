<?php
$e = &$modx->Event;
$output = "";

if ($e->name == 'OnSHKgetProductPrice') {
  
if(!empty($_POST['shk-price'])){
    $output = $_POST['shk-price'];
}
  
  $e->output($output);

}
//?>
