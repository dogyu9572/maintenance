<?php

if (!function_exists('dd_log')) {
    /**
     * Dump and die with log
     */
    function dd_log($data, $message = 'Debug Data')
    {
        \Log::channel('debug')->info($message, ['data' => $data]);
        dd($data);
    }
}

if (!function_exists('log_debug')) {
    /**
     * Log debug information
     */
    function log_debug($data, $message = 'Debug')
    {
        \Log::channel('debug')->info($message, ['data' => $data]);
    }
}

if (!function_exists('log_sql')) {
    /**
     * Log SQL queries
     */
    function log_sql($query, $bindings = [])
    {
        \Log::channel('sql')->info($query, ['bindings' => $bindings]);
    }
}

if (!function_exists('debug_request')) {
    /**
     * Debug request data
     */
    function debug_request()
    {
        $data = [
            'method' => request()->method(),
            'url' => request()->url(),
            'input' => request()->all(),
            'headers' => request()->headers->all(),
        ];

        log_debug($data, 'Request Debug');
        return $data;
    }
}

if (!function_exists('debug_session')) {
    /**
     * Debug session data
     */
    function debug_session()
    {
        $data = [
            'session_id' => session()->getId(),
            'data' => session()->all(),
        ];

        log_debug($data, 'Session Debug');
        return $data;
    }
}
