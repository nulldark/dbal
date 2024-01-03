<?php

/*
 * This file is part of the Symfony package.
 *
 * Copyright (C) 2023-2024 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE.md file for details.
 */

namespace Abyss\DBAL\Database\MySQL;

use Abyss\DBAL\Query\Grammars\GrammarInterface;
use Abyss\DBAL\Query\Grammars\MySqlGrammar;
use Abyss\DBAL\Database\AbstractPlatform;

/**
 * The MySQLPlatform class describes the specifics and dialects of the MySQL database platform.
 *
 * @author Dominik Szamburski
 * @package Abyss\DBAL\Database\MySQL
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
