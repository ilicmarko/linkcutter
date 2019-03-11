<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class Helper
{
    static function addScaledData(Collection $data)
    {
        $scaledData = $data;
        $max = $scaledData->max();

        foreach ($scaledData as $key => $count) {
            $scaled = round((100 * $count / $max), 2);
            $scaledData[$key] = [
                'count'     => $count,
                'scaled'    => $scaled
            ];
        }

        return $scaledData;
    }

    static function getScaledData(Collection $data, string $field)
    {
        $tmpData = $data
            ->groupBy($field)
            ->map(function ($item, $key) {
                return collect($item)->count();
            })
            ->sort()
            ->reverse();

        return self::addScaledData($tmpData);
    }

    static function getRandomDate($months)
    {
        $backwardsDays = rand($months * 30, 0);

        return \Carbon\Carbon::now()
                            ->addDays($backwardsDays)
                            ->addMinutes(rand(0, 60 * 23))
                            ->addSeconds(rand(0, 60))
                            ->toDateTimeString();
    }
}