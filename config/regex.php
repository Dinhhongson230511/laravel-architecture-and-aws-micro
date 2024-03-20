<?php

return [
    'password' => '/^((?=.*?[A-Z])(?=.*?[a-z])(?=.*?\d)|(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[^a-zA-Z0-9])
        |(?=.*?[A-Z])(?=.*?\d)(?=.*?[^a-zA-Z0-9])|(?=.*?[a-z])(?=.*?\d)(?=.*?[^a-zA-Z0-9])).{8,}$/',
    'base64' => '%^[a-zA-Z0-9/+]*={0,2}$%',
    'tel_required' => 'required|min:9|max:30|regex:/^[0-9.-]*$/',
    'tel_nullable' => 'nullable|min:9|max:30|regex:/^[0-9.-]*$/',
    'number' => '/^[0-9.-]*$/',
    'email' => '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/',
    'url' => '/^https?:\/\/(www\.)?[a-zA-Z0-9\.-]+\.[a-zA-Z]{2,4}/',
];
