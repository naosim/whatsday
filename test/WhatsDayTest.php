<?php
include_once 'test/tool/testtool.php';
include_once 'src/domain/WhatsDay.php';
include_once 'src/infra/HolidayRepositoryImpl.php';

function act(string $date) {
  return (WhatsDay::createFromString($date, new HolidayRepositoryImpl()))->toMap();
}

$d1001 = '2016-10-01';
$d1002 = '2016-10-02';
$d1003 = '2016-10-03';


$d1201 = '2016-12-01';
$d1223 = '2016-12-23';
$d1224 = '2016-12-24';
$d1225 = '2016-12-25';
$d1226 = '2016-12-26';
$d1229 = '2016-12-29';
$d1230 = '2016-12-30';
$d1231 = '2016-12-31';

$result = [
  assert(act($d1229)['targetDate'] == '2016-12-29', '入力した日付がそのまま取れる'),
  assert(act($d1229)['dayInEnglish'] == 'thursday', '曜日(英語)が取れる'),
  assert(act($d1229)['dayInJapanese'] == '木', '曜日(日本語)が取れる'),

  assert(act($d1229)['startDateOfThisWeekStartsSunday'] == '2016-12-25', '週の始まりの日付(日曜始まり)が取れる'),
  assert(act($d1229)['startDateOfThisWeekStartsMonday'] == '2016-12-26', '週の始まりの日付(月曜始まり)が取れる'),
  assert(act($d1225)['startDateOfThisWeekStartsMonday'] == '2016-12-19', '週の始まりの日付(月曜始まり)が取れる_日曜日'),

  assert(act($d1229)['endOfLastMonth'] == '2016-11-30', '先月末'),
  assert(act($d1229)['endOfThisMonth'] == '2016-12-31', '今月末'),
  assert(act($d1229)['yesterday'] == '2016-12-28', '昨日'),
  assert(act($d1229)['tomorrow'] == '2016-12-30', '明日'),
  assert(act($d1223)['isWorkDay'] == false, '平日か？祝日'),
  assert(act($d1224)['isWorkDay'] == false, '平日か？土'),
  assert(act($d1225)['isWorkDay'] == false, '平日か？日'),
  assert(act($d1226)['isWorkDay'] == true, '平日か？日'),
  assert(act($d1229)['isWorkDay'] == true, '平日か？平日'),

  assert(act($d1223)['isNotWorkDay'] == true, '平日でないか？祝日'),
  assert(act($d1224)['isNotWorkDay'] == true, '平日でないか？土'),
  assert(act($d1225)['isNotWorkDay'] == true, '平日でないか？日'),
  assert(act($d1229)['isNotWorkDay'] == false, '平日でないか？平日'),

  assert(act($d1201)['isFirstOfMonth'] == true, '1日'),
  assert(act($d1229)['isFirstOfMonth'] == false, '1日でない'),

  assert(act($d1229)['isEndOfMonth'] == false, '12-29は末日でない'),
  assert(act($d1231)['isEndOfMonth'] == true, '12-31は末日'),

  assert(act($d1001)['isFirstWorkDayOfMonth'] == false, '10-01は最初の平日でない(土曜)'),
  assert(act($d1002)['isFirstWorkDayOfMonth'] == false, '10-02は最初の平日でない(日曜)'),
  assert(act($d1003)['isFirstWorkDayOfMonth'] == true, '10-03は最初の平日でない(土曜)'),

  assert(act($d1230)['isEndWorkDayOfMonth'] == true, '12-30は平日最終日'),
  assert(act($d1231)['isEndWorkDayOfMonth'] == false, '12-31は平日最終日でない'),

  assert(act($d1231)['numberOfDateFromLastWorkDay'] == 0, '12-31は平日でない'),
  assert(act($d1229)['numberOfDateFromLastWorkDay'] == 1, '12-29は前回の平日から1日たってる'),
  assert(act($d1226)['numberOfDateFromLastWorkDay'] == 3, '12-26は前回の平日から3日たってる' . act($d1226)['numberOfDateFromLastWorkDay']),







];//

showResult($result, 'WhatsDay');
?>
