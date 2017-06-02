<?php
/**
 * Copyright 2017, Jean Traullé <jtraulle@users.noreply.github.com>
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2017, Jean Traullé <jtraulle@users.noreply.github.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 */

namespace CakeCharts\Utility;

/**
 * Class Traces
 * @package CakeCharts\Utility
 */
class Traces
{
    /**
     * @var Trace[] Array of Trace objects
     * @see \CakeCharts\Utility\Trace
     */
    private $traces;

    /**
     * @var \Exception|null Encountered error, if any
     */
    private $error = null;

    /**
     * Traces constructor.
     *
     * @param array|null $traces Array of Trace objects
     * @see \CakeCharts\Utility\Trace
     */
    public function __construct(array $traces = null)
    {
        $this->traces = $traces;
    }

    /**
     * Add a Trace object to the list of traces
     *
     * @param Trace $trace A trace object
     * @see \CakeCharts\Utility\Trace
     * @return void
     */
    public function addTrace(Trace $trace)
    {
        $this->traces[] = $trace;
    }

    /**
     * Output series as plotly.js compliant data series
     *
     * @return string plotly.js compliant (JSON) data series
     */
    public function __toString()
    {
        try {
            $return = [];
            foreach ($this->traces as $trace) {
                $return[] = $trace->toArray();
            }

            return json_encode($return);
        } catch (\Exception $e) {
            $this->error = $e;

            return json_encode([]);
        }
    }

    /**
     * @return \Exception|string Encountered error, if any
     */
    public function getError()
    {
        return $this->error;
    }
}
