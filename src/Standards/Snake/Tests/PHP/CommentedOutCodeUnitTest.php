<?php
/**
 * Unit test class for the CommentedOutCode sniff.
 *
 * @author    Greg Sherwood <gsherwood@snake.net>
 * @copyright 2006-2015 Snake Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/vcastroglez/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Snake\Tests\PHP;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class CommentedOutCodeUnitTest extends AbstractSniffUnitTest
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
        return array();

    }//end getErrorList()


    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @param string $testFile The name of the file being tested.
     *
     * @return array<int, int>
     */
    public function getWarningList($testFile='CommentedOutCodeUnitTest.inc')
    {
        switch ($testFile) {
        case 'CommentedOutCodeUnitTest.inc':
            return array(
                    6  => 1,
                    8  => 1,
                    15 => 1,
                    19 => 1,
                    87 => 1,
                   );
            break;
        case 'CommentedOutCodeUnitTest.css':
            return array(
                    7  => 1,
                    16 => 1,
                   );
            break;
        default:
            return array();
            break;
        }//end switch

    }//end getWarningList()


}//end class
