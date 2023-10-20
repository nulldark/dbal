<?php

namespace Nulldark\DBAL\Database\Postgres;

use Nulldark\DBAL\Builder\Grammars\GrammarInterface;
use Nulldark\DBAL\Builder\Grammars\PostgresGrammar;
use Nulldark\DBAL\Database\AbstractPlatform;

/**
 *  The PostgresPlatform class describes the specifics and dialects of the Postgres database platform.
 *
 * @author Dominik Szamburski
 * @package Nulldark\DBAL\Database\Postgres
 * @license LGPL-2.1
 * @version 0.5.0
 */
final class PostgresPlatform extends AbstractPlatform
{
    /**
     * @inheritDoc
     */
    public function getGrammar(): GrammarInterface
    {
        return new PostgresGrammar();
    }
}