<?php

namespace Nielsiano\DmplBuilder;

/**
 * Illustrate a plot program visually as an SVG line drawing.
 */
class SvgBuilder implements PlotBuilder
{
    /**
     * Current position.
     */
    protected $x = 0;
    protected $y = 0;

    /**
     * Extent of drawing
     */
    protected $maxX = 0;
    protected $maxY = 0;

    protected $instructions = [];

    protected $axesFlipped = false;
    protected $penIsDown = true;
    protected $tool = 'regular';

    /**
     * Adds a new plot of x and y to machine instructions.
     */
    public function plot(int $x, int $y): PlotBuilder
    {

        if ($this->axesFlipped) {
            list($x, $y) = [$y, $x];
        }

        $targetX = $this->x + $x;
        $targetY = $this->y + $y;

        $this->maxX = max($this->maxX, $targetX);
        $this->maxY = max($this->maxY, $targetY);

        if ($this->penIsDown) {
            $this->pushInstruction('line', [
                'x1'    => $this->x,
                'y1'    => $this->y,
                'x2'    => $targetX,
                'y2'    => $targetY,
                'class' => $this->tool
            ]);
        }

        $this->x = $targetX;
        $this->y = $targetY;

        return $this;
    }

    /**
     * Changes the pen of the plotter.
     */
    public function changePen(int $pen): PlotBuilder
    {
        // TODO: Implement changePen() method.
    }

    /**
     * Compiles a string in target format with machine instructions.
     */
    public function compile(): string
    {
        $instructions = implode("\n", $this->instructions);

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="{$this->maxX}" height="{$this->maxY}">
    <defs>
        <style>
            line.regular {
                stroke: rgb(255,0,0);
                stroke-width: 2;
            }

            line.flex {
                stroke: rgb(255,0,0);
                stroke-width: 2;
                stroke-dasharray: 10 2;
            }
        </style>
    </defs>
    {$instructions}
</svg>
SVG;
    }

    /**
     * Pushes a command to the instructions.
     */
    public function pushCommand(string $command): PlotBuilder
    {
        // TODO: Implement pushCommand() method.
    }

    /**
     * Lifts the pen up.
     */
    public function penUp(): PlotBuilder
    {
        $this->penIsDown = false;

        return $this;
    }

    /**
     * Pushes the pen down on paper.
     */
    public function penDown(): PlotBuilder
    {
        $this->penIsDown = true;

        return $this;
    }

    /**
     * Changes the plotter pen to use flexcut.
     */
    public function flexCut(): PlotBuilder
    {
        $this->tool = 'flex';

        return $this;
    }

    /**
     * Change to the regular plotter pen.
     */
    public function regularCut(): PlotBuilder
    {
        $this->tool = 'regular';

        return $this;
    }

    /**
     * Changes the pen pressure in gram.
     */
    public function pressure(int $gramPressure): PlotBuilder
    {
        // TODO: Simulate pressure with stroke width, perhaps?
    }

    /**
     * Specifies measuring unit.
     * 1 selects 0.001 inch
     * 5 selects 0.005 inch
     * M selects 0.1 mm
     */
    public function setMeasuringUnit($unit): PlotBuilder
    {
        // TODO: Implement setMeasuringUnit() method.
    }

    /**
     * Changes the plotter velocity.
     */
    public function velocity(int $velocity): PlotBuilder
    {
        // TODO: Implement velocity() method.
    }

    /**
     * Flips the x, y coordinates.
     */
    public function flipAxes(): PlotBuilder
    {
        $this->axesFlipped = true;

        return $this;
    }

    /**
     * Cuts off paper when a operation finishes.
     */
    public function cutOff(): PlotBuilder
    {
        // TODO: Implement cutOff() method.
    }

    protected function pushInstruction(string $name, array $parameters): PlotBuilder
    {
        $instruction = '<' . $name;
        foreach ($parameters as $parameter => $value) {
            $instruction .= ' ' . $parameter . '="' . htmlspecialchars($value) . '"';
        }
        $this->instructions[] = $instruction . ' />';

        return $this;
    }
}
