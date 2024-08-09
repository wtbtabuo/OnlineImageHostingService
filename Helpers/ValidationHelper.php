<?php

namespace Helpers;

class ValidationHelper
{
    public static function integer($value, float $min = -INF, float $max = INF): int
    {
        // PHPには、データを検証する組み込み関数があります。詳細は https://www.php.net/manual/en/filter.filters.validate.php を参照ください。
        $value = filter_var($value, FILTER_VALIDATE_INT, ["min_range" => (int) $min, "max_range"=>(int) $max]);

        // 結果がfalseの場合、フィルターは失敗したことになります。
        if ($value === false) throw new \InvalidArgumentException("The provided value is not a valid integer.");

        // 値がすべてのチェックをパスしたら、そのまま返します。
        return $value;
    }

    public static function string($value, int $minLength = 0, int $maxLength = PHP_INT_MAX): string
    {
        // 値が文字列であることを確認します
        if (!is_string($value)) {
            throw new \InvalidArgumentException("The provided value is not a valid string.");
        }

        // 文字列の長さを確認します
        $length = strlen($value);
        if ($length < $minLength || $length > $maxLength) {
            throw new \InvalidArgumentException("The string length is not within the allowed range.");
        }

        // 値がすべてのチェックをパスしたら、そのまま返します。
        return $value;
    }
}