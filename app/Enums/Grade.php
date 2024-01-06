<?php

namespace App\Enums;

class Grade extends Enum
{
    const Kindergarten = "K";
    const First = "1";
    const Second = "2";
    const Third = "3";
    const Fourth = "4";
    const Fifth = "5";
    const Sixth = "6";
    const Seventh = "7";
    const Eighth = "8";
    const Nineth = "9";
    const Tenth = "10";
    const Eleventh = "11";
    const Twelfth = "12";

    /**
     * Get the grades as pairs of [value, label].
     * @return array<int, array<int, string>>
     */
    public static function asPairs()
    {
        return [
            ["K", "Kindergarten"],
            ["1", "1st"],
            ["2", "2nd"],
            ["3", "3rd"],
            ["4", "4th"],
            ["5", "5th"],
            ["6", "6th"],
            ["7", "7th"],
            ["8", "8th"],
            ["9", "9th"],
            ["10", "10th"],
            ["11", "11th"],
            ["12", "12th"],
        ];
    }
}
