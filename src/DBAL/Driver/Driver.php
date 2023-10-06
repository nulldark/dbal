<?php

namespace Nulldark\DBAL\Driver;

use Exception;
use SensitiveParameter;

interface Driver
{
    /**
     * Initialize connection with database.
     *
     * @param array $params
     * @return Connection
     * @throws Exception
     */
    public function connect(
        #[SensitiveParameter]
        array $params
    ): Connection;
}