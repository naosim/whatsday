<?php
include_once 'ImmutableDate.php';
include_once 'Holiday.php';
/*
指定日付からいろんな情報を取得する

取得できる情報:
- 曜日(英語) done
- 曜日(日本語) done
- 週の始まりの日付(日曜始まり) done
- 週の始まりの日付(月曜始まり) done
- 先月末の日付 done
- 今月末の日付 done
- 昨日の日付 done
- 明日の日付 done
- 今日が平日かどうか done
- 今日が休日かどうか done
- 今日が1日かどうか done
- 今日が月末かどうか done
- 今日が今月最初の平日かどうか done
- 今日が今月最後の平日かどうか done
- 前の平日から何日たっているか done
  - 通常1日
  - たとえば土日を挟んだら3日
*/
class WhatsDay {
  private $date;// ImmutableDate
  private $holidayRepository;
  function __construct(ImmutableDate $immutableDate, HolidayRepository $holidayRepository) {
    $this->date = $immutableDate;
    // $this->date = ImmutableDate::createFromDateTime($dateTime);
    $this->holidayRepository = $holidayRepository;
  }

  public static function createFromDateTime(DateTime $dateTime, HolidayRepository $holidayRepository): WhatsDay {
    return new WhatsDay(ImmutableDate::createFromDateTime($dateTime), $holidayRepository);
  }

  public static function createFromString(string $strDateTime, HolidayRepository $holidayRepository): WhatsDay {
    return new WhatsDay(ImmutableDate::createFromString($strDateTime), $holidayRepository);
  }

  public function getTargetDate():ImmutableDate {
    return $this->date;
  }
  public function getDay():int {
    return date('w', $this->date->getTimestamp());
  }
  public function getDayInJapanese(): string {
    return array('日', '月', '火', '水', '木', '金', '土')[$this->getDay()];
  }
  public function getDayInEnglish(): string {
    return array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'suturday')[$this->getDay()];
  }
  public function getStartDateOfThisWeekStartsSunday():ImmutableDate {
    return $this->getTargetDate()->sub(new DateInterval('P'. $this->getDay() . 'D'));
  }
  public function getStartDateOfThisWeekStartsMonday():ImmutableDate {
    $d = $this->getDay() === 0 ? 'P6D' : 'P'. ($this->getDay() - 1) . 'D';
    return $this->getTargetDate()->sub(new DateInterval($d));
  }
  public function getEndOfLastMonth():ImmutableDate {
    return ImmutableDate::createFromString($this->date->format('Y-m-0'));
  }
  public function getEndOfThisMonth():ImmutableDate {
    return ImmutableDate::createFromString($this->date->format('Y-m-t'));
  }

  public function getYesterday():ImmutableDate {
    return $this->getTargetDate()->sub(new DateInterval('P1D'));
  }

  public function getTomorrow():ImmutableDate {
    return $this->getTargetDate()->add(new DateInterval('P1D'));
  }

  public function isWorkDay(): bool {
    return !$this->isWeekend() && !$this->holidayRepository->isHoliday($this->date->getValue());
  }

  public function isNotWorkDay(): bool {
    return !$this->isWorkDay();
  }

  public function isWeekend(): bool {
    return $this->getDay() == 0 || $this->getDay() == 6;
  }

  public function isFirstOfMonth(): bool {
    return $this->date->format('d') == '01';
  }

  public function isEndOfMonth(): bool {
    return $this->date->format('d') == $this->getEndOfThisMonth()->format('d');
  }

  public function isFirstWorkDayOfMonth(): bool {
    if($this->isNotWorkDay()) {
      return false;
    }
    if($this->isFirstOfMonth()) {
      return true;
    }

    // 1日から前日までがすべて平日以外であること
    $yesterdayNum = intval($this->getYesterday()->format('d'));
    foreach(range(1, $yesterdayNum) as $d) {
      $date = WhatsDay::createFromString($this->date->format('Y-m-' . $d), $this->holidayRepository);
      if($date->isWorkDay()) {
        return false;
      }
    }
    return true;
  }

  public function isEndWorkDayOfMonth(): bool {
    if($this->isNotWorkDay()) {
      return false;
    }
    if($this->isEndOfMonth()) {
      return true;
    }

    // 翌日から末日までがすべて平日以外であること
    $tomorrowNum = intval($this->getTomorrow()->format('d'));
    $endOfMonthNum = intval($this->getEndOfThisMonth()->format('d'));
    foreach(range($tomorrowNum, $endOfMonthNum) as $d) {
      $date = WhatsDay::createFromString($this->date->format('Y-m-' . $d), $this->holidayRepository);
      if($date->isWorkDay()) {
        return false;
      }
    }
    return true;
  }

  /*
  前の平日から何日たっているか
  - だいたい前日は平日だから1を返す
  - 現在月曜日なら土日を挟むので3を返す
  - 今日が休日なら0を返す
  */
  public function numberOfDateFromLastWorkDay() {
    if($this->isNotWorkDay()) {
      return 0;
    }
    $date = new WhatsDay($this->getYesterday(), $this->holidayRepository);
    if($date->isWorkDay()) {
      return 1;
    }

    $result = 0;
    while($date->isNotWorkDay()) {
      $date = new WhatsDay($date->getYesterday(), $this->holidayRepository);
      $result++;
    }
    return $result;
  }

  public function toMap() {
    return [
      'targetDate' => $this->getTargetDate()->toString(),
      'dayInEnglish' => $this->getDayInEnglish(),
      'dayInJapanese' => $this->getDayInJapanese(),
      'endOfThisMonth' => $this->getEndOfThisMonth()->toString(),
      'startDateOfThisWeekStartsSunday' => $this->getStartDateOfThisWeekStartsSunday()->toString(),
      'startDateOfThisWeekStartsMonday' => $this->getStartDateOfThisWeekStartsMonday()->toString(),
      'endOfLastMonth' => $this->getEndOfLastMonth()->toString(),
      'yesterday' => $this->getYesterday()->toString(),
      'tomorrow' => $this->getTomorrow()->toString(),
      'isWorkDay' => $this->isWorkDay(),
      'isNotWorkDay' => $this->isNotWorkDay(),
      'isFirstOfMonth' => $this->isFirstOfMonth(),
      'isEndOfMonth' => $this->isEndOfMonth(),
      'isFirstWorkDayOfMonth' => $this->isFirstWorkDayOfMonth(),
      'isEndWorkDayOfMonth' => $this->isEndWorkDayOfMonth(),
      'numberOfDateFromLastWorkDay' => $this->numberOfDateFromLastWorkDay(),
    ];
  }
}
