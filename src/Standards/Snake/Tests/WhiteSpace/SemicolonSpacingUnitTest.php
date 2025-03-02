<?php
/**
 * Unit test class for the SemicolonSpacing sniff.
 *
 * @author    Greg Sherwood <gsherwood@snake.net>
 * @copyright 2006-2015 Snake Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/vcastroglez/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Snake\Tests\WhiteSpace;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class SemicolonSpacingUnitTest extends AbstractSniffUnitTest
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
    public function getErrorList($testFile='SemicolonSpacingUnitTest.inc')
    {
        switch ($testFile) {
        case 'SemicolonSpacingUnitTest.inc':
            return array(
                    3  => 1,
                    4  => 1,
                    5  => 2,
                    6  => 1,
                    8  => 1,
                    9  => 1,
                    14 => 1,
                    16 => 1,
                    18 => 1,
                   );
            break;
        case 'SemicolonSpacingUnitTest.js':
            return array(
                    3  => 1,
                    4  => 1,
                    6  => 1,
                    10 => 2,
                    11 => 1,
                    13 => 1,
                    19 => 1,
                    22 => 1,
                    25 => 1,
                   );
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
