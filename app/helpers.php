<?php

if (!function_exists('accountStatusBadge')) {

    function accountStatusBadge(string $status): string
    {
        switch ($status) {
            case 'pending':
                $label = __('dashboard.pending');
                $class = 'bg-info';
                break;
            case 'active':
                $label = __('dashboard.active');
                $class = 'bg-success';
                break;
            case 'inactive':
                $label = __('dashboard.inactive');
                $class = 'bg-warning';
                break;
            case 'deleted':
                $label = __('dashboard.deleted');
                $class = 'bg-danger';
                break;
            default:
                $label = __('dashboard.unknown');
                $class = 'bg-secondary';
        }

        return "<span class='badge {$class}'>{$label}</span>";
    }
}