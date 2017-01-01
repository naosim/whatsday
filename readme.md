WhatsDay
===
今日がどんな日なのかを返すAPI
---

## 日付情報の取得
### リクエスト
- URL: .../index.php
- メソッド: GET  

パラメータ名 | 説明
------------|-----
date        | 日付。YYYY-MM-DD。デフォルト値は当日。
holiday     | ユーザが定義する任意の祝日。カンマ区切りで複数指定可能。<br>例: 2017-01-03,2017-01-04<br>HolidayList.phpに無い祝日を設定したい場合に使う。
callback    | レスポンスをJSONPで取得したい場合に設定する。

### レスポンス
- 形式: JSON (callbackを設定した場合はJSONP)
- 階層なし

パラメータ名                     | 型           | 説明
--------------------------------|--------------|-----
targetDate                      | string(date) | 設定した日付。
dayInEnglish                    | string       | 曜日(英語)。sunday, monday...。
dayInJapanese                   | string       | 曜日(日本語)。日, 月...。
endOfThisMonth                  | string(date) | 今月の末日
startDateOfThisWeekStartsSunday | string(date) | 週の開始日(日曜始まり)
startDateOfThisWeekStartsMonday | string(date) | 週の開始日(月曜始まり)
endOfLastMonth                  | string(date) | 先月の末日
yesterday                       | string(date) | 昨日の日付
tomorrow                        | string(date) | 明日の日付
isWorkDay                       | boolean      | 平日かどうか
isNotWorkDay                    | boolean      | 平日以外かどうか
isFirstOfMonth                  | boolean      | 1日かどうか
isEndOfMonth                    | boolean      | 末日かどうか
isFirstWorkDayOfMonth           | boolean      | 今月最初の平日かどうか
isEndWorkDayOfMonth             | boolean      | 今月最後の平日かどうか
numberOfDateFromLastWorkDay     | int ( >=0 )  | 最後の平日から何日経っているか。<br>昨日が平日なら1。<br>土日を挟んでいたら3。<br>今日が祝日なら0。

※string(date): YYYY-MM-DD形式

### 補足
- サンプル: http://naosim.sakura.ne.jp/app/github/whatsday
- 設定済み祝日: [HolidayList.php](https://github.com/naosim/whatsday/blob/master/src/domain/HolidayList.php)
