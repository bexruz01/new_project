<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Атрибут :attribute должен быть принят.',
    'accepted_if' => 'Атрибут :attribute должен быть принят, когда :other равно :value.',
    'active_url' => 'Атрибут :attribute не является допустимым URL-адресом.',
    'after' => 'Атрибут :attribute должен быть датой после :date.',
    'after_or_equal' => 'Атрибут :attribute должен быть датой после или равным :date.',
    'alpha' => 'Атрибут :attribute должен содержать только буквы.',
    'alpha_dash' => 'Атрибут :attribute должен содержать только буквы, цифры, тире и подчеркивания.',
    'alpha_num' => 'Атрибут :attribute должен содержать только буквы и цифры.',
    'array' => 'Атрибут :attribute должен быть массивом.',
    'before' => 'Атрибут :attribute должен быть предшествующей датой :date.',
    'before_or_equal' => 'Атрибут :attribute должен быть предшествующей датой или равным :date.',
    'between' => [
        'numeric' => 'Атрибут :attribute должен находиться в диапазоне от :min до :max.',
        'file' => 'Атрибут :attribute должен находиться в диапазоне от :min до :max килобайт.',
        'string' => 'Атрибут :attribute должен быть между символами :min и :max.',
        'array' => 'Атрибут :attribute должен содержать элементы между :min и :max.',
    ],
    'boolean' => 'Атрибут :attribute должен иметь значение true или false.',
    'confirmed' => 'Подтверждение атрибута :attribute не совпадает.',
    'current_password' => 'Неверный пароль.',
    'date' => 'Атрибут :attribute не является допустимой датой.',
    'date_equals' => 'Атрибут :attribute должен быть датой, равной :date.',
    'date_format' => 'Атрибут :attribute не соответствует формату :format.',
    'declined' => 'Атрибут :attribute должен быть отклонен.',
    'declined_if' => 'Атрибут :attribute должен быть отклонен, если :other равно :value.',
    'different' => 'Атрибуты :attribute и :other должны быть разными.',
    'digits' => 'Атрибут :attribute должен иметь :digits цифр.',
    'digits_between' => 'Атрибут :attribute должен иметь от :min до :max цифр.',
    'dimensions' => 'Атрибут :attribute имеет недопустимые размеры изображения.',
    'distinct' => 'Атрибут :attribute имеет повторяющееся значение.',
    'email' => 'Атрибут :attribute должен быть действительным адресом электронной почты.',
    'ends_with' => 'Атрибут :attribute должен заканчиваться одним из следующих значений: :values.',
    'enum' => 'Выбранный атрибут :attribute недопустим.',
    'exists' => 'Выбранный атрибут :attribute недопустим.',
    'file' => 'Атрибут :attribute должен быть файлом.',
    'filled' => 'Атрибут :attribute должен быть заполнен.',
    'gt' => [
        'numeric' => 'Атрибут :attribute должен быть больше, чем :value.',
        'file' => 'Атрибут :attribute должен быть больше, чем :value килобайт.',
        'string' => 'Атрибут :attribute должен быть больше, чем :value символов.',
        'array' => 'Атрибут :attribute должен быть больше, чем :value элементов.',
    ],
    'gte' => [
        'numeric' => 'Атрибут :attribute должен быть больше или равен :value.',
        'file' => 'Атрибут :attribute должен быть больше или равен :value килобайт.',
        'string' => 'Атрибут :attribute должен быть больше или равен :value символов.',
        'array' => 'Атрибут :attribute должен иметь :value элементов или больше.',
    ],
    'image' => 'Атрибут :attribute должен быть изображением.',
    'in' => 'Выбранный атрибут :attribute недопустим.',
    'in_array' => 'Значение атрибута :attribute не существует в :other.',
    'integer' => 'Атрибут :attribute должен быть целым числом.',
    'ip' => 'Атрибут :attribute должен быть действительным IP адресом.',
    'ipv4' => 'Атрибут :attribute должен быть действительным IPv4 адресом.',
    'ipv6' => 'Атрибут :attribute должен быть действительным IPv6 адресом.',
    'json' => 'Атрибут :attribute должен быть допустимой строкой JSON.',
    'lt' => [
        'numeric' => 'Атрибут :attribute должен быть меньше, чем :value.',
        'file' => 'Атрибут :attribute должен быть меньше, чем :value килобайт.',
        'string' => 'Атрибут :attribute должен быть меньше, чем :value символов.',
        'array' => 'Атрибут :attribute должен быть меньше, чем :value элементов.',
    ],
    'lte' => [
        'numeric' => 'Атрибут :attribute должен быть меньше или равен :value.',
        'file' => 'Атрибут :attribute должен быть меньше или равен :value килобайт.',
        'string' => 'Атрибут :attribute должен быть меньше или равен :value символов.',
        'array' => 'Атрибут :attribute должен содержать не более, чем :value элементов.',
    ],
    'mac_address' => 'Атрибут :attribute должен быть действительным MAC адресом.',
    'max' => [
        'numeric' => 'Атрибут :attribute не должен превышать :max.',
        'file' => 'Атрибут :attribute не должен превышать :max килобайт.',
        'string' => 'Атрибут :attribute не должен превышать :max символов.',
        'array' => 'Атрибут :attribute не должен содержать более :max элементов.',
    ],
    'mimes' => 'Атрибут :attribute должен быть файлом типа: :values.',
    'mimetypes' => 'Атрибут :attribute должен быть файлом типа: :values.',
    'min' => [
        'numeric' => 'Атрибут :attribute должен быть не менее :min.',
        'file' => 'Атрибут :attribute должен быть не менее :min килобайт.',
        'string' => 'Атрибут :attribute должен быть не менее :min символов.',
        'array' => 'Атрибут :attribute должен иметь не менее :min элементов.',
    ],
    'multiple_of' => 'Атрибут :attribute должен быть кратен :value.',
    'not_in' => 'Выбранный атрибут :attribute недопустим.',
    'not_regex' => 'Формат атрибута :attribute недопустим.',
    'numeric' => 'Атрибут :attribute должен быть числом.',
    'password' => 'Неверный пароль.',
    'present' => 'Атрибут :attribute должен присутствовать.',
    'prohibited' => 'Атрибут :attribute запрещен.',
    'prohibited_if' => 'Атрибут :attribute запрещен, если :other равно :value.',
    'prohibited_unless' => 'Атрибут :attribute запрещен, если :other находится в :values.',
    'prohibits' => 'Атрибут :attribute запрещает присутствие :other.',
    'regex' => 'Формат атрибута :attribute недопустим.',
    'required' => 'Атрибут :attribute является обязательным.',
    'required_array_keys' => 'Атрибут :attribute должен содержать вхождения из: :values.',
    'required_if' => 'Атрибут :attribute является обязательным, если :other равно :value.',
    'required_unless' => 'Атрибут :attribute является обязательным, если :other находится в :values.',
    'required_with' => 'Атрибут :attribute является обязательным, если присутствует :values.',
    'required_with_all' => 'Атрибут :attribute является обязательным, если присутствуют :values.',
    'required_without' => 'Атрибут :attribute является обязательным, если не присутствует :values.',
    'required_without_all' => 'Атрибут :attribute является обязательным, если не один из :values не присутствует.',
    'same' => 'Атрибуты :attribute и :other должны совпадать.',
    'size' => [
        'numeric' => 'Атрибут :attribute должен быть размера :size.',
        'file' => 'Атрибут :attribute должен быть :size килобайт.',
        'string' => 'Атрибут :attribute должен быть :size символов.',
        'array' => 'Атрибут :attribute должен быть :size элементов.',
    ],
    'starts_with' => 'Атрибут :attribute должен начинаться с одного из следующих значений: :values.',
    'string' => 'Атрибут :attribute должен быть строкой.',
    'timezone' => 'Атрибут :attribute должен быть действительным часовым поясом.',
    'unique' => 'Атрибут :attribute уже используется.',
    'uploaded' => 'Атрибут :attribute не удалось загрузить.',
    'url' => 'Атрибут :attribute должен быть действительным URL.',
    'uuid' => 'Атрибут :attribute должен быть действительным UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];