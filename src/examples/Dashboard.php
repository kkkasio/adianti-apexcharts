<?php


class Dashboard extends TPage
{

  public function __construct()
  {
    parent::__construct();

    $container = new TElement('div');
    $container->class = 'container-fluid';

    //return a custom data
    $data = $this->getData();

    $row2 = ChartLayouts::double();

    // Gráfico de Barras
    $chart1 = new ApexChartContainer('bar');
    $chart1->setCategories(['Produto A', 'Produto B', 'Produto C']);
    $chart1->addSeries('Vendas', [120, 98, 86]);

    // Gráfico Donut
    $chart2 = new ApexChartContainer('donut');
    $chart2->addSeries('Title', array_column($data['total_by_status'], 'total'));
    $chart2->setConfig([
      'labels' => array_column($data['total_by_status'], 'status'),
    ]);

    $chart2->setTitle('Questões por Status');

    // Adiciona os dois no layout
    $row2->addChart($chart1);
    $row2->addChart($chart2);

    $row3 = ChartLayouts::triple();

    for ($i = 1; $i <= 3; $i++) {
      $chart = new ApexChartContainer('area');
      $chart->setCategories(['Q1', 'Q2', 'Q3', 'Q4']);
      $chart->addSeries('Métrica', [rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100)]);

      $row3->addChart($chart, "Métrica {$i}");
    }

    $row4 = ChartLayouts::dashboard();

    // KPI 1
    $kpi1 = new ApexChartContainer('radialBar');
    $kpi1->setConfig([
      'series' => [75],
      'plotOptions' => ['radialBar' => ['hollow' => ['size' => '50%']]],
      'labels' => ['Vendas']
    ]);

    // KPI 2
    $kpi2 = new ApexChartContainer('radialBar');
    $kpi2->setConfig([
      'series' => [60],
      'plotOptions' => ['radialBar' => ['hollow' => ['size' => '50%']]],
      'labels' => ['Meta']
    ]);

    // Gráfico de Linha
    $chart3 = new ApexChartContainer('line');
    $chart3->setCategories(['Jan', 'Fev', 'Mar', 'Abr']);
    $chart3->addSeries('Tendência', [100, 120, 110, 140]);
    $chart3->setToolbar(false);

    // Gráfico de Barra
    $chart4 = new ApexChartContainer('bar');
    $chart4->setCategories(['Norte', 'Sul', 'Leste', 'Oeste']);
    $chart4->addSeries('Vendas por Região', [85, 92, 78, 88]);

    // Monta dashboard
    $row4->addChart($kpi1);
    $row4->addChart($kpi2);
    $row4->addChart($chart3);
    $row4->addChart($chart4);

    $row5 = ChartLayouts::single();

    $chart5 = new ApexChartContainer('rangeArea');
    $chart5->setTitle('Temperatura Máxima e Mínima');

    // Dados no formato [x, [min, max]]
    $chart5->setConfig([
      'series' => [[
        'name' => 'Temperatura',
        'data' => [
          ['x' => 'Jan', 'y' => [5, 15]],
          ['x' => 'Fev', 'y' => [7, 18]],
          ['x' => 'Mar', 'y' => [10, 22]],
          ['x' => 'Abr', 'y' => [12, 25]],
        ]
      ]]
    ]);

    $row5->addChart($chart5);


    $row6 = ChartLayouts::single();

    $categories = array_values(array_map(fn($i) => "P{$i}", range(1, 10))); // P1..P10

    $series = [];
    foreach (['Metric A', 'Metric B', 'Metric C'] as $name) {
      $data = [];
      foreach ($categories as $cat) {
        $data[] = ['x' => $cat, 'y' => rand(0, 100)];
      }
      $series[] = [
        'name' => $name,
        'data' => $data
      ];
    }

    $chart6 = new ApexChartContainer('heatmap');
    $chart6->setTitle('Mapa de Calor');
    $chart6->setConfig([
      // garanta que categories seja um array reindexado
      'xaxis' => [
        'type' => 'category',
        'categories' => $categories
      ],
      'dataLabels' => ['enabled' => false],
      'series' => $series,


    ]);


    $row6->addChart($chart6);

    $row7 = ChartLayouts::double();

    $chart7 = new ApexChartContainer('radar');
    $chart7->setTitle('Desempenho por Competência');

    $chart7->setCategories(['Comunicação', 'Liderança', 'Técnico', 'Inovação', 'Entrega']);
    $chart7->addSeries('João', [80, 90, 70, 85, 95]);
    $chart7->addSeries('Maria', [95, 85, 80, 70, 90]);


    $chart8 = new ApexChartContainer('line');
    $chart8->setTitle('Receita Mensal com Anotações');
    $chart8->setCategories(['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun']);
    $chart8->addSeries('2024', [30, 40, 35, 50, 49, 60]);

    $chart8->setConfig([
      'annotations' => [
        'yaxis' => [[
          'y' => 50,
          'borderColor' => '#FF4560',
          'label' => ['text' => 'Meta Atingida']
        ]],
        'xaxis' => [[
          'x' => 'Mar',
          'borderColor' => '#775DD0',
          'label' => ['text' => 'Campanha']
        ]]
      ]
    ]);


    $row7->addChart($chart7);
    $row7->addChart($chart8);


    $row8 = ChartLayouts::single();

    $chart8 = new ApexChartContainer('bar');
    $chart8->setTitle('Vendas por Região (Stacked)');
    $chart8->setCategories(['Q1', 'Q2', 'Q3', 'Q4']);

    $chart8->setConfig([
      'chart' => ['stacked' => true],
    ]);

    $chart8->addSeries('Norte', [44, 55, 41, 67]);
    $chart8->addSeries('Sul', [13, 23, 20, 8]);
    $chart8->addSeries('Leste', [11, 17, 15, 15]);

    $row8->addChart($chart8);

    $row9 = ChartLayouts::single();

    $chart9 = new ApexChartContainer('line');
    $chart9->setTitle('Gráfico Misto - Coluna + Linha');

    $chart9->setCategories(['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun']);

    $chart9->setConfig([
      'series' => [
        [
          'name' => 'Colunas',
          'type' => 'column',
          'data' => [23, 11, 22, 27, 13, 22]
        ],
        [
          'name' => 'Linha',
          'type' => 'line',
          'data' => [44, 55, 41, 67, 22, 43]
        ]
      ]
    ]);

    $row9->addChart($chart9);

    $container->add($row2);
    $container->add($row3);
    $container->add($row4);
    $container->add($row5);
    $container->add($row6);
    $container->add($row7);
    $container->add($row8);
    $container->add($row9);


    parent::add($container);
  }

  private function getData()
  {

    try {
      TTransaction::openFake('my_database');

      $data['total_by_status'] = [
        ['status' => 'Active', 'total' => rand(66, 99)],
        ['status' => 'In Progress', 'total' => rand(55, 88)],
        ['status' => 'Closed', 'total' => rand(44, 77)],
      ];

      return $data;
    } catch (Exception $e) {
      new TMessage('error', $e->getMessage());
    } finally {
      TTransaction::close();
    }
  }
}
