<?php

namespace Nulldark\DBAL\Database\MySQL;

use Nulldark\DBAL\Builder\Grammars\GrammarInterface;
use Nulldark\DBAL\Builder\Grammars\MySqlGrammar;
use Nulldark\DBAL\Database\AbstractPlatform;

/**
 * The MySQLPlatform class describes the specifics and dialects of the MySQL database platform.
 *
 * @author Dominik Szamburski
 * @package Nulldark\DBAL\Database\MySQL
 * @license LGPL-2.1
 * @version 0.5.0
 */
final class MySQLPlatform extends AbstractPlatform
{
    /**
     * @inheritDoc
     */
    public function getGrammar(): GrammarInterface
    {
        return new MySqlGrammar();
    }
}
