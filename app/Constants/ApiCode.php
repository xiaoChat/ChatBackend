<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ApiCode extends AbstractConstants
{
    const MODEL_TYPE = -2;

    /**
     * @Message("Server Error!")
     */
    const SERVER_ERROR = 500;

    /**
     * @Message("server not found!")
     */
    const NOT_FOUND = 404;
    
    /**
     * @Message("method not allow!")
     */
    const NOT_ALLOW = 405;
    
    /**
     * @Message("auth check fail!")
     */
    const AUTH_ERROR = 401;
    
    /**
     * @Message("success!")
     */
    const SUCCESS = 0;

    /**
     * @Message("fail!")
     */
    const FAIL = 1;
    
    /**
     * @Message("This parameter must be passed!")
     */
    const PARAMS_REQUEST = 1000;
    
    /**
     * @Message("The user name already exists!")
     */
    const USER_REGISTER_FAIL = 1001;
    
    /**
     * @Message("The user info is not exsit!")
     */
    const USER_INFO_ERROR = 1002;

}
