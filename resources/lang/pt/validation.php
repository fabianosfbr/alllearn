<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    |
    |
    */

    'accepted'             => 'O campo deve ser aceito.',
    'active_url'           => 'O campo não é uma URL válida.',
    'after'                => 'O campo deve ser uma data posterior a :date.',
    'after_or_equal'       => 'O campo deve ser uma data posterior ou igual a :date.',
    'alpha'                => 'O campo só pode conter letras.',
    'alpha_dash'           => 'O campo só pode conter letras, números e traços.',
    'alpha_num'            => 'O campo só pode conter letras e números.',
    'array'                => 'O campo deve ser uma matriz.',
    'before'               => 'O campo deve ser uma data anterior :date.',
    'before_or_equal'      => 'O campo deve ser uma data anterior ou igual a :date.',
    'between'              => [
        'numeric' => 'O campo deve ser entre :min e :max.',
        'file'    => 'O campo deve ser entre :min e :max kilobytes.',
        'string'  => 'O campo deve ser entre :min e :max caracteres.',
        'array'   => 'O campo deve ter entre :min e :max itens.',
    ],
    'boolean'              => 'O campo deve ser verdadeiro ou falso.',
    'confirm' => 'O campo de confirmação não confere.',
    'confirmed'            => 'O campo de confirmação não confere.',
    'date'                 => 'O campo não é uma data válida.',
    'date_equals'          => 'O campo deve ser uma data igual a :date.',
    'date_format'          => 'O campo não corresponde ao formato :format.',
    'different'            => 'Os campos e :other devem ser diferentes.',
    'digits'               => 'O campo deve ter :digits dígitos.',
    'digits_between'       => 'O campo deve ter entre :min e :max dígitos.',
    'dimensions'           => 'O campo tem dimensões de imagem inválidas.',
    'distinct'             => 'O campo campo tem um valor duplicado.',
    'email'                => 'O campo deve ser um endereço de e-mail válido.',
    'ends_with'            => 'O campo deve terminar com um dos seguintes: :values',
    'exists'               => 'O campo selecionado é inválido.',
    'file'                 => 'O campo deve ser um arquivo.',
    'filled'               => 'O campo deve ter um valor.',
    'gt' => [
        'numeric' => 'O campo deve ser maior que :value.',
        'file'    => 'O campo deve ser maior que :value kilobytes.',
        'string'  => 'O campo deve ser maior que :value caracteres.',
        'array'   => 'O campo deve conter mais de :value itens.',
    ],
    'gte' => [
        'numeric' => 'O campo deve ser maior ou igual a :value.',
        'file'    => 'O campo deve ser maior ou igual a :value kilobytes.',
        'string'  => 'O campo deve ser maior ou igual a :value caracteres.',
        'array'   => 'O campo deve conter :value itens ou mais.',
    ],
    'image'                => 'O campo deve ser uma imagem.',
    'in'                   => 'O campo selecionado é inválido.',
    'in_array'             => 'O campo não existe em :other.',
    'integer'              => 'O campo deve ser um número inteiro.',
    'ip'                   => 'O campo deve ser um endereço de IP válido.',
    'ipv4'                 => 'O campo deve ser um endereço IPv4 válido.',
    'ipv6'                 => 'O campo deve ser um endereço IPv6 válido.',
    'json'                 => 'O campo deve ser uma string JSON válida.',
    'lt' => [
        'numeric' => 'O campo deve ser menor que :value.',
        'file'    => 'O campo deve ser menor que :value kilobytes.',
        'string'  => 'O campo deve ser menor que :value caracteres.',
        'array'   => 'O campo deve conter menos de :value itens.',
    ],
    'lte' => [
        'numeric' => 'O campo deve ser menor ou igual a :value.',
        'file'    => 'O campo deve ser menor ou igual a :value kilobytes.',
        'string'  => 'O campo deve ser menor ou igual a :value caracteres.',
        'array'   => 'O campo não deve conter mais que :value itens.',
    ],
    'max' => [
        'numeric' => 'O campo não pode ser superior a :max.',
        'file'    => 'O campo não pode ser superior a :max kilobytes.',
        'string'  => 'O campo não pode ser superior a :max caracteres.',
        'array'   => 'O campo não pode ter mais do que :max itens.',
    ],
    'mimes'                => 'O campo deve ser um arquivo do tipo: :values.',
    'mimetypes'            => 'O campo deve ser um arquivo do tipo: :values.',
    'min' => [
        'numeric' => 'O campo deve ser pelo menos :min.',
        'file'    => 'O campo deve ter pelo menos :min kilobytes.',
        'string'  => 'O campo deve ter pelo menos :min caracteres.',
        'array'   => 'O campo deve ter pelo menos :min itens.',
    ],
    'not_in'               => 'O campo selecionado é inválido.',
    'multiple_of'          => 'O campo deve ser um múltiplo de :value.',
    'not_regex'            => 'O campo possui um formato inválido.',
    'numeric'              => 'O campo deve ser um número.',
    'password'             => 'A senha está incorreta.',
    'password_or_username' => 'A senha ou nome de usuário está incorreto.',
    'present'              => 'O campo deve estar presente.',
    'regex'                => 'O campo tem um formato inválido.',
    'required'             => 'O campo é obrigatório.',
    'required_if'          => 'O campo é obrigatório quando :other for :value.',
    'required_unless'      => 'O campo é obrigatório exceto quando :other for :values.',
    'required_with'        => 'O campo é obrigatório quando :values está presente.',
    'required_with_all'    => 'O campo é obrigatório quando :values está presente.',
    'required_without'     => 'O campo é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo é obrigatório quando nenhum dos :values estão presentes.',
    'prohibited'           => 'O campo é proibido.',
    'prohibited_if'        => 'O campo é proibido quando :other for :value.',
    'prohibited_unless'    => 'O campo é proibido exceto quando :other for :values.',
    'same'                 => 'Os campos e :other devem corresponder.',
    'size'                 => [
        'numeric' => 'O campo deve ser :size.',
        'file'    => 'O campo deve ser :size kilobytes.',
        'string'  => 'O campo deve ser :size caracteres.',
        'array'   => 'O campo deve conter :size itens.',
    ],
    'starts_with'          => 'O campo deve começar com um dos seguintes valores: :values',
    'string'               => 'O campo deve ser uma string.',
    'timezone'             => 'O campo deve ser uma zona válida.',
    'unique'               => 'O campo já está sendo utilizado.',
    'uploaded'             => 'Ocorreu uma falha no upload do campo :attribute.',
    'url'                  => 'O campo tem um formato inválido.',
    'uuid' => 'O campo deve ser um UUID válido.',

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

    'captcha' => 'Captcha Incorreto ...',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | El following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
