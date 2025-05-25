<?php

if (! function_exists('formatRupiah')) {
    /**
     * Format number to Indonesian Rupiah currency format.
     *
     * @param float|int|null $value
     * @return string
     */
    function formatRupiah($value)
    {
        if (is_null($value)) {
            return '-';
        }
        return 'Rp ' . number_format($value, 2, ',', '.');
    }
}
