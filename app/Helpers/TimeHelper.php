<?php

class TimeHelper
{
    public static function translateSeconds(int $seconds): string
    {
        return match (true) {
            $seconds >= 7200 => round($seconds / 3600).' ساعت',
            $seconds >= 120 => round($seconds / 60).' دقیقه',
            default => $seconds.' ثانیه',
        };
    }
}
