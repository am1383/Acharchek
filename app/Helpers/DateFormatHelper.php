<?php

namespace App\Helpers;

class DateFormatHelper
{
    private static $monthList = [
        'فروردین', 'اردیبهشت', 'خرداد', 'تیر',
        'مرداد', 'شهریور', 'مهر', 'آبان',
        'آذر', 'دی', 'بهمن', 'اسفند',
    ];

    public static function persianDateTime(string $persianDateTime): string
    {
        [$date, $time] = explode(' ', $persianDateTime);
        [$year, $month, $day] = explode('-', $date);
        [$hour, $minute] = explode(':', $time);

        $monthText = self::$monthList[(int) $month - 1];

        return "{$day} {$monthText} {$year}، ساعت {$hour}:{$minute}";
    }

    public static function persianDate(string $persianDate): string
    {
        [$year, $month, $day] = explode('-', $persianDate);
        $monthText = self::$monthList[(int) $month - 1];

        return "{$day} {$monthText} {$year}";
    }

    public static function dateTime(string $dateTime): array
    {
        $verta = verta($dateTime);
        $persianDateTime = $verta->formatDateTime();
        $persianDate = $verta->formatDate();

        return [
            'real' => $dateTime,
            'persian' => $persianDateTime,
            'pretty_persian' => self::persianDateTime($persianDateTime),
            'pp_only_date' => self::persianDate($persianDate),
            'diff_for_humans' => now()->diffForHumans($dateTime, true),
        ];
    }
}
