<?php

namespace Nielsiano\DmplBuilder\Tests;

use Nielsiano\DmplBuilder\SvgBuilder;

class SvgBuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var SvgBuilder
     */
    protected $builder;

    public function setUp()
    {
        $this->builder = new SvgBuilder();
    }

    public function test_it_can_draw_a_line()
    {
        $this->builder
            ->plot(100, 200);

        $this->assertContains('<line x1="0" y1="0" x2="100" y2="200" class="regular" />',
            $this->builder->compile());
    }

    public function test_it_can_flip_axes()
    {
        $this->builder
            ->flipAxes()
            ->plot(100, 200);

        $this->assertContains('<line x1="0" y1="0" x2="200" y2="100" class="regular" />',
            $this->builder->compile());
    }

    public function test_it_will_not_output_plots_while_pen_is_up()
    {
        $this->builder
            ->penUp()
            ->plot(100, 200);
        $this->assertNotContains('<line ', $this->builder->compile());
    }

    public function test_it_can_select_flex_cut()
    {
        $this->builder
            ->flexCut()
            ->plot(100, 200);

        $this->assertContains('<line x1="0" y1="0" x2="100" y2="200" class="flex" />',
            $this->builder->compile());
    }

    public function test_it_can_determine_extent_of_drawing()
    {
        $this->builder
            ->plot(100, 200);

        $this->assertContains('<svg xmlns="http://www.w3.org/2000/svg" width="100" height="200"',
            $this->builder->compile());

        $this->builder
            ->plot(50, 50);

        $this->assertContains('<svg xmlns="http://www.w3.org/2000/svg" width="150" height="250"',
            $this->builder->compile());
    }

}
