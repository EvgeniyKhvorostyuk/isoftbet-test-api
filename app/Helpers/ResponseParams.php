<?php

function responseParams($status, $details = null)
{
    $details = !is_null($details) ? (gettype($details) === 'array' ? 'Some parameters are missing: ' . implode(', ', $details) : $details) : null;

    $response = [];

    switch ($status) {
        case 200:
            $response = [
                'status' => $status,
                'details' => is_null($details) ? 'OK' : $details,
            ];
            break;
        case 401:
            $response = [
                'status' => $status,
                'details' => is_null($details) ? 'Unauthorized' : $details,
            ];
            break;
        case 403:
            $response = [
                'status' => $status,
                'details' => is_null($details) ? 'Forbidden' : $details,
            ];
            break;
        case 404:
            $response = [
                'status' => $status,
                'details' => is_null($details) ? 'Not Found' : $details,
            ];
            break;
        case 405:
            $response = [
                'status' => $status,
                'details' => is_null($details) ? 'Method Not Allowed' : $details,
            ];
            break;
        case 422:
            $response = [
                'status' => $status,
                'details' => is_null($details) ? 'Unprocessable Entity' : $details,
            ];
            break;
        case 500:
            $response = [
                'status' => $status,
                'details' => is_null($details) ? 'Internal Server Error' : $details,
            ];
            break;
    }

    return $response;
}