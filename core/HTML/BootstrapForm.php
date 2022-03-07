<?php

namespace Core\HTML;

class BootstrapForm extends Form
{
    protected function surround($html, $class = NULL)
    {
        $c = is_null($class) ? "form-group mb-3" : $class;
        return "<div class=\"" . $c . "\">{$html}</div>";
    }

    public function input($name, $label, $options = [])
    {
        $type = isset($options['type']) ? $options['type'] : 'text';
        $format_value = isset($options['format_value']) ? $options['format_value'] : '';

        $classSurround = null;
        if ($type == 'checkbox') {
            $classSurround = 'form-group';
        }

        $label = '<label>' . $label . '</label>';
        $input = '<input class="form-control" type="' . $type . '" name="' . $name . '" value="'.htmlentities($this->getValue($name, $format_value)).'" />';

        return $this->surround($label . $input, $classSurround);
    }

    public function textarea($name, $label, $options = [])
    {
        $label = '<label>' . $label . '</label>';
        $textarea = '<textarea class="form-control" name="' . $name . '">' . $this->getValue($name) . '</textarea>';

        return $this->surround($label . $textarea);
    }

    public function select($name, $label, $options, $null = false)
    {

        $vname = $this->getValue($name);
        if($vname === '0'){
            $vname = null;
        }

        if($null) {
            $options[''] = "- Aucun -";
        }

        $label = '<label>' . $label . '</label>';
        $select = '<select class="form-control" name="' . $name . '">';
        foreach ($options as $k => $v) {
            $selected = '';
            if($k == $vname){ $selected = 'selected '; }
            $select .= "<option $selected value='$k'>$v</option>";
        }
        $select .= '</select>';

        return $this->surround($label . $select);
    }

    public function submit($name)
    {
        return $this->surround(
            '<button type="submit" class="btn btn-primary">Envoyer</button>'
        );
    }
}
