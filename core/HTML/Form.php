<?php

namespace Core\HTML;

class Form{
    private $data;
    public $surroung = 'p';

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    protected function surround($html){
        return "<{$this->surround}>{$html}</{$this->surround}>";
    }

    protected function getValue($index, $format = ''){


        if(is_object($this->data)){
            $value = $this->data->$index;
        }else {
            $value = isset($this->data[$index]) ? $this->data[$index] : null;
        }

        if($format == 'atk' || $format == 'def'){
            $value = (($value === "0") ? "0" : (($value === "99999") ? "?" : (($value === "10000") ? "X000" : (empty($value) ? '' : $value))));
        }

        return $value;
    }

    public function input($name, $label, $options = [])
    {
        $type = isset($options['type']) ? $options['type'] : 'text';
        $id = isset($options['id']) ? $options['id'] : '';
        $format_value = isset($options['format_value']) ? $options['format_value'] : '';

        return $this->surround(
            '<input type="'.$type.'" id="'.$id.'" name="'.$name.'" value="'.addslashes($this->getValue($name, $format_value)).'" />'
        );
    }

    public function submit($name)
    {
        return $this->surround(
            '<button type="submit" class="btn btn-primary">Envoyer</button>'
        );
    }
}