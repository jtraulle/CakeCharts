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
 * Class Trace
 * @package CakeCharts\Utility
 */
class Trace
{
    /**
     * @var array Values to be placed on X axis
     */
    private $x;
    /**
     * @var array Values to be placed on Y axis
     */
    private $y;
    /**
     * @var string Type of trace : can be either "bar", "pie" or "scatter"
     */
    private $type;
    /**
     * @var string Name of the series
     */
    private $name;
    /**
     * @var string Line type ("markers", "lines" or "markers+line")
     */
    private $mode;
    /**
     * @var array Styling options for marker
     */
    private $marker;

    /**
     * Trace constructor.
     *
     * @param array $x Values to be placed on X axis
     * @param array $y Values to be placed on Y axis
     * @param string $type Type of trace : can be either "bar", "pie" or "scatter"
     * @param string|null $name Name of the series
     * @param string|null $mode Line type ("markers", "lines" or "markers+line")
     * @param array $marker Plot.ly option for markers
     */
    public function __construct(array $x, array $y, string $type, string $name = null, string $mode = null, array $marker = [])
    {
        $this->x = $x;
        $this->y = $y;
        $this->type = $type;
        $this->name = $name;
        $this->mode = $mode;
        $this->marker = $marker;
    }

    /**
     * Convert Trace object to keys/values array
     *
     * @return array Plotly.js compliant data series (also known as trace)
     * @throws \Exception If unexpected values occured
     */
    public function toArray()
    {
        $this->checkXequalsY();
        switch ($this->type) {
            case 'bar':
                $trace = ['x' => $this->x, 'y' => $this->y, 'type' => $this->type, 'name' => $this->name, 'marker' => $this->marker];
                break;
            case 'scatter':
                $this->checkModeValue();
                $trace = ['x' => $this->x, 'y' => $this->y, 'type' => $this->type, 'name' => $this->name, 'mode' => $this->mode];
                break;
            case 'pie':
                $trace = ['labels' => $this->x, 'values' => $this->y, 'type' => $this->type];
                break;
            default:
                throw new \Exception('Unhandled chart type : can be either "bar", "scatter" or "pie" ; got "' . $this->type . '"');
        }

        return $trace;
    }

    /**
     * Makes sure that number of X values equals Y values
     *
     * @throws \Exception
     * @return void
     */
    private function checkXequalsY()
    {
        if (count($this->x) !== count($this->y)) {
            $name = isset($this->name) ? $this->name : 'unamed';
            throw new \Exception("Number of X axis values are not equal to number of Y axis values for <u>$name</u> series");
        }
    }

    /**
     * Makes sure that "mode" is a valid value
     *
     * @throws \Exception
     * @return void
     */
    private function checkModeValue()
    {
        if (!in_array($this->mode, ['markers', 'lines', 'lines+markers', null])) {
            throw new \Exception('Invalid trace mode : can be either "markers", "lines" or "markers+line" ; got "' . $this->mode . '"');
        }
    }
}