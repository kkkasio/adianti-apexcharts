<?php

namespace Adianti\Kasio;


/**
 * Classe helper com layouts pré-definidos usando Bootstrap
 */
class ChartLayouts
{
  /**
   * Row para 1 gráfico (full width)
   */
  public static function single()
  {
    return new ApexChartRow('col-12');
  }

  /**
   * Row para 2 gráficos lado a lado
   */
  public static function double()
  {
    return new ApexChartRow('col-md-6');
  }

  /**
   * Row para 3 gráficos
   */
  public static function triple()
  {
    return new ApexChartRow('col-lg-4 col-md-6');
  }

  /**
   * Row para 4 gráficos (dashboard)
   */
  public static function dashboard()
  {
    return new ApexChartRow('col-xl-3 col-lg-6 col-12');
  }
}
