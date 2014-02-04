<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\Field;


abstract class AbstractFormField
{
    protected $options;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options = array())
    {
        $this->options = $options;
    }

    /**
     * Get Options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get generation fields
     *
     * @param array $data
     * @return array
     */
    public function getGenerationFields($data = array())
    {
        $fields = array();
        foreach($this->getOptions() as $name => $parameters) {
            $fields[] = array(
                'name'    => $name,
                'type'    => $parameters['type'],
                'options' => $this->getFieldOptions($name, $parameters, $data)
            );
        }

        return $fields;
    }

    /**
     * Get field options
     *
     * @param string $name
     * @param array $parameters
     * @param array $data
     * @return array
     */
    public function getFieldOptions($name, $parameters, $data = array())
    {
        $options = isset($parameters['options']) ?
            $parameters['options'] :
            array()
        ;

        if (isset($data[$name])) {
            $transformMethodName = sprintf(
                'transform%s',
                self::camelize($parameters['type'])
            );
            $reflector = new \ReflectionClass($this);
            if($reflector->hasMethod($transformMethodName)) {
                $options['data'] = self::$transformMethodName($data[$name]);
            } else {
                $options['data'] = $data[$name];
            }

        }

        return $options;
    }

    /**
     * Returns given word as CamelCased
     *
     * Converts a word like "send_email" to "SendEmail". It
     * will remove non alphanumeric character from the word, so
     * "who's online" will be converted to "WhoSOnline"
     *
     * @access public
     * @static
     * @see variablize
     * @param    string    $word    Word to convert to camel case
     * @return string UpperCamelCasedWord
     */
    public static function camelize($word)
    {
        return str_replace(' ', '', ucwords(preg_replace('/[^A-Z^a-z^0-9]+/', ' ', $word)));
    }

    /**
     * Field type transformer (switch_checkbox)
     */
    public static function transformSwitchCheckbox($value)
    {
        return (boolean)$value;
    }

    /**
     * Field type transformer (checkbox)
     */
    public static function transformCheckbox($value)
    {
        return (boolean)$value;
    }

    /**
     * Field type transformer (text)
     */
    public static function transformText($value)
    {
        if (is_array($value)) {
            return json_encode($value);
        }

        return $value;
    }
}
