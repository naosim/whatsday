<?php
include_once 'ImmutableDate.php';

/*
土日以外の休日
*/
class Holiday {
  private $immutableDate;
  private $name;
  public function __construct(string $date, $name) {
    $this->immutableDate = ImmutableDate::createFromString($date);
    $this->name = $name;
  }

  public function getYear(): string {
    return $this->immutableDate->format('Y');
  }
  // zero origin
  public function getMonth(): string {
    return $this->immutableDate->format('m');
  }

  public function getDate(): string {
    return $this->immutableDate->format('d');
  }

  public function getName(): string {
    return $this->name;
  }
}


interface HolidayRepository {
  public function isHoliday(DateTime $dateTime):bool;
  public function getHolidayForExist(DateTime $dateTime);
}
