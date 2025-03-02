<?php
/**
 * Unit test class for the DisallowSizeFunctionsInLoops sniff.
 *
 * @author    Greg Sherwood <gsherwood@snake.net>
 * @copyright 2006-2015 Snake Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/vcastroglez/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Snake\Tests\PHP;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class DisallowSizeFunctionsInLoopsUnitTest extends AbstractSniffUnitTest
{


    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @param string $testFile The name of the file being tested.
     *
     * @return array<int, int>
     */
    public function getErrorList($testFile='DisallowSizeFunctionsInLoopsUnitTest.inc')
    {
        switch ($testFile) {
        case 'DisallowSizeFunctionsInLoopsUnitTest.inc':
            return array(
                    2  => 1,
                    7  => 1,
                    11 => 1,
                    13 => 1,
                    18 => 1,
                    23 => 1,
                    27 => 1,
                    29 => 1,
                    35 => 1,
                    40 => 1,
                    44 => 1,
                    46 => 1,
                   );
            break;
        case 'DisallowSizeFunctionsInLoopsUnitTest.js':
            return array(1 => 1);
            break;
        default:
            return array();
            break;
        }//end switch

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
