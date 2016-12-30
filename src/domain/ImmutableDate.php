<?php
class ImmutableDate {
  private $value;// DateTime
  private function __construct(DateTime $dateTime) {
    $this->value = new DateTime($dateTime->format('Y-m-d'));
  }

  public function getValue(): DateTime {
    return new DateTime($this->value->format('Y-m-d'));
  }

  public function format($str): string {
    return $this->value->format($str);
  }

  public function sub(DateInterval $dateInterval) {
    return new ImmutableDate($this->getValue()->sub($dateInterval));
  }

  public function add(DateInterval $dateInterval) {
    return new ImmutableDate($this->getValue()->add($dateInterval));
  }

  public function getTimestamp() {
    return $this->value->getTimestamp();
  }

  public function toString() {
    return $this->format('Y-m-d');
  }

  public static function createFromString($str): ImmutableDate {
    return new ImmutableDate(new DateTime($str));
  }
  public static function createFromDateTime($dateTime): ImmutableDate {
    return new ImmutableDate($dateTime);
  }
}
