<?php
/**
 * Checks the naming of variables and member variables.
 *
 * @author    Greg Sherwood <gsherwood@snake.net>
 * @copyright 2006-2015 Snake Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/vcastroglez/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Standards\Snake\Sniffs\NamingConventions;

use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;
use PHP_CodeSniffer\Util\Common;
use PHP_CodeSniffer\Files\File;

class ValidVariableNameSniff extends AbstractVariableSniff
{

    /**
     * Tokens to ignore so that we can find a DOUBLE_COLON.
     *
     * @var array
     */
    private $ignore = array(
                       T_WHITESPACE,
                       T_COMMENT,
                      );


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token in the
     *                                               stack passed in $tokens.
     *
     * @return void
     */
    protected function processVariable(File $phpcsFile, $stackPtr)
    {
        $tokens  = $phpcsFile->getTokens();
        $varName = ltrim($tokens[$stackPtr]['content'], '$');

        $phpReservedVars = array(
                            '_SERVER',
                            '_GET',
                            '_POST',
                            '_REQUEST',
                            '_SESSION',
                            '_ENV',
                            '_COOKIE',
                            '_FILES',
                            'GLOBALS',
                            'http_response_header',
                            'HTTP_RAW_POST_DATA',
                            'php_errormsg',
                           );

        // If it's a php reserved var, then its ok.
        if (in_array($varName, $phpReservedVars) === true) {
            return;
        }

        $objOperator = $phpcsFile->findNext(array(T_WHITESPACE), ($stackPtr + 1), null, true);
        if ($tokens[$objOperator]['code'] === T_OBJECT_OPERATOR) {
            // Check to see if we are using a variable from an object.
            $var = $phpcsFile->findNext(array(T_WHITESPACE), ($objOperator + 1), null, true);
            if ($tokens[$var]['code'] === T_STRING) {
                $bracket = $phpcsFile->findNext(array(T_WHITESPACE), ($var + 1), null, true);
                if ($tokens[$bracket]['code'] !== T_OPEN_PARENTHESIS) {
                    $objVarName = $tokens[$var]['content'];

                    // There is no way for us to know if the var is public or
                    // private, so we have to ignore a leading underscore if there is
                    // one and just check the main part of the variable name.
                    $originalVarName = $objVarName;
                    if (substr($objVarName, 0, 1) === '_') {
                        $objVarName = substr($objVarName, 1);
                    }

                    if (Common::isUnderscoreName($objVarName, false, true, false) === false) {
                        $error = 'Variable "%s" is not in valid camel caps format';
                        $data  = array($originalVarName);
                        $phpcsFile->addError($error, $var, 'NotCamelCaps', $data);
                    }
                }//end if
            }//end if
        }//end if

        // There is no way for us to know if the var is public or private,
        // so we have to ignore a leading underscore if there is one and just
        // check the main part of the variable name.
        $originalVarName = $varName;
        if (substr($varName, 0, 1) === '_') {
            $objOperator = $phpcsFile->findPrevious(array(T_WHITESPACE), ($stackPtr - 1), null, true);
            if ($tokens[$objOperator]['code'] === T_DOUBLE_COLON) {
                // The variable lives within a class, and is referenced like
                // this: MyClass::$_variable, so we don't know its scope.
                $inClass = true;
            } else {
                $inClass = $phpcsFile->hasCondition($stackPtr, array(T_CLASS, T_INTERFACE, T_TRAIT));
            }

            if ($inClass === true) {
                $varName = substr($varName, 1);
            }
        }

        if (Common::isUnderscoreName($varName, false, true, false) === false) {
            $error = 'Variable "%s" is not in valid camel caps format';
            $data  = array($originalVarName);
            $phpcsFile->addError($error, $stackPtr, 'NotCamelCaps', $data);
        }

    }//end processVariable()


    /**
     * Processes class member variables.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the current token in the
     *                                               stack passed in $tokens.
     *
     * @return void
     */
    protected function processMemberVar(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $varName     = ltrim($tokens[$stackPtr]['content'], '$');
        $memberProps = $phpcsFile->getMemberProperties($stackPtr);
        if (empty($memberProps) === true) {
            // Couldn't get any info about this variable, which
            // generally means it is invalid or possibly has a parse
            // error. Any errors will be reported by the core, so
            // we can ignore it.
            return;
        }

        $public    = ($memberProps['scope'] !== 'private');
        $errorData = array($varName);

        if ($public === true) {
            if (substr($varName, 0, 1) === '_') {
                $error = '%s member variable "%s" must not contain a leading underscore';
                $data  = array(
                          ucfirst($memberProps['scope']),
                          $errorData[0],
                         );
                $phpcsFile->addError($error, $stackPtr, 'PublicHasUnderscore', $data);
                return;
            }
        } else {
            if (substr($varName, 0, 1) !== '_') {
                $error = 'Private member variable "%s" must contain a leading underscore';
                $phpcsFile->addError($error, $stackPtr, 'PrivateNoUnderscore', $errorData);
                return;
            }
        }

        if (Common::isUnderscoreName($varName, false, $public, false) === false) {
            $error = 'Member variable "%s" is not in valid camel caps format';
            $phpcsFile->addError($error, $stackPtr, 'MemberNotCamelCaps', $errorData);
        }

    }//end processMemberVar()


    /**
     * Processes the variable found within a double quoted string.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the double quoted
     *                                               string.
     *
     * @return void
     */
    protected function processVariableInString(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $phpReservedVars = array(
                            '_SERVER',
                            '_GET',
                            '_POST',
                            '_REQUEST',
                            '_SESSION',
                            '_ENV',
                            '_COOKIE',
                            '_FILES',
                            'GLOBALS',
                            'http_response_header',
                            'HTTP_RAW_POST_DATA',
                            'php_errormsg',
                           );

        if (preg_match_all('|[^\\\]\${?([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)|', $tokens[$stackPtr]['content'], $matches) !== 0) {
            foreach ($matches[1] as $varName) {
                // If it's a php reserved var, then its ok.
                if (in_array($varName, $phpReservedVars) === true) {
                    continue;
                }

                if (Common::isUnderscoreName($varName, false, true, false) === false) {
                    $error = 'Variable "%s" is not in valid camel caps format';
                    $data  = array($varName);
                    $phpcsFile->addError($error, $stackPtr, 'StringNotCamelCaps', $data);
                }
            }
        }

    }//end processVariableInString()


}//end class
