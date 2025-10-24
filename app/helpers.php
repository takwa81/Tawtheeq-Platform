<?php

if (!function_exists('accountStatusBadge')) {

    function accountStatusBadge(string $status): string
    {
        switch ($status) {
            case 'pending':
                $label = 'بانتظار الموافقة';
                $class = 'bg-info';
                break;
            case 'active':
                $label = 'فعال';
                $class = 'bg-success';
                break;
            case 'inactive':
                $label = 'غير فعال';
                $class = 'bg-warning';
                break;
            case 'deleted':
                $label = 'محذوف';
                $class = 'bg-danger';
                break;
            default:
                $label = 'غير معروف';
                $class = 'bg-secondary';
        }

        return "<span class='badge {$class}'>{$label}</span>";
    }
}
