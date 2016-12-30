<?php
include_once 'Holiday.php';

class HolidayList {
  private $list;
  public function __construct() {
    $this->list = [
      new Holiday('2016-01-01', '元日'),
      new Holiday('2016-02-11', '建国記念の日'),
      new Holiday('2016-03-20', '春分の日'),
      new Holiday('2016-03-21', '春分の日振替休日'),
      new Holiday('2016-04-29', '昭和の日'),
      new Holiday('2016-05-03', '憲法記念日'),
      new Holiday('2016-05-04', 'みどりの日'),
      new Holiday('2016-05-05', 'こどもの日'),
      new Holiday('2016-07-18', '海の日'),
      new Holiday('2016-08-11', '山の日'),
      new Holiday('2016-09-19', '敬老の日'),
      new Holiday('2016-09-22', '秋分の日'),
      new Holiday('2016-10-10', '体育の日'),
      new Holiday('2016-11-03', '文化の日'),
      new Holiday('2016-11-23', '勤労感謝の日'),
      new Holiday('2016-12-23', '天皇誕生日'),

      new Holiday('2017-01-01', '元日'),
      new Holiday('2017-01-02', '成人の日'),
      new Holiday('2017-01-09', '元日'),
      new Holiday('2017-02-11', '建国記念の日'),
      new Holiday('2017-03-20', '春分の日'),
      new Holiday('2017-04-29', '昭和の日'),
      new Holiday('2017-05-03', '憲法記念日'),
      new Holiday('2017-05-04', 'みどりの日'),
      new Holiday('2017-05-05', 'こどもの日'),
      new Holiday('2017-07-17', '海の日'),
      new Holiday('2017-08-11', '山の日'),
      new Holiday('2017-09-18', '敬老の日'),
      new Holiday('2017-09-23', '秋分の日'),
      new Holiday('2017-10-09', '体育の日'),
      new Holiday('2017-11-03', '文化の日'),
      new Holiday('2017-11-23', '勤労感謝の日'),
      new Holiday('2017-12-23', '天皇誕生日'),
    ];
  }

  public function getList(): array {
    return $this->list;
  }
}
