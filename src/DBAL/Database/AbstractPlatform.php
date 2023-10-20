<?php

namespace Nulldark\DBAL\Database;

use Nulldark\DBAL\Builder\Grammars\GrammarInterface;

abstract class AbstractPlatform
{
    /**
     * Gets a grammar for specify database platform.
     *
     * @return \Nulldark\DBAL\Builder\Grammars\GrammarInterface
     */
    abstract public function getGrammar(): GrammarInterface;
}
