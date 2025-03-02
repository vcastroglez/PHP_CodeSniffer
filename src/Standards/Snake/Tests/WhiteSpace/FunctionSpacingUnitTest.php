<?php
/**
 * Unit test class for the FunctionSpacing sniff.
 *
 * @author    Greg Sherwood <gsherwood@snake.net>
 * @copyright 2006-2015 Snake Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/vcastroglez/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Snake\Tests\WhiteSpace;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class FunctionSpacingUnitTest extends AbstractSniffUnitTest
{


    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array<int, int>
     */
    public function getErrorList()
    {
        return array(
                20  => 1,
                29  => 1,
                38  => 1,
                45  => 1,
                49  => 1,
                55  => 1,
                58  => 1,
                60  => 1,
                75  => 1,
                94  => 1,
                105 => 1,
                107 => 1,
                113 => 2,
                135 => 1,
                154 => 1,
                167 => 2,
                184 => 1,
                218 => 1,
                233 => 1,
                252 => 1,
                275 => 1,
                276 => 1,
                289 => 1,
                291 => 1,
                297 => 1,
               );

    }//end getErrorList()


    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array<int, int>
     */
    public function getWarningList()
    {
        return array();

    }//end getWarningList()


}//end class
