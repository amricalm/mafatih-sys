<?php

namespace App\Services;

class DateConverter
{
    public static $Day;
    public static $Month;
    public static $Year;

    public static function HijriToGregorian($date, $format = "YYYY/MM/DD")
    {
        self::ConstractDayMonthYear($date, $format);
        $d = intval(self::$Day);
        $m = intval(self::$Month);
        $y = intval(self::$Year);

        if ($y < 1700) {

            $jd = self::intPart((11 * $y + 3) / 30) + 354 * $y + 30 * $m - self::intPart(($m - 1) / 2) + $d + 1948440 - 385;

            if ($jd > 2299160) {
                $l = $jd + 68569;
                $n = self::intPart((4 * $l) / 146097);
                $l = $l - self::intPart((146097 * $n + 3) / 4);
                $i = self::intPart((4000 * ($l + 1)) / 1461001);
                $l = $l - self::intPart((1461 * $i) / 4) + 31;
                $j = self::intPart((80 * $l) / 2447);
                $d = $l - self::intPart((2447 * $j) / 80);
                $l = self::intPart($j / 11);
                $m = $j + 2 - 12 * $l;
                $y = 100 * ($n - 49) + $i + $l;
            } else {
                $j = $jd + 1402;
                $k = self::intPart(($j - 1) / 1461);
                $l = $j - 1461 * $k;
                $n = self::intPart(($l - 1) / 365) - self::intPart($l / 1461);
                $i = $l - 365 * $n + 30;
                $j = self::intPart((80 * $i) / 2447);
                $d = $i - self::intPart((2447 * $j) / 80);
                $i = self::intPart($j / 11);
                $m = $j + 2 - 12 * $i;
                $y = 4 * $k + $n + $i - 4716;
            }

            if ($d < 10)
                $d = "0" . $d;

            if ($m < 10)
                $m = "0" . $m;

            // return $d . "-" . $m . "-" . $y;
            return $y . "-" . $m . "-" . $d;
        } else
            return "";
    }

    public static function intPart($floatNum)
    {
        if ($floatNum < -0.0000001) {
            return ceil($floatNum - 0.0000001);
        }
        return floor($floatNum + 0.0000001);
    }

    public static function ConstractDayMonthYear($date, $format)
    {
        self::$Day = "";
        self::$Month = "";
        self::$Year = "";

        $format = strtoupper($format);
        $format_Ar = str_split($format);
        $srcDate_Ar = str_split($date);
        for ($i = 0; $i < count($format_Ar); $i++) {
            switch ($format_Ar[$i]) {
                case "D":
                    self::$Day .= $srcDate_Ar[$i];
                    break;
                case "M":
                    self::$Month .= $srcDate_Ar[$i];
                    break;
                case "Y":
                    self::$Year .= $srcDate_Ar[$i];
                    break;
            }
        }
    }

    public static function GregorianToHijri($date, $format = "YYYY/MM/DD")
    {
        self::ConstractDayMonthYear($date, $format);
        $d = intval(self::$Day);
        $m = intval(self::$Month);
        $y = intval(self::$Year);

        if ($y > 1700) {
            if (($y > 1582) || (($y == 1582) && ($m > 10)) || (($y == 1582) && ($m == 10) && ($d > 14))) {
                $jd = self::intPart((1461 * ($y + 4800 + self::intPart(($m - 14) / 12))) / 4) + self::intPart((367 * ($m - 2 - 12 * (self::intPart(($m - 14) / 12)))) / 12) - self::intPart((3 * (self::intPart(($y + 4900 + self::intPart(($m - 14) / 12)) / 100))) / 4) + $d - 32075;
            } else {
                $jd = 367 * $y - self::intPart((7 * ($y + 5001 + self::intPart(($m - 9) / 7))) / 4) + self::intPart((275 * $m) / 9) + $d + 1729777;
            }

            $l = $jd - 1948440 + 10632;
            $n = self::intPart(($l - 1) / 10631);
            $l = $l - 10631 * $n + 354;
            $j = (self::intPart((10985 - $l) / 5316)) * (self::intPart((50 * $l) / 17719)) + (self::intPart($l / 5670)) * (self::intPart((43 * $l) / 15238));
            $l = $l - (self::intPart((30 - $j) / 15)) * (self::intPart((17719 * $j) / 50)) - (self::intPart($j / 16)) * (self::intPart((15238 * $j) / 43)) + 29;
            $m = self::intPart((24 * $l) / 709);
            $d = $l - self::intPart((709 * $m) / 24);
            $y = 30 * $n + $j - 30;

            if ($d < 10)
                $d = "0" . $d;

            if ($m < 10)
                $m = "0" . $m;

            // return $d . "-" . $m . "-" . $y;
            return $y . "-" . $m . "-" . $d;
        } else
            return "";
    }
}
