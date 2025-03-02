<?php
/**
 * Ensure there is a single blank line after the closing brace of a class definition.
 *
 * @author    Greg Sherwood <gsherwood@snake.net>
 * @copyright 2006-2015 Snake Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/vcastroglez/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Snake\Sniffs\CSS;

 use PHP_CodeSniffer\Sniffs\Sniff;
 use PHP_CodeSniffer\Files\File;
 use PHP_CodeSniffer\Util\Tokens;

class ClassDefinitionClosingBraceSpaceSniff implements Sniff
{

    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array('CSS');


    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return int[]
     */
    public function register()
    {
        return array(T_CLOSE_CURLY_BRACKET);

    }//end register()


    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file where the token was found.
     * @param int                         $stackPtr  The position in the stack where
     *                                               the token was found.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $next = $phpcsFile->findNext(T_WHITESPACE, ($stackPtr + 1), null, true);
        if ($next === false) {
            return;
        }

        if ($tokens[$next]['code'] !== T_CLOSE_TAG) {
            $found = (($tokens[$next]['line'] - $tokens[$stackPtr]['line']) - 1);
            if ($found !== 1) {
                $error = 'Expected one blank line after closing brace of class definition; %s found';
                $data  = array($found);
                $fix   = $phpcsFile->addFixableError($error, $stackPtr, 'SpacingAfterClose', $data);

                if ($fix === true) {
                    if ($found === 0) {
                        $phpcsFile->fixer->addNewline($stackPtr);
                    } else {
                        $nextContent = $phpcsFile->findNext(T_WHITESPACE, ($stackPtr + 1), null, true);
                        $phpcsFile->fixer->beginChangeset();
                        for ($i = ($stackPtr + 1); $i < ($nextContent - 1); $i++) {
                            $phpcsFile->fixer->replaceToken($i, '');
                        }

                        $phpcsFile->fixer->addNewline($i);
                        $phpcsFile->fixer->endChangeset();
                    }
                }
            }//end if
        }//end if

        // Ignore nested style definitions from here on. The spacing before the closing brace
        // (a single blank line) will be enforced by the above check, which ensures there is a
        // blank line after the last nested class.
        $found = $phpcsFile->findPrevious(
            T_CLOSE_CURLY_BRACKET,
            ($stackPtr - 1),
            $tokens[$stackPtr]['bracket_opener']
        );

        if ($found !== false) {
            return;
        }

        $prev = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($stackPtr - 1), null, true);
        if ($prev === false) {
            return;
        }

        if ($tokens[$prev]['line'] === $tokens[$stackPtr]['line']) {
            $error = 'Closing brace of class definition must be on new line';
            $fix   = $phpcsFile->addFixableError($error, $stackPtr, 'ContentBeforeClose');
            if ($fix === true) {
                $phpcsFile->fixer->addNewlineBefore($stackPtr);
            }
        }

    }//end process()


}//end class
