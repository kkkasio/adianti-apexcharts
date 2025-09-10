# 📊 ApexChart Adianti

Biblioteca para integrar o **[ApexCharts](https://apexcharts.com/)** ao **Adianti Framework**, fornecendo componentes prontos para criação de gráficos dinâmicos e layouts flexíveis.

---

## 🚀 Instalação

### Via Composer

Adicione o repositório no `composer.json` do seu projeto:

```json
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/seuuser/apexchart-adianti"
  }
],
"require": {
  "kasio/apexchart-adianti": "^1.0"
}
```

Depois, execute:

```bash
composer update kasio/apexchart-adianti
```

### ⚠️ Dependência obrigatória
Você deve carregar o ApexCharts.js no Adianti.
Edite o arquivo:

`app/control/AdiantiCoreTemplate.class.php`

E adicione a linha:
```html
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
```


### 📂 Estrutura da biblioteca

ApexChartContainer.php → classe principal para renderização de gráficos.
ApexChartRow.php → ajuda a organizar gráficos em linhas.
ChartLayouts.php → layouts pré-configurados de gráficos.
JsExpression.php → utilitário para injetar funções JavaScript diretamente (como formatters).


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

### 🎨 Layouts
```php
$row = new ApexChartRow();
$row->addChart($chart);
$row->addChart($chart2);
$row->show();

```