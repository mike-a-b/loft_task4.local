<?php
    /**
     * Created by PhpStorm.
     * User: mike
     * Date: 05.09.17
     * Time: 21:27
     */
function incorrect_value(&$data, $error_msg, $code = 422)
{
    $data['error'] = $error_msg;
    echo http_response_code($code);
    exit();
}

function hashPassword(&$data)
{
//валидация паролей и шифрация с занесением в базу и возвратом результата
    $options_pass = [
        'options' => [
            'regexp' => "|[0-9A-Za-zА-Яа-я]+|uis"
        ]
    ];
    if (!filter_var($data['password'], FILTER_VALIDATE_REGEXP, $options_pass)) {
        if (mb_strlen($data['password'], 'UTF-8') < 3) {
            incorrect_value($data, "Пароль должен быть больше 3 символов и содержать только A-Za-zА-Яа-я0-9");
        }
    }
    $data['password'] = crypt($data['password'], "q2w3e4r5");
    return $data['password'];


}
