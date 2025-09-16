<?php

namespace Adianti\Kasio;

use Adianti\Widget\Base\TElement;
use Adianti\Widget\Base\TScript;

/**
 * ApexChart Container for Adianti Framework
 */
class ApexChartContainer extends TElement
{
  protected $chartConfig;
  protected $chartType;
  protected $width;
  protected $height;

  /**
   * Class Constructor
   */
  public function __construct($type = 'line')
  {
    parent::__construct('div');
    $this->id = 'apexchart_' . uniqid();
    $this->chartType = $type;
    $this->width = '100%';
    $this->height = '350';

    $this->chartConfig = [
      'chart' => [
        'type' => $type,
        'height' => $this->height,
        'width' => $this->width,
        'animations' => [
          'enabled' => true,
          'speed' => 800,
          'animateGradually' => [
            'enabled' => true
          ],
          'dynamicAnimation' => [
            'enabled' => true,
          ]
        ],

      ],
      'series' => [],
      'xaxis' => [
        'categories' => []
      ],
      'yaxis' => [
        'title' => [
          'text' => 'Valores'
        ]
      ],
      'title' => [
        'text' => 'Gráfico',
        'align' => 'center'
      ],
    ];
  }

  /**
   * Set chart dimensions
   * @param $width Chart width
   * @param $height Chart height
   */
  public function setSize($width, $height)
  {
    $this->width = $width;
    $this->height = $height;
    $this->chartConfig['chart']['width'] = $width;
    $this->chartConfig['chart']['height'] = $height;
  }

  /**
   * Set chart title
   * @param $title Chart title
   * @param $align Title alignment (left, center, right)
   */
  public function setTitle($title, $align = 'center')
  {
    $this->chartConfig['title']['text'] = $title;
    $this->chartConfig['title']['align'] = $align;
  }

  /**
   * Set X-axis categories
   * @param $categories Array of categories
   */
  public function setCategories($categories)
  {
    $this->chartConfig['xaxis']['categories'] = $categories;
  }

  /**
   * Add data series to the chart
   * @param $name Series name
   * @param $data Array of data points
   * @param $color Optional color for the series
   */
  public function addSeries($name, $data, $color = null)
  {

    if (in_array($this->chartType, ['donut', 'pie', 'radialBar'])) {
      $this->chartConfig['series'] = $data;
      return;
    }


    $series = [
      'name' => $name,
      'data' => $data
    ];

    if ($color) {
      $series['color'] = $color;
    }

    $this->chartConfig['series'][] = $series;
  }

  /**
   * Set Y-axis configuration
   * @param $title Y-axis title
   * @param $min Optional minimum value
   * @param $max Optional maximum value
   */
  public function setYAxis($title, $min = null, $max = null)
  {
    $this->chartConfig['yaxis']['title']['text'] = $title;

    if ($min !== null) {
      $this->chartConfig['yaxis']['min'] = $min;
    }

    if ($max !== null) {
      $this->chartConfig['yaxis']['max'] = $max;
    }
  }

  /**
   * Enable/disable chart animations
   * @param $enabled Boolean to enable/disable
   * @param $speed Animation speed in milliseconds
   */
  public function setAnimations($enabled = true, $speed = 800)
  {
    $this->chartConfig['chart']['animations']['enabled'] = $enabled;
    $this->chartConfig['chart']['animations']['speed'] = $speed;
  }

  /**
   * Set chart theme
   * @param $mode Theme mode ('light' or 'dark')
   */
  public function setTheme($mode = 'light')
  {
    $this->chartConfig['theme']['mode'] = $mode;
  }

  /**
   * Set custom chart configuration
   * @param $config Array with custom configuration
   */
  public function setConfig($config)
  {
    $this->chartConfig = array_merge_recursive($this->chartConfig, $config);
  }

  /**
   * Enable/disable chart toolbar
   * @param $show Boolean to show/hide toolbar
   */
  public function setToolbar($show = true)
  {
    $this->chartConfig['chart']['toolbar']['show'] = $show;
  }

  /**
   * Set colors for the chart series
   * @param $colors Array of colors
   */
  public function setColors($colors)
  {
    $this->chartConfig['colors'] = $colors;
  }

  /**
   * Enable data labels
   * @param $enabled Boolean to enable/disable
   * @param $formatter Optional JavaScript formatter function
   */
  public function setDataLabels($enabled = true, $formatter = null)
  {
    $this->chartConfig['dataLabels'] = [
      'enabled' => $enabled
    ];

    if ($formatter) {
      $this->chartConfig['dataLabels']['formatter'] = $formatter;
    }
  }


  /**
   * Custom JSON encoder to handle JsExpression objects
   * @param $data Data to encode
   * @return string JSON encoded string
   */
  private function jsonEncodeWithJs($data)
  {
    if (is_array($data)) {
      $assoc = array_keys($data) !== range(0, count($data) - 1);
      $items = [];
      foreach ($data as $key => $value) {
        $encodedValue = $this->jsonEncodeWithJs($value);
        if ($assoc) {
          $items[] = json_encode((string)$key) . ':' . $encodedValue;
        } else {
          $items[] = $encodedValue;
        }
      }
      return $assoc ? '{' . implode(',', $items) . '}' : '[' . implode(',', $items) . ']';
    }

    if ($data instanceof JsExpression) {
      // insere cru, sem aspas
      return (string)$data;
    }

    return json_encode($data, JSON_UNESCAPED_UNICODE);
  }

  /**
   * Encode configuration to JSON
   * @param $config Configuration array
   * @return string JSON encoded configuration
   */
  private function encodeConfig($config)
  {
    return $this->jsonEncodeWithJs($config);
  }


  /**
   * Shows the widget at the screen
   */
  public function show()
  {
    // Convert PHP config to JSON    
    $configJson = $this->encodeConfig($this->chartConfig);

    $configJson = preg_replace_callback(
      '/"@@FUNC_START@@(.*?)@@FUNC_END@@"/s',
      function ($matches) {
        return $matches[1]; // remove as aspas e markers
      },
      $configJson
    );

    // Create JavaScript to initialize the chart
    $script = "        
            var options_{$this->id} = {$configJson};
            var chart_{$this->id} = new ApexCharts(document.querySelector('#{$this->id}'), options_{$this->id});
            chart_{$this->id}.render();
            
            // Store chart instance for potential future updates
            if (!window.apexCharts) window.apexCharts = {};
            window.apexCharts['{$this->id}'] = chart_{$this->id};        
        ";

    TScript::create($script);

    parent::show();
  }

  /**
   * Update chart data dynamically (JavaScript function)
   * @param $newSeries New series data
   * @return string JavaScript code to update the chart
   */
  public function getUpdateScript($newSeries)
  {
    $seriesJson = json_encode($newSeries, JSON_UNESCAPED_UNICODE);
    $chartId = $this->id;

    return "
    if (typeof window.apexCharts !== 'undefined' && window.apexCharts['{$chartId}']) {
        window.apexCharts['{$chartId}'].updateSeries({$seriesJson});
    }";
  }
}
