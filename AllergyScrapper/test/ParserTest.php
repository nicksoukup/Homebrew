<?php
require_once('../class/Parser.php');
require_once('../class/AllergenVO.php');

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-08-23 at 20:01:13.
 */
class ParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Parser
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Parser('');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }


    /**
     * @covers Parser::extract
     */
    public function testExtract()
    {
        $str = "Allergy Count: Ragweed Low 7 gr/m3,&nbsp;Mulberry 7 gr/m3 and Molds High.&nbsp;";
        $outs = $this->object->extract($str);
        $this->assertEquals(3, count($outs), 'Three allergans should be detected');
        $this->assertEquals('Ragweed', $outs[0]->get_type(), 'output should be Ragweed');
        $this->assertEquals('Mulberry', $outs[1]->get_type(), 'output should be Mulberry');
        $this->assertEquals('Molds', $outs[2]->get_type(), 'output should be Molds');

	    $str = "Allergy Count: Molds High.&nbsp;";
        $outs = $this->object->extract($str);
        $this->assertEquals(1, count($outs), 'One allergans should be detected');
        $this->assertEquals('Molds', $outs[0]->get_type(), 'First output should be Ragweed');


	    $str = "Allergy Count: Mulberry 7 gr/m3";
        $outs = $this->object->extract($str);
        $this->assertEquals(1, count($outs), 'One allergans should be detected');
        $this->assertEquals('Mulberry', $outs[0]->get_type(), 'output should be Mulberry');

	    $str = "Allergy Count: Ragweed Low 7 gr/m3, Molds High.&nbsp;";
        $outs = $this->object->extract($str);
        $this->assertEquals(2, count($outs), 'One allergans should be detected');
        $this->assertEquals('Ragweed', $outs[0]->get_type(), 'output should be Ragweed');
        $this->assertEquals('Molds', $outs[1]->get_type(), 'output should be Molds');
	
	    $str = "Allergy Count: Mulberry 7 gr/m3 and Molds Very High.&nbsp;";
        $outs = $this->object->extract($str);
        $this->assertEquals(2, count($outs), 'One allergans should be detected');
        $this->assertEquals('Mulberry', $outs[0]->get_type(), 'output should be Mulberry');
        $this->assertEquals('7 gr/m3', $outs[0]->get_amount(), 'output should be 7');
        $this->assertEquals('Molds', $outs[1]->get_type(), 'output should be Molds');
        $this->assertEquals('Very High', $outs[1]->get_category(), 'output should be Very High');
        $this->assertEquals('', $outs[1]->get_amount(), 'output should be empty');

        $str = "Allergy Count: Ragweed Low 7 gr/m3,&nbsp;Mulberry 7 gr/m3, Pigweed Medium 2 gr/m3";
        $outs = $this->object->extract($str);
        $this->assertEquals(3, count($outs), 'Three allergans should be detected');
        $this->assertEquals('Ragweed', $outs[0]->get_type(), 'output should be Ragweed');
        $this->assertEquals('Low', $outs[0]->get_category(), 'output should be Low');
        $this->assertEquals('7 gr/m3', $outs[0]->get_amount(), 'output should be 7');
        $this->assertEquals('Mulberry', $outs[1]->get_type(), 'output should be Mulberry');
        $this->assertEquals('7 gr/m3', $outs[1]->get_amount(), 'output should be 7');
        $this->assertEquals('Pigweed', $outs[2]->get_type(), 'output should be Pigweed');
        $this->assertEquals('Medium', $outs[2]->get_category(), 'output should be Low');
        $this->assertEquals('2 gr/m3', $outs[2]->get_amount(), 'output should be 2');


        $str = "Allergy Count: Fall Elm Low 7 gr/m3, Molds High.";
        $outs = $this->object->extract($str);
        $this->assertEquals(2, count($outs), 'Two allergans should be detected');
        $this->assertEquals('Fall Elm', $outs[0]->get_type(), 'output should be Fall Elm');
        $this->assertEquals('Low', $outs[0]->get_category(), 'output should be Low');
        $this->assertEquals('7 gr/m3', $outs[0]->get_amount(), 'output should be 7');
        $this->assertEquals('Molds', $outs[1]->get_type(), 'output should be Molds');
        $this->assertEquals('High', $outs[1]->get_category(), 'output should be High');
        $this->assertEquals('', $outs[1]->get_amount(), 'output should be empty');

        $str = "Allergy Count: Grass Low 7 gr/m3, Fall Elm Low 7 gr/m3, and Molds High.";
        $outs = $this->object->extract($str);
        $this->assertEquals(3, count($outs), '3 allergans should be detected');
        $this->assertEquals('Grass', $outs[0]->get_type(), 'output should be Grass');
        $this->assertEquals('Low', $outs[0]->get_category(), 'output should be Low');
        $this->assertEquals('7 gr/m3', $outs[0]->get_amount(), 'output should be 7');
        $this->assertEquals('Fall Elm', $outs[1]->get_type(), 'output should be Fall Elm');
        $this->assertEquals('Low', $outs[1]->get_category(), 'output should be Low');
        $this->assertEquals('7 gr/m3', $outs[1]->get_amount(), 'output should be 7');
        $this->assertEquals('Molds', $outs[2]->get_type(), 'output should be Molds');
        $this->assertEquals('High', $outs[2]->get_category(), 'output should be High');
        $this->assertEquals('', $outs[2]->get_amount(), 'output should be empty');

    }
}
