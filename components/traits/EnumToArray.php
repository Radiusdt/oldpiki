<?php
namespace app\components\traits;

/**
 * Use only on enums
 */
trait EnumToArray
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function list($groupBy = null): array
    {
        $types = [];
        foreach (self::cases() as $case) {
            if (empty($groupBy)) {
                $types[$case->value] = $case->label();
            } else {
                if (!isset($types[$case->$groupBy()])) {
                    $types[$case->$groupBy()] = [];
                }
                $types[$case->$groupBy()][$case->value] = $case->label();
            }
        }
        return $types;
    }

    public static function random()
    {
        $i = array_rand(self::cases(), 1);

        return self::cases()[$i];
    }

    public static function count(): int
    {
        return count(self::cases());
    }
}
