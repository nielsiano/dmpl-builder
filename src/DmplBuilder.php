<?php

/*
 * This file is part of the Nielsiano\DmplBuilder package.
 *
 * (c) Niels Stampe <nielsstampe@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Nielsiano\DmplBuilder;

/**
 * Class DmplBuilder
 *
 * @package Nielsiano\DmplBuilder
 */
class DmplBuilder
{

    /**
     * Generated DM/PL command instructions.
     *
     * @var array
     */
    protected $instructions = [];

    /**
     * @var bool
     */
    protected $cutOff = false;

    /**
     * @var bool
     */
    protected $flipAxes = false;

    /**
     * @var mixed
     */
    protected $measuringUnit = 'M';

    const KISS_CUT = 50;
    const FLEXCUT_PEN = 6;
    const REGULAR_PEN = 0;
    const CUT_THROUGH = 100;

    /**
     * Adds a new plot of x and y to machine instructions.
     *
     * @param int $x
     * @param int $y
     * @return $this
     */
    public function plot(int $x, int $y)
    {
        array_map([$this, 'pushCommand'], $this->flipAxes ? [$y, $x] : [$x, $y]);

        return $this;
    }

    /**
     * Changes the pen of the plotter.
     *
     * @param int $pen
     * @return $this
     */
    public function changePen(int $pen)
    {
        if (! in_array($pen, range(0, 6))) {
            throw new \InvalidArgumentException(sprintf('[%d] is not a valid Pen.', $pen));
        }

        return $this->pushCommand(sprintf('P%d;', $pen));
    }

    /**
     * Compiles a string in DMPL format with machine instructions.
     *
     * @return string
     */
    public function compileDmpl(): string
    {
        $init = sprintf(';: EC%s,U H L0,A100,100,R,', $this->measuringUnit);

        $this->pushCommand($this->cutOff ? ';:c,e' : 'e');

        return $init . implode(',', $this->instructions);
    }

    /**
     * Pushes a command to the instructions.
     *
     * @param string $command
     * @return $this
     */
    public function pushCommand(string $command)
    {
        $this->instructions[] = $command;

        return $this;
    }

    /**
     * Lifts the pen up.
     *
     * @return $this
     */
    public function penUp()
    {
        return $this->pushCommand('U');
    }

    /**
     * Pushes the pen down on paper.
     *
     * @return $this
     */
    public function penDown()
    {
        return $this->pushCommand('D');
    }

    /**
     * Changes the plotter pen to use flexcut.
     *
     * @return $this
     */
    public function flexCut()
    {
        return $this->changePen(self::FLEXCUT_PEN);
    }

    /**
     * Change to the regular plotter pen.
     *
     * @return $this
     */
    public function regularCut()
    {
        return $this->changePen(self::REGULAR_PEN);
    }

    /**
     * Changes the pen pressure in gram.
     *
     * @param int $gramPressure
     * @return $this
     */
    public function pressure(int $gramPressure)
    {
        return $this->pushCommand(sprintf('BP%d;', $gramPressure));
    }

    /**
     * Specifies measuring unit.
     * 1 selects 0.001 inch
     * 5 selects 0.005 inch
     * M selects 0.1 mm
     *
     * @param $unit
     * @return $this
     */
    public function setMeasuringUnit($unit)
    {
        if (! in_array($unit, [1, 2, 3, 4, 5, 'M'])) {
            throw new \InvalidArgumentException(sprintf('[%s] is not a valid measuring unit.', $unit));
        }

        $this->measuringUnit = $unit;

        return $this;
    }

    /**
     * Changes the plotter velocity.
     *
     * @param int $velocity
     * @return $this
     */
    public function velocity(int $velocity)
    {
        return $this->pushCommand(sprintf('V%d;', $velocity));
    }

    /**
     * Flips the x, y coordinates.
     *
     * @return $this
     */
    public function flipAxes()
    {
        $this->flipAxes = true;

        return $this;
    }

    /**
     * Cuts off paper when a operation finishes.
     *
     * @return $this
     */
    public function cutOff()
    {
        $this->cutOff = true;

        return $this;
    }

}
