<?php namespace CodeIgniter\Typography;

class TypographyTest extends \CIUnitTestCase
{
    protected $typography;

    public function setUp()
    {
        parent::setUp();
        $this->typography = new Typography();
    }

    public function testAutoTypographyEmptyString()
    {
        $this->assertEquals('', $this->typography->autoTypography(''));
    }

    public function testAutoTypographyNormalString()
    {
        $strs = [
            'this sentence has no punctuations' => '<p>this sentence has no punctuations</p>',
            'Hello World !!, How are you?'      => '<p>Hello World !!, How are you?</p>'
        ];
        foreach ($strs as $str => $expect)
        {
            $this->assertEquals($expect, $this->typography->autoTypography($str));
        }
    }

    public function testAutoTypographyMultipleSpaces()
    {
        $strs = [
            'this sentence has  a double spacing'              => '<p>this sentence has  a double spacing</p>',
            'this  sentence   has    a     weird      spacing' => '<p>this  sentence &nbsp; has &nbsp;  a &nbsp;   weird &nbsp;  &nbsp; spacing</p>',
        ];
        foreach ($strs as $str => $expect)
        {
            $this->assertEquals($expect, $this->typography->autoTypography($str));
        }
    }

    public function testAutoTypographyLineBreaks()
    {
        $strs = [
            "\n"                                   => "\n\n<p>&nbsp;</p>",
            "\n\n"                                 => "\n\n<p>&nbsp;</p>",
            "\n\n\n"                               => "\n\n<p>&nbsp;</p>",
            "Line One\n"                           => "<p>Line One</p>\n\n",
            "Line One\nLine Two"                   => "<p>Line One<br />\nLine Two</p>",
            "Line One\r\n"                         => "<p>Line One</p>\n\n",
            "Line One\r\nLine Two"                 => "<p>Line One<br />\nLine Two</p>",
            "Line One\r"                           => "<p>Line One</p>\n\n",
            "Line One\rLine Two"                   => "<p>Line One<br />\nLine Two</p>",
            "Line One\n\nLine Two\n\n\nLine Three" => "<p>Line One</p>\n\n<p>Line Two</p>\n\n<p>Line Three</p>"
        ];
        foreach ($strs as $str => $expect)
        {
            $this->assertEquals($expect, $this->typography->autoTypography($str));
        }
    }

    public function testAutoTypographyReduceLineBreaks()
    {
        $strs = [
            "\n"                                   => "\n\n",
            "\n\n"                                 => "\n\n",
            "\n\n\n"                               => "\n\n\n\n",
            "Line One\n"                           => "<p>Line One</p>\n\n",
            "Line One\nLine Two"                   => "<p>Line One<br />\nLine Two</p>",
            "Line One\r\n"                         => "<p>Line One</p>\n\n",
            "Line One\r\nLine Two"                 => "<p>Line One<br />\nLine Two</p>",
            "Line One\r"                           => "<p>Line One</p>\n\n",
            "Line One\rLine Two"                   => "<p>Line One<br />\nLine Two</p>",
            "Line One\n\nLine Two\n\n\nLine Three" => "<p>Line One</p>\n\n<p>Line Two</p>\n\n<p><br />\nLine Three</p>"
        ];
        foreach ($strs as $str => $expect)
        {
            $this->assertEquals($expect, $this->typography->autoTypography($str, true));
        }
    }
}
