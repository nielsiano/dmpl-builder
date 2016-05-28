<?php

namespace Nielsiano\DmplBuilder\Tests;

use Nielsiano\DmplBuilder\DmplBuilder;

class DmplBuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DmplBuilder
     */
    protected $builder;

    public function setUp()
    {
        $this->builder = new DmplBuilder;
    }

    public function test_it_can_init_and_return_start_instructions()
    {
        $this->assertEquals(';: ECM,U H L0,P0;V10;BP50;A100,100,R,e', $this->builder->compileDmpl());
    }

    public function test_it_can_add_pen_up_to_dmpl_string()
    {
        $this->builder->penUp();
        $this->assertEquals(';: ECM,U H L0,P0;V10;BP50;A100,100,R,U,e', $this->builder->compileDmpl());
    }

    public function test_it_can_add_pen_down_to_dmpl_string()
    {
        $this->builder->penDown();
        $this->assertEquals(';: ECM,U H L0,P0;V10;BP50;A100,100,R,D,e', $this->builder->compileDmpl());
    }

    public function test_it_can_change_pen_tool_to_regular_cut()
    {
        $this->builder->regularCut();
        $this->assertEquals(';: ECM,U H L0,P0;V10;BP50;A100,100,R,P0;,e', $this->builder->compileDmpl());
    }

    public function test_it_can_change_pressure_in_gram()
    {
        $this->builder->pressure(80);
        $this->assertEquals(';: ECM,U H L0,P0;V10;BP50;A100,100,R,BP80;,e', $this->builder->compileDmpl());
    }

    public function test_it_can_change_velocity()
    {
        $this->builder->velocity(100);
        $this->assertEquals(';: ECM,U H L0,P0;V10;BP50;A100,100,R,V100;,e', $this->builder->compileDmpl());
    }

    public function test_it_can_finalize_the_dmpl_string_without_cutoff()
    {
        $this->assertEquals(';: ECM,U H L0,P0;V10;BP50;A100,100,R,e', $this->builder->compileDmpl());
    }

    public function test_it_can_add_a_new_plot()
    {
        $this->builder->plot(-1000, 5000);
        $this->assertEquals(';: ECM,U H L0,P0;V10;BP50;A100,100,R,-1000,5000,e', $this->builder->compileDmpl());
    }

    public function test_it_can_push_a_generic_command()
    {
        $this->builder->pushCommand('V10;');
        $this->assertEquals(';: ECM,U H L0,P0;V10;BP50;A100,100,R,V10;,e', $this->builder->compileDmpl());
    }

    public function test_it_can_chain_multiple_actions()
    {
        $this->builder->penUp()->regularCut()->penDown()->plot(-1984, 1337);
        $this->assertEquals(';: ECM,U H L0,P0;V10;BP50;A100,100,R,U,P0;,D,-1984,1337,e', $this->builder->compileDmpl());
    }

    public function test_it_can_flip_axes()
    {
        $this->builder->flipAxes()->plot(-1, 2)->plot(1337, 1984);
        $this->assertEquals(';: ECM,U H L0,P0;V10;BP50;A100,100,R,2,-1,1984,1337,e', $this->builder->compileDmpl());
    }

    public function test_it_can_finalize_the_dmpl_string_with_cutoff()
    {
        $this->assertEquals(';: ECM,U H L0,P0;V10;BP50;A100,100,R,;:c,e', $this->builder->cutOff()->compileDmpl());
    }

}
