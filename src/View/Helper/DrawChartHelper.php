<?php
/**
 * Copyright 2017, Jean Traullé <jtraulle@users.noreply.github.com>
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2017, Jean Traullé <jtraulle@users.noreply.github.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace CakeCharts\View\Helper;

use CakeCharts\Utility\Trace;
use CakeCharts\Utility\Traces;
use Cake\View\Helper;

/**
 * DrawChart helper
 * @package CakeCharts\View\Helper
 */
class DrawChartHelper extends Helper
{

    /**
     * Primary function responsible for the generation of every chart
     *
     * @param Traces $traces Traces object is an array of Trace objects
     * @see \CakeCharts\Utility\Traces
     * @param array $layout Any layout option accepted by Plotly.js
     * @see https://plot.ly/javascript/#layout-options for possible values and examples
     * @param array $configuration Any configuration option accepted by Plotly.js
     * @see https://plot.ly/javascript/configuration-options for possible values and examples
     * @param string|null $id HTML identifier of div where chart will be drawed
     * @return string The generated chart
     */
    private function makeChart(Traces $traces, array $layout = [], array $configuration = [], string $id = null)
    {
        $id = ($id === null) ? uniqid('chart_') : $id;

        return $this->_View->element('CakeCharts.Chart', [
            'id' => $id,
            'data' => $traces,
            'layout' => json_encode($layout, JSON_FORCE_OBJECT),
            'configuration' => json_encode($configuration, JSON_FORCE_OBJECT)
        ]);
    }

    /**
     * Function used to generate single series charts
     *
     * @param array $x Values to be placed on X axis
     * @param array $y Values to be placed on Y axis
     * @param string $type Type of trace : can be either "bar", "pie" or "scatter"
     * @param string|null $mode Line type : can be either "markers", "lines" or "markers+line"
     * @param array $layout Any layout option accepted by Plotly.js
     * @param array $configuration Any configuration option accepted by Plotly.js
     * @param string|null $id HTML identifier of div where chart will be drawed
     * @return string The generated chart
     * @see https://plot.ly/javascript/#layout-options for possible values and examples
     * @see https://plot.ly/javascript/configuration-options for possible values and examples
     */
    public function makeSingleTraceChart(
        array $x,
        array $y,
        string $type,
        string $mode = null,
        array $layout = [],
        array $configuration = [],
        string $id = null
    ) {
        return $this->makeChart(new Traces([new Trace($x, $y, $type, $mode)]), $layout, $configuration, $id);
    }

    /**
     * Function used to generate multi series charts
     *
     * @param array $series Multi-dimensional array of series
     *    $series = [
     *       [
     *          (array) X values,
     *          (array) Y values,
     *          (opt. string) Name of the series,
     *          (opt. string) Line type ("markers", "lines" or "markers+line")
     *       ], [...], [...]
     *    ]
     * @param string $type Type of trace : can be either "bar", "pie" or "scatter"
     * @param array $layout Any layout option accepted by Plotly.js
     * @see https://plot.ly/javascript/#layout-options for possible values and examples
     * @param array $configuration Any configuration option accepted by Plotly.js
     * @see https://plot.ly/javascript/configuration-options for possible values and examples
     * @param string|null $id HTML identifier of div where chart will be drawed
     * @return string The generated chart
     */
    public function makeMultiTraceChart(
        array $series,
        string $type,
        array $layout = [],
        array $configuration = [],
        string $id = null
    ) {
        $traces = new Traces();
        foreach ($series as $serie) {
            $traces->addTrace(
                new Trace(
                    $serie[0],
                    $serie[1],
                    $type,
                    isset($serie[2]) ? $serie[2] : null,
                    isset($serie[3]) ? $serie[3] : null,
                    isset($serie[4]) ? $serie[4] : null
                )
            );
        }

        return $this->makeChart($traces, $layout, $configuration, $id);
    }

    /**
     * Every functions below are just syntactic sugar
     */

    /**
     * BAR CHARTS FUNCTIONS
     */

    /**
     * Function used to generate a simple bar chart
     *
     * @param array $x Values to be placed on X axis
     * @param array $y Values to be placed on Y axis
     * @param array $layout Any layout option accepted by Plotly.js
     * @see https://plot.ly/javascript/#layout-options for possible values and examples
     * @param array $configuration Any configuration option accepted by Plotly.js
     * @see https://plot.ly/javascript/configuration-options for possible values and examples
     * @param string|null $id HTML identifier of div where chart will be drawed
     * @return string The generated chart
     */
    public function simpleBarChart(
        array $x,
        array $y,
        array $layout = [],
        array $configuration = [],
        string $id = null
    ) {
        return $this->makeSingleTraceChart($x, $y, 'bar', null, $layout, $configuration, $id);
    }

    /**
     * Function used to generate a grouped bar chart
     *
     * @param array $series Multi-dimensional array of series
     *    $series = [
     *       [
     *          (array) X values,
     *          (array) Y values,
     *          (opt. string) Name of the series,
     *          (opt. string) Line type ("markers", "lines" or "markers+line")
     *       ], [...], [...]
     *    ]
     * @param array $layout Any layout option accepted by Plotly.js
     * @see https://plot.ly/javascript/#layout-options for possible values and examples
     * @param array $configuration Any configuration option accepted by Plotly.js
     * @see https://plot.ly/javascript/configuration-options for possible values and examples
     * @param string|null $id HTML identifier of div where chart will be drawed
     * @return string The generated chart
     */
    public function groupedBarChart(
        array $series,
        array $layout = [],
        array $configuration = [],
        string $id = null
    ) {
        $layout['barmode'] = 'grouped';

        return $this->makeMultiTraceChart($series, 'bar', $layout, $configuration, $id);
    }

    /**
     * Function used to generate a stacked bar chart
     *
     * @param array $series Multi-dimensional array of series
     *    $series = [
     *       [
     *          (array) X values,
     *          (array) Y values,
     *          (opt. string) Name of the series,
     *          (opt. string) Line type ("markers", "lines" or "markers+line")
     *       ], [...], [...]
     *    ]
     * @param array $layout Any layout option accepted by Plotly.js
     * @see https://plot.ly/javascript/#layout-options for possible values and examples
     * @param array $configuration Any configuration option accepted by Plotly.js
     * @see https://plot.ly/javascript/configuration-options for possible values and examples
     * @param string|null $id HTML identifier of div where chart will be drawed
     * @return string The generated chart
     */
    public function stackedBarChart(
        array $series,
        array $layout = [],
        array $configuration = [],
        string $id = null
    ): string {
        $layout['barmode'] = 'stack';

        return $this->makeMultiTraceChart($series, 'bar', $layout, $configuration, $id);
    }

    /**
     * PIE CHART FUNCTION
     */

    /**
     * Function used to generate a simple pie chart
     *
     * @param array $x Values to be placed on X axis
     * @param array $y Values to be placed on Y axis
     * @param array $layout Any layout option accepted by Plotly.js
     * @see https://plot.ly/javascript/#layout-options for possible values and examples
     * @param array $configuration Any configuration option accepted by Plotly.js
     * @see https://plot.ly/javascript/configuration-options for possible values and examples
     * @param string|null $id HTML identifier of div where chart will be drawed
     * @return string The generated chart
     */
    public function pieChart(
        array $x,
        array $y,
        array $layout = [],
        array $configuration = [],
        string $id = null
    ): string {
        return $this->makeSingleTraceChart($x, $y, 'pie', null, $layout, $configuration, $id);
    }

    /**
     * LINE CHARTS FUNCTIONS
     */

    /**
     * Function used to generate a single line chart
     *
     * @param array $x Values to be placed on X axis
     * @param array $y Values to be placed on Y axis
     * @param string $mode Can be either "markers", "lines" or "markers+line"
     * @param array $layout Any layout option accepted by Plotly.js
     * @see https://plot.ly/javascript/#layout-options for possible values and examples
     * @param array $configuration Any configuration option accepted by Plotly.js
     * @see https://plot.ly/javascript/configuration-options for possible values and examples
     * @param string|null $id HTML identifier of div where chart will be drawed
     * @return string The generated chart
     */
    public function singleLineChart(
        array $x,
        array $y,
        string $mode = 'markers+line',
        array $layout = [],
        array $configuration = [],
        string $id = null
    ): string {
        return $this->makeSingleTraceChart($x, $y, 'scatter', $mode, $layout, $configuration, $id);
    }

    /**
     * Function used to generate a multiline chart
     *
     * @param array $series Multi-dimensional array of series
     *    $series = [
     *       [
     *          (array) X values,
     *          (array) Y values,
     *          (opt. string) Name of the series,
     *          (opt. string) Line type ("markers", "lines" or "markers+line")
     *       ], [...], [...]
     *    ]
     * @param array $layout Any layout option accepted by Plotly.js
     * @see https://plot.ly/javascript/#layout-options for possible values and examples
     * @param array $configuration Any configuration option accepted by Plotly.js
     * @see https://plot.ly/javascript/configuration-options for possible values and examples
     * @param string|null $id HTML identifier of div where chart will be drawed
     * @return string The generated chart
     */
    public function multilineChart(
        array $series,
        array $layout = [],
        array $configuration = [],
        string $id = null
    ): string {
        return $this->makeMultiTraceChart($series, 'scatter', $layout, $configuration, $id);
    }
}
