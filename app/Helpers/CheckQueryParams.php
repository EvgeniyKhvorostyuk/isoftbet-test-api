<?php

function checkQueryParams($request, $required_params)
{
    $request_params = array_keys($request->all());
    $errors = count(array_intersect($required_params, $request_params)) !== count($required_params);

    return $errors === false ? false : array_diff($required_params, $request_params);
}