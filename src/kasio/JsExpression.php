<?php

namespace Adianti\Kasio;

class JsExpression
{
  public $expression;

  public function __construct($expression)
  {
    $this->expression = $expression;
  }

  public function __toString()
  {
    return $this->expression;
  }
}
