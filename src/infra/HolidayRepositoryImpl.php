<?php
include_once 'src/domain/HolidayList.php';

class HolidayRepositoryImpl implements HolidayRepository {
  private $holidayMap = [];

  public function __construct(array $extraHolidayList = []) {

    $holidayList = (new HolidayList())->getList();
    foreach($extraHolidayList as $h) $holidayList[] = $h;
    forEach($holidayList as $holiday) {
      $y = $holiday->getYear();
      $m = $holiday->getMonth();
      $d = $holiday->getDate();
      if(!isset($this->holidayMap[$y])) {
        $this->holidayMap += array($y => []);
      }
      if(!isset($this->holidayMap[$y][$m])) {
        $this->holidayMap[$y] += array($m => []);
      }
      $this->holidayMap[$y][$m] += array($d => $holiday);
    }
  }

  public function isHoliday(DateTime $dateTime):bool {
    $y = $dateTime->format('Y');
    $m = $dateTime->format('m');
    $d = $dateTime->format('d');
    return isset($this->holidayMap[$y]) && isset($this->holidayMap[$y][$m]) && isset($this->holidayMap[$y][$m][$d]);
  }
  public function getHolidayForExist(DateTime $dateTime) {
    $y = $dateTime->format('Y');
    $m = $dateTime->format('m');
    $d = $dateTime->format('d');
    if($this->isHoliday($dateTime)) {
      return $this->holidayMap[$y][$m][$d];
    }
    throw new RuntimeException('祝日が見つかりません');
  }
}
