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
            ->setMeasuringUnit('M')
            ->plot(100, 200);

        $this->assertContains('<svg xmlns="http://www.w3.org/2000/svg" width="10mm" height="20mm"',
            $this->builder->compile());

        $this->builder
            ->plot(50, 50);

        $this->assertContains('<svg xmlns="http://www.w3.org/2000/svg" width="15mm" height="25mm"',
            $this->builder->compile());
    }

    public function test_flex_cut_macro_is_equivalent_to_change_pen()
    {
        $otherBuilder = new SvgBuilder();
        $this->assertEquals(
            $this->builder->flexCut()->plot(100, 200),
            $otherBuilder->changePen(6)->plot(100, 200));
    }

}
