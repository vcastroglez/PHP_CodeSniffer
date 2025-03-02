<?php
/**
 * Unit test class for the DisallowObjectStringIndex sniff.
 *
 * @author    Sertan Danis <sdanis@snake.net>
 * @copyright 2006-2015 Snake Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/vcastroglez/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Snake\Tests\Objects;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class DisallowObjectStringIndexUnitTest extends AbstractSniffUnitTest
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
    public function getErrorList($testFile='DisallowObjectStringIndexUnitTest.js')
    {
        if ($testFile !== 'DisallowObjectStringIndexUnitTest.js') {
            return array();
        }

        return array(
                13 => 1,
                17 => 1,
                25 => 1,
                35 => 1,
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
