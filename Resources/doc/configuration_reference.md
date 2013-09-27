TmsFormGeneratorBundle Configuration Reference
==============================================

All available configuration options are listed below with their default values.

``` yaml
# app/config/config.yml

tms_form_generator:
    service:     ~ # Define your own form generator service
    constraints: ~ # List of all user defined validation constraints
```

User defined constraints
------------------------

All contraints defined in namespace \Symfony\Component\Validator\Constraints are accepted.
But you can define more contraints by adding 'constraints' configuration.

``` yaml
# app/config/config.yml

tms_form_generator:
    constraints: 
        \Your\own\namespace: [ 'YourFirstConstraint', 'YourSecondConstraint' ]
```