<?php

namespace EvoUI\Support;

final class ResponsiveTableView
{
    /** @param list<string> $views */
    public static function initialView(mixed $width, array $views, int $breakpoint = 1200): ?string
    {
        if ((!is_int($width) && !is_string($width)) || $breakpoint <= 0
            || !in_array('table', $views, true) || !in_array('list', $views, true)) {
            return null;
        }

        $width = filter_var($width, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 100000]]);

        return $width === false ? null : ($width < $breakpoint ? 'list' : 'table');
    }
}
