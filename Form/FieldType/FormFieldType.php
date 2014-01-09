<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace Tms\Bundle\FormGeneratorBundle\Form\FieldType;


class FormFieldType
{
    protected $type;
    protected $parent;
    protected $options;

    /**
     * Constructor
     *
     * @param string $type
     * @param FormFieldType $parent
     * @param array $options
     */
    public function __construct($type, FormFieldType $parent = null, $options = array())
    {
        $this->type = $type;
        $this->parent = $parent;
        $this->options = $options;
    }

    /**
     * Get Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get Parent
     *
     * @return FormFieldType
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get Options
     *
     * @return array
     */
    public function getOptions()
    {
        if (!$this->getParent()) {
            return $this->options;
        }

        return array_merge_recursive($this->getParent()->getOptions(), $this->options);
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
