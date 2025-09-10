<?php

namespace Adianti\Kasio;


use Adianti\Widget\Base\TElement;

/**
 * Grid Container simples usando Bootstrap 5
 */
class ApexChartRow extends TElement
{
  protected $charts;
  protected $columns;

  /**
   * Class Constructor
   */
  public function __construct($columns = 'col-12')
  {
    parent::__construct('div');
    $this->class = 'row g-3 mb-4'; // Bootstrap row com gap
    $this->columns = $columns;
    $this->charts = array();
  }

  /**
   * Adiciona um gráfico ao grid
   * @param $chart ApexChartContainer
   * @param $columns Colunas Bootstrap (col-12, col-md-6, col-lg-4, etc.)
   * @param $title Título opcional
   */
  public function addChart($chart, $title = null)
  {
    $this->charts[] = array(
      'chart' => $chart,
      'columns' => $this->columns,
      'title' => $title
    );
  }

  /**
   * Shows the widget at the screen
   */
  public function show()
  {
    foreach ($this->charts as $chartData) {
      // Criar coluna Bootstrap
      $col = new TElement('div');
      $col->class = $chartData['columns'];

      // Criar card Bootstrap
      $card = new TElement('div');
      $card->class = 'card h-100';

      // Card body
      $cardBody = new TElement('div');
      $cardBody->class = 'card-body p-3';

      // Adicionar título se fornecido
      if ($chartData['title']) {
        $cardTitle = new TElement('h6');
        $cardTitle->class = 'card-title text-center mb-3';
        $cardTitle->add($chartData['title']);
        $cardBody->add($cardTitle);
      }

      // Adicionar o gráfico
      $cardBody->add($chartData['chart']);

      $card->add($cardBody);
      $col->add($card);

      parent::add($col);
    }

    parent::show();
  }
}
