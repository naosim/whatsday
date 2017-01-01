<?php
include_once 'src/domain/ImmutableDate.php';
include_once 'src/domain/WhatsDay.php';
include_once 'src/domain/Holiday.php';
include_once 'src/infra/HolidayRepositoryImpl.php';

/*
$requestMapFactory: (WhatsDay)->Map
*/
function getWhatsDay($requestMapFactory): WhatsDay {
  $targetDateTime = isset($_GET['date']) ? new DateTime($_GET['date']) : new DateTime();

  $holidayList = [];
  if(isset($_GET['holiday'])) {
    $ary = explode(',', $_GET['holiday']);
    foreach($ary as $dateString) {
      $holidayList[] = new Holiday($dateString, 'user_define');
    }
  }
  $holidayRepositoryImpl = new HolidayRepositoryImpl($holidayList);

  $w = WhatsDay::createFromDateTime($targetDateTime, $holidayRepositoryImpl);
  $json = json_encode($requestMapFactory($w));

  // JSONの場合
  if(!isset($_GET['callback'])){
    header("Content-type: application/json");
    echo $json;
    exit(0);
  }

  // JSONPの場合
  header("Content-type: application/javascript");
  $callback=$_GET['callback'];
  print <<<END
$callback($json);
END;
}
