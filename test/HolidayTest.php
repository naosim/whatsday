<?php
include_once 'test/tool/testtool.php';
include_once 'src/infra/HolidayRepositoryImpl.php';

$sut = new HolidayRepositoryImpl();
$d1223 = new DateTime('2016-12-23');
$d1229 = new DateTime('2016-12-29');


$result = [
  assert($sut->isHoliday($d1223) === true, '祝日'),
  assert($sut->isHoliday($d1229) === false, '平日'),
  assert($sut->getHolidayForExist($d1223)->getName() === '天皇誕生日', '天皇誕生日'),
  // assert($sut->getHolidayForExist($d1229) === false, '祝日無し例外投げる'),
];

showResult($result, 'Holiday');
?>
