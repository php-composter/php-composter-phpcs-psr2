<?php
/**
 * PHP Composter PHP Code Sniffer PSR2 Action.
 *
 * @package   PHPComposter\PHPComposter_PHPCS_PSR2
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.brightnucleus.com/
 * @copyright 2016 Alain Schlesser, Bright Nucleus
 */

namespace PHPComposter\PHPComposter_PHPCS_PSR2;

use PHP_CodeSniffer_CLI;
use PHPComposter\PHPComposter\BaseAction;

/**
 * Class Sniffer.
 *
 * @since   0.1.0
 *
 * @package PHPComposter\PHPComposter_PHPCS_PSR2
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class Sniffer extends BaseAction
{

    /**
     * Run PHP Code Sniffer over PHP files as pre-commit hook.
     *
     * @since 0.1.0
     */
    public function preCommit()
    {
        $files = $this->getStagedFiles('/*.php$');
        if (empty($files)) {
            return;
        }

        echo 'Running PHP CodeSniffer in ' . $this->root . PHP_EOL;
        $sniffer = new PHP_CodeSniffer_CLI();

        ob_start();
        $numErrors = $sniffer->process(array('standard' => 'PSR2', 'files' => $files));
        $output    = ob_get_clean();

        echo $output . PHP_EOL;

        if ($numErrors === 0) {
            exit(0);
        } else {
            echo 'PHP Code Sniffer found errors! Aborting Commit.' . PHP_EOL;
            exit(1);
        }
    }
}
