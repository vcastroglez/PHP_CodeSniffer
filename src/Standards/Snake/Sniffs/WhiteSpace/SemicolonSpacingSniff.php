<?php
/**
 * Ensure there is no whitespace before a semicolon.
 *
 * @author    Greg Sherwood <gsherwood@snake.net>
 * @copyright 2006-2015 Snake Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/vcastroglez/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Snake\Sniffs\WhiteSpace;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

class SemicolonSpacingSniff implements Sniff
{

    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array(
                                   'PHP',
                                   'JS',
                                  );


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_SEMICOLON);

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

        $prevType = $tokens[($stackPtr - 1)]['code'];
        if (isset(Tokens::$emptyTokens[$prevType]) === false) {
            return;
        }

        $nonSpace = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($stackPtr - 2), null, true);
        if ($tokens[$nonSpace]['code'] === T_SEMICOLON) {
            // Empty statement.
            return;
        }

        $expected = $tokens[$nonSpace]['content'].';';
        $found    = $phpcsFile->getTokensAsString($nonSpace, ($stackPtr - $nonSpace)).';';
        $error    = 'Space found before semicolon; expected "%s" but found "%s"';
        $data     = array(
                     $expected,
                     $found,
                    );

        $fix = $phpcsFile->addFixableError($error, $stackPtr, 'Incorrect', $data);
        if ($fix === true) {
            $phpcsFile->fixer->beginChangeset();
            $i = ($stackPtr - 1);
            while (($tokens[$i]['code'] === T_WHITESPACE) && ($i > $nonSpace)) {
                $phpcsFile->fixer->replaceToken($i, '');
                $i--;
            }

            $phpcsFile->fixer->addContent($nonSpace, ';');
            $phpcsFile->fixer->replaceToken($stackPtr, '');

            $phpcsFile->fixer->endChangeset();
        }

    }//end process()


}//end class
