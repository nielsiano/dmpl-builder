<?php

namespace Nielsiano\DmplBuilder;


interface PlotBuilder
{
    /**
     * Adds a new plot of x and y to machine instructions.
     *
     * @param int $x
     * @param int $y
     * @return $this
     */
    public function plot(int $x, int $y);

    /**
     * Changes the pen of the plotter.
     *
     * @param int $pen
     * @return $this
     */
    public function changePen(int $pen);

    /**
     * Compiles a string in DMPL format with machine instructions.
     *
     * @return string
     */
    public function compileDmpl(): string;

    /**
     * Pushes a command to the instructions.
     *
     * @param string $command
     * @return $this
     */
    public function pushCommand(string $command);

    /**
     * Lifts the pen up.
     *
     * @return $this
     */
    public function penUp();

    /**
     * Pushes the pen down on paper.
     *
     * @return $this
     */
    public function penDown();

    /**
     * Changes the plotter pen to use flexcut.
     *
     * @return $this
     */
    public function flexCut();

    /**
     * Change to the regular plotter pen.
     *
     * @return $this
     */
    public function regularCut();

    /**
     * Changes the pen pressure in gram.
     *
     * @param int $gramPressure
     * @return $this
     */
    public function pressure(int $gramPressure);

    /**
     * Specifies measuring unit.
     * 1 selects 0.001 inch
     * 5 selects 0.005 inch
     * M selects 0.1 mm
     *
     * @param $unit
     * @return $this
     */
    public function setMeasuringUnit($unit);

    /**
     * Changes the plotter velocity.
     *
     * @param int $velocity
     * @return $this
     */
    public function velocity(int $velocity);

    /**
     * Flips the x, y coordinates.
     *
     * @return $this
     */
    public function flipAxes();

    /**
     * Cuts off paper when a operation finishes.
     *
     * @return $this
     */
    public function cutOff();
}
