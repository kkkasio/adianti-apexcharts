# 📊 ApexChart Adianti

Biblioteca para integrar o **[ApexCharts](https://apexcharts.com/)** ao **Adianti Framework**, fornecendo componentes prontos para criação de gráficos dinâmicos e layouts flexíveis.

---

## 🚀 Instalação

### Via Composer

```json
composer require kasio/apexchart-adianti
```

### ⚠️ Dependência obrigatória

Você deve carregar a lib JS do ApexCharts no Adianti.
Edite o arquivo:

`app/templates/adminbs5/libraries.html`

E adicione a linha:

```html
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
```

### 🛠️ Uso básico

```php
use Adianti\Plugins\ApexChart\ApexChartContainer;
use Adianti\Plugins\ApexChart\JsExpression;

// cria gráfico de linhas
$chart = new ApexChartContainer('line');

// adiciona dados
$chart->addSeries('Vendas', [10, 20, 30]);
$chart->setCategories(['Jan', 'Fev', 'Mar']);

// configura título
$chart->setTitle('Relatório de Vendas');

// adiciona formatador JS no eixo Y
$chart->setConfig([
    'yaxis' => [
        'labels' => [
            'formatter' => new JsExpression('function (value) { return value + " $"; }')
        ]
    ]
]);

// exibe no template
$chart->show();
```

### 📊 Exemplo com Donut

```php
$chart2 = new ApexChartContainer('donut');
$chart2->setConfig([
    'series' => [44, 55, 41],
    'labels' => ['Desktop', 'Mobile', 'Tablet']
]);
```

### Usando expressões Javascript

Você deve usar a classe _JsExpression_ para adaptar as funções JS.

````php
$chart = new ApexChartContainer('line');
    $chart->setTitle('Receita Anual');
    $chart->setCategories(['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun']);
    $chart->addSeries('2024', [30000, 40000, 35000, 50000, 49000, 60000]);

    $chart->setConfig([
      'yaxis' => [
        'labels' => [
          'formatter' => new JsExpression("function (value) {
          return '$ ' + value.toLocaleString();
      }")
        ]
      ],
    ]);
```

### 🎨 Layouts

```php
$row = new ApexChartRow();
$row->addChart($chart);
$row->addChart($chart2);
$row->show();

```
````
