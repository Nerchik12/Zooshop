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

    'accepted' => 'Необходимо принять условие :attribute.',
    'accepted_if' => 'Необходимо принять условие :attribute, если поле :other равно :value.',
    'active_url' => 'Значение поля :attribute должно быть правильным URL адресом.',
    'after' => 'Значение поля :attribute должно быть датой позже :date.',
    'after_or_equal' => 'Значение поля :attribute должно быть датой равной или позже :date.',
    'alpha' => 'Поле :attribute может содержать только буквы.',
    'alpha_dash' => 'Поле :attribute может содержать только буквы, цифры, тире и подчеркивания.',
    'alpha_num' => 'Поле :attribute может содержать только буквы и цифры.',
    'array' => 'Поле :attribute должно быть массивом.',
    'before' => 'Значение поля :attribute должно быть датой раньше :date.',
    'before_or_equal' => 'Значение поля :attribute должно быть датой равной или ранее :date.',
    'between' => [
        'numeric' => 'Значение поля :attribute должно находиться в диапазоне от :min до :max.',
        'file' => 'Размер файла :attribute должен быть от :min до :max килобайт.',
        'string' => 'Длина строки :attribute должна составлять от :min до :max символов.',
        'array' => 'Количество элементов массива :attribute должно быть от :min до :max.',
    ],
    'boolean' => 'Поле :attribute должно иметь значение истинно или ложно.',
    'confirmed' => 'Подтверждение поля :attribute не совпадает.',
    'current_password' => 'Неверный пароль.',
    'date' => 'Значение поля :attribute должно быть правильной датой.',
    'date_equals' => 'Значение поля :attribute должно быть датой равной :date.',
    'date_format' => 'Формат даты в поле :attribute не соответствует формату :format.',
    'declined' => 'Необходимо отклонить условие :attribute.',
    'declined_if' => 'Необходимо отклонить условие :attribute, если поле :other равно :value.',
    'different' => 'Значения полей :attribute и :other должны различаться.',
    'digits' => 'Поле :attribute должно состоять ровно из :digits цифр.',
    'digits_between' => 'Поле :attribute должно состоять из количества цифр между :min и :max.',
    'dimensions' => 'Изображение :attribute имеет недопустимые размеры.',
    'distinct' => 'Поле :attribute содержит повторяющиеся значения.',
    'email' => 'Поле :attribute должно быть действительным e-mail адресом.',
    'ends_with' => 'Поле :attribute должно заканчиваться одним из значений: :values.',
    'enum' => 'Выбранное значение :attribute некорректно.',
    'exists' => 'Выбранное значение :attribute некорректно.',
    'file' => 'Поле :attribute должно быть файлом.',
    'filled' => 'Поле :attribute обязательно для заполнения.',
    'gt' => [
        'numeric' => 'Значение поля :attribute должно быть больше :value.',
        'file' => 'Размер файла :attribute должен быть больше :value килобайт.',
        'string' => 'Длина строки :attribute должна превышать :value символов.',
        'array' => 'Количество элементов массива :attribute должно быть больше :value.',
    ],
    'gte' => [
        'numeric' => 'Значение поля :attribute должно быть больше или равно :value.',
        'file' => 'Размер файла :attribute должен быть больше или равен :value килобайт.',
        'string' => 'Длина строки :attribute должна быть больше или равна :value символам.',
        'array' => 'Количество элементов массива :attribute должно быть не меньше :value.',
    ],
    'image' => 'Поле :attribute должно быть изображением.',
    'in' => 'Выбранное значение :attribute некорректно.',
    'in_array' => 'Поле :attribute отсутствует среди возможных вариантов :other.',
    'integer' => 'Поле :attribute должно быть целым числом.',
    'ip' => 'Поле :attribute должно быть валидным IP адресом.',
    'ipv4' => 'Поле :attribute должно быть валидным IPv4 адресом.',
    'ipv6' => 'Поле :attribute должно быть валидным IPv6 адресом.',
    'json' => 'Поле :attribute должно быть корректной строкой JSON формата.',
    'lt' => [
        'numeric' => 'Значение поля :attribute должно быть меньше :value.',
        'file' => 'Размер файла :attribute должен быть меньше :value килобайт.',
        'string' => 'Длина строки :attribute должна быть менее :value символов.',
        'array' => 'Количество элементов массива :attribute должно быть меньше :value.',
    ],
    'lte' => [
        'numeric' => 'Значение поля :attribute должно быть меньше или равно :value.',
        'file' => 'Размер файла :attribute должен быть меньше или равен :value килобайт.',
        'string' => 'Длина строки :attribute должна быть меньше или равна :value символам.',
        'array' => 'Количество элементов массива :attribute не должно превышать :value.',
    ],
    'mac_address' => 'Поле :attribute должно быть корректным MAC адресом.',
    'max' => [
        'numeric' => 'Значение поля :attribute не должно превышать :max.',
        'file' => 'Размер файла :attribute не должен превышать :max килобайт.',
        'string' => 'Длина строки :attribute не должна превышать :max символов.',
        'array' => 'Количество элементов массива :attribute не должно превышать :max.',
    ],
    'mimes' => 'Файл :attribute должен быть типа: :values.',
    'mimetypes' => 'Файл :attribute должен быть типа: :values.',
    'min' => [
        'numeric' => 'Минимальное значение поля :attribute составляет :min.',
        'file' => 'Размер файла :attribute должен быть минимум :min килобайт.',
        'string' => 'Длина строки :attribute должна быть минимум :min символов.',
        'array' => 'Количество элементов массива :attribute должно быть минимум :min.',
    ],
    'multiple_of' => 'Значение поля :attribute должно быть кратно числу :value.',
    'not_in' => 'Выбранное значение :attribute некорректно.',
    'not_regex' => 'Формат поля :attribute некорректен.',
    'numeric' => 'Поле :attribute должно быть числовым значением.',
    'password' => 'Пароль неверен.',
    'present' => 'Поле :attribute должно присутствовать.',
    'prohibited' => 'Запрещено заполнять поле :attribute.',
    'prohibited_if' => 'Запрещено заполнять поле :attribute, если поле :other равно :value.',
    'prohibited_unless' => 'Запрещено заполнять поле :attribute, если поле :other не входит в список :values.',
    'prohibits' => 'Присутствие поля :attribute запрещает наличие поля :other.',
    'regex' => 'Формат поля :attribute некорректен.',
    'required' => 'Обязательно заполнить поле :attribute.',
    'required_array_keys' => 'Поле :attribute должно содержать записи: :values.',
    'required_if' => 'Поле :attribute обязательно для заполнения, если поле :other равно :value.',
    'required_unless' => 'Поле :attribute обязательно для заполнения, если поле :other не входит в список :values.',
    'required_with' => 'Поле :attribute обязательно для заполнения, если присутствует хотя бы одно из полей :values.',
    'required_with_all' => 'Поле :attribute обязательно для заполнения, если присутствуют все поля :values.',
    'required_without' => 'Поле :attribute обязательно для заполнения, если ни одно из полей :values не задано.',
    'required_without_all' => 'Поле :attribute обязательно для заполнения, если ни одно из полей :values не задано.',
    'same' => 'Значения полей :attribute и :other должны совпадать.',
    'size' => [
        'numeric' => 'Значение поля :attribute должно равняться :size.',
        'file' => 'Размер файла :attribute должен быть :size килобайт.',
        'string' => 'Длина строки :attribute должна составлять :size символов.',
        'array' => 'Количество элементов массива :attribute должно быть равно :size.',
    ],
    'starts_with' => 'Поле :attribute должно начинаться с одного из значений: :values.',
    'string' => 'Поле :attribute должно быть строкой.',
    'timezone' => 'Поле :attribute должно быть верной временной зоной.',
    'unique' => 'Такое значение поля :attribute уже занято.',
    'uploaded' => 'Ошибка загрузки файла :attribute.',
    'url' => 'Поле :attribute должно быть правильным URL адресом.',
    'uuid' => 'Поле :attribute должно быть корректным UUID.',

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
