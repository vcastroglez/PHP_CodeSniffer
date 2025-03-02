<?php
/**
 * Ensure there is a single space after scope keywords.
 *
 * @author    Greg Sherwood <gsherwood@snake.net>
 * @copyright 2006-2015 Snake Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/vcastroglez/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Snake\Sniffs\WhiteSpace;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

class ScopeKeywordSpacingSniff implements Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        $register   = Tokens::$scopeModifiers;
        $register[] = T_STATIC;
        return $register;

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

        $prevToken = $phpcsFile->findPrevious(T_WHITESPACE, ($stackPtr - 1), null, true);
        $nextToken = $phpcsFile->findNext(T_WHITESPACE, ($stackPtr + 1), null, true);

        if ($tokens[$stackPtr]['code'] === T_STATIC
            && ($tokens[$nextToken]['code'] === T_DOUBLE_COLON
            || $tokens[$prevToken]['code'] === T_NEW)
        ) {
            // Late static binding, e.g., static:: OR new static() usage.
            return;
        }

        if ($tokens[$prevToken]['code'] === T_AS) {
            // Trait visibilty change, e.g., "use HelloWorld { sayHello as private; }".
            return;
        }

        $nextToken = $tokens[($stackPtr + 1)];
        if (strlen($nextToken['content']) !== 1
            || $nextToken['content'] === $phpcsFile->eolChar
        ) {
            $error = 'Scope keyword "%s" must be followed by a single space';
            $data  = array($tokens[$stackPtr]['content']);
            $fix   = $phpcsFile->addFixableError($error, $stackPtr, 'Incorrect', $data);
            if ($fix === true) {
                $phpcsFile->fixer->replaceToken(($stackPtr + 1), ' ');
            }
        }

    }//end process()


}//end class
