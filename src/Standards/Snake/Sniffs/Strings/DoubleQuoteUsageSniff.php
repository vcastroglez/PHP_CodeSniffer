<?php
/**
 * Makes sure that any use of double quotes strings are warranted.
 *
 * @author    Greg Sherwood <gsherwood@snake.net>
 * @copyright 2006-2015 Snake Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/vcastroglez/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Snake\Sniffs\Strings;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class DoubleQuoteUsageSniff implements Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
                T_CONSTANT_ENCAPSED_STRING,
                T_DOUBLE_QUOTED_STRING,
               );

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token
     *                                               in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // We are only interested in the first token in a multi-line string.
        if ($tokens[$stackPtr]['code'] === $tokens[($stackPtr - 1)]['code']) {
            return;
        }

        $workingString   = $tokens[$stackPtr]['content'];
        $lastStringToken = $stackPtr;

        $i = ($stackPtr + 1);
        if (isset($tokens[$i]) === true) {
            while ($i < $phpcsFile->numTokens
                && $tokens[$i]['code'] === $tokens[$stackPtr]['code']
            ) {
                $workingString  .= $tokens[$i]['content'];
                $lastStringToken = $i;
                $i++;
            }
        }

        // Check if it's a double quoted string.
        if (strpos($workingString, '"') === false) {
            return;
        }

        // Make sure it's not a part of a string started in a previous line.
        // If it is, then we have already checked it.
        if ($workingString[0] !== '"') {
            return;
        }

        $allowedChars = array(
                         '\0',
                         '\1',
                         '\2',
                         '\3',
                         '\4',
                         '\5',
                         '\6',
                         '\7',
                         '\n',
                         '\r',
                         '\f',
                         '\t',
                         '\v',
                         '\x',
                         '\b',
                         '\e',
                         '\u',
                         '\'',
                        );

        foreach ($allowedChars as $testChar) {
            if (strpos($workingString, $testChar) !== false) {
                return;
            }
        }

        $error = 'String %s does not require double quotes; use single quotes instead';
        $data  = array(str_replace(array("\r", "\n"), array('\r', '\n'), $workingString));
        $fix   = $phpcsFile->addFixableError($error, $stackPtr, 'NotRequired', $data);

        if ($fix === true) {
            $phpcsFile->fixer->beginChangeset();
            $innerContent = substr($workingString, 1, -1);
            $innerContent = str_replace('\"', '"', $innerContent);
            $phpcsFile->fixer->replaceToken($stackPtr, "'$innerContent'");
            while ($lastStringToken !== $stackPtr) {
                $phpcsFile->fixer->replaceToken($lastStringToken, '');
                $lastStringToken--;
            }

            $phpcsFile->fixer->endChangeset();
        }

    }//end process()


}//end class
