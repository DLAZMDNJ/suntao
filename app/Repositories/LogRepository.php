<?php

namespace jamx\Repositories;

use jamx\Models\Log;

/**
 * 系统配置仓库SystemOptionRepository
 *
 * @author raoyc<king@jinsec.com>
 */
class LogRepository extends MisRepository
{
   
    public function __construct(
        Log $log)
    {
        $this->model = $log;
    }



}
