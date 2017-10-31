<?php

namespace Nielsiano\DmplBuilder;


interface PlotBuilder
{
    /**
     * Adds a new plot of x and y to machine instructions.
     */
    public function plot(int $x, int $y): PlotBuilder;

    /**
     * Changes the pen of the plotter.
     */
    public function changePen(int $pen): PlotBuilder;

    /**
     * Compiles a string in target format with machine instructions.
     */
    public function compile(): string;

    /**
     * Pushes a command to the instructions.
     */
    public function pushCommand(string $command): PlotBuilder;

    /**
     * Lifts the pen up.
     */
    public function penUp(): PlotBuilder;

    /**
     * Pushes the pen down on paper.
     */
    public function penDown(): PlotBuilder;

    /**
     * Changes the plotter pen to use flexcut.
     */
    public function flexCut(): PlotBuilder;

    /**
     * Change to the regular plotter pen.
     */
    public function regularCut(): PlotBuilder;

    /**
     * Changes the pen pressure in gram.
     */
    public function pressure(int $gramPressure): PlotBuilder;

    /**
     * Specifies measuring unit.
     * 1 selects 0.001 inch
     * 5 selects 0.005 inch
     * M selects 0.1 mm
     */
    public function setMeasuringUnit($unit): PlotBuilder;

    /**
     * Changes the plotter velocity.
     */
    public function velocity(int $velocity): PlotBuilder;

    /**
     * Flips the x, y coordinates.
     */
    public function flipAxes(): PlotBuilder;

    /**
     * Cuts off paper when a operation finishes.
     */
    public function cutOff(): PlotBuilder;
}
