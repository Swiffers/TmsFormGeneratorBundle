TmsFormGeneratorBundle Parameters Format
========================================

To generate a form, the parameters must follow a simple format.

The example bellow will display a simple text named "name"
``` php
array(
    "name" =>  "name",
    "type" => "text",
);                 
```

The example bellow will display an email text and his confirmation with some additionnal validation constraints
``` php
array(
    "name" => "email",
    "type" => "repeated",
    "parameters" => array(
        "first_options"  =>  { "label": "Adresse e-mail * :" },
        "second_options" => { "label": "Confirmez votre e-mail * :"},
        "type"           => "email",
        "required"       => true,
    ),
    "constraints" => array (
        "NotBlank" => array(),
        "Length"   => array(
            "min" => 5,
            'max' => 20,
        ),
    ),
);                 
```