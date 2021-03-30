<?php
\PMVC\Load::plug();
\PMVC\addPlugInFolders([__DIR__.'/../']);
class ReTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'regexp';
    function testPlugin()
    {
        ob_start();
        print_r(PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    function testGen()
    {
        $plug = PMVC\plug($this->_plug);
        $regs = [ 
           ['either', 'https','http'], 
           ['maybe', 'http'] 
        ];
        $s = $plug->gen(...$regs);
        $this->assertEquals($s, '/(https|http)(http)?/');
    }

}
