<?php
/**
 * Tests that all arithmetic operations are bracketed.
 *
 * @author    Greg Sherwood <gsherwood@snake.net>
 * @copyright 2006-2015 Snake Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Snake\Sniffs\Formatting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

class OperatorBracketSniff implements Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {

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

        // If the & is a reference, then we don't want to check for brackets.
        if ($tokens[$stackPtr]['code'] === T_BITWISE_AND && $phpcsFile->isReference($stackPtr) === true) {
            return;
        }

        // There is one instance where brackets aren't needed, which involves
        // the minus sign being used to assign a negative number to a variable.
        if ($tokens[$stackPtr]['code'] === T_MINUS) {
            // Check to see if we are trying to return -n.
            $prev = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($stackPtr - 1), null, true);
            if ($tokens[$prev]['code'] === T_RETURN) {
                return;
            }

            $number = $phpcsFile->findNext(T_WHITESPACE, ($stackPtr + 1), null, true);
            if ($tokens[$number]['code'] === T_LNUMBER || $tokens[$number]['code'] === T_DNUMBER) {
                $previous = $phpcsFile->findPrevious(T_WHITESPACE, ($stackPtr - 1), null, true);
                if ($previous !== false) {
                    $isAssignment = isset(Tokens::$assignmentTokens[$tokens[$previous]['code']]);
                    $isEquality   = isset(Tokens::$equalityTokens[$tokens[$previous]['code']]);
                    $isComparison = isset(Tokens::$comparisonTokens[$tokens[$previous]['code']]);
                    $isUnary      = isset(Tokens::$operators[$tokens[$previous]['code']]);
                    if ($isAssignment === true || $isEquality === true || $isComparison === true || $isUnary === true) {
                        // This is a negative assignment or comparison.
                        // We need to check that the minus and the number are
                        // adjacent.
                        if (($number - $stackPtr) !== 1) {
                            $error = 'No space allowed between minus sign and number';
                            $phpcsFile->addError($error, $stackPtr, 'SpacingAfterMinus');
                        }

                        return;
                    }
                }
            }
        }//end if

        $previousToken = $phpcsFile->findPrevious(T_WHITESPACE, ($stackPtr - 1), null, true, null, true);
        if ($previousToken !== false) {
            // A list of tokens that indicate that the token is not
            // part of an arithmetic operation.
            $invalidTokens = [
                T_COMMA               => true,
                T_COLON               => true,
                T_OPEN_PARENTHESIS    => true,
                T_OPEN_SQUARE_BRACKET => true,
                T_OPEN_CURLY_BRACKET  => true,
                T_OPEN_SHORT_ARRAY    => true,
                T_CASE                => true,
                T_EXIT                => true,
            ];

            if (isset($invalidTokens[$tokens[$previousToken]['code']]) === true) {
                return;
            }
        }

        if ($tokens[$stackPtr]['code'] === T_BITWISE_OR
            && isset($tokens[$stackPtr]['nested_parenthesis']) === true
        ) {
            $brackets    = $tokens[$stackPtr]['nested_parenthesis'];
            $lastBracket = array_pop($brackets);
            if (isset($tokens[$lastBracket]['parenthesis_owner']) === true
                && $tokens[$tokens[$lastBracket]['parenthesis_owner']]['code'] === T_CATCH
            ) {
                // This is a pipe character inside a catch statement, so it is acting
                // as an exception type separator and not an arithmetic operation.
                return;
            }
        }

        // Tokens that are allowed inside a bracketed operation.
        $allowed = [
            T_VARIABLE,
            T_LNUMBER,
            T_DNUMBER,
            T_STRING,
            T_NAME_QUALIFIED,
            T_NAME_FULLY_QUALIFIED,
            T_NAME_RELATIVE,
            T_WHITESPACE,
            T_THIS,
            T_SELF,
            T_STATIC,
            T_OBJECT_OPERATOR,
            T_NULLSAFE_OBJECT_OPERATOR,
            T_DOUBLE_COLON,
            T_OPEN_SQUARE_BRACKET,
            T_CLOSE_SQUARE_BRACKET,
            T_MODULUS,
            T_NONE,
            T_BITWISE_NOT,
        ];

        $allowed += Tokens::$operators;

        $lastBracket = false;

    }//end process()


}//end class
