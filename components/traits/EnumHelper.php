<?php

namespace app\components\traits;

trait EnumHelper
{
    /**
     * @return string
     */
    public function badge(): string
    {
        if (method_exists($this, 'color') && method_exists($this, 'label')) {
            return '<span class="badge badge-' . $this->color() . '">' . $this->label() . '</span>';
        }
        if (method_exists($this, 'label')) {
            return $this->label();
        }
        if (method_exists($this, 'color')) {
            return '<span class="badge badge-' . $this->color() . '">&nbsp;</span>';
        }
        return '';
    }

    /**
     * @return string
     */
    public function colorText(): string
    {
        if (method_exists($this, 'color') && method_exists($this, 'label')) {
            return '<span class="text-' . $this->color() . '">' . $this->label() . '</span>';
        }
        if (method_exists($this, 'label')) {
            return $this->label();
        }
        return '';
    }
}