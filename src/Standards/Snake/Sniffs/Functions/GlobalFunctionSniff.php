<?php
/**
 * Tests for functions outside of classes.
 *
 * @author    Greg Sherwood <gsherwood@snake.net>
 * @copyright 2006-2015 Snake Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/vcastroglez/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Snake\Sniffs\Functions;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class GlobalFunctionSniff implements Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_FUNCTION);

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token in the
     *                                               stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (empty($tokens[$stackPtr]['conditions']) === true) {
            $functionName = $phpcsFile->getDeclarationName($stackPtr);
            if ($functionName === null) {
                return;
            }

            // Special exception for __autoload as it needs to be global.
            if ($functionName !== '__autoload') {
                $error = 'Consider putting global function "%s" in a static class';
                $data  = array($functionName);
                $phpcsFile->addWarning($error, $stackPtr, 'Found', $data);
            }
        }

    }//end process()


}//end class
