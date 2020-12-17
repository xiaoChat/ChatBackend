<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
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
class ModelCode extends AbstractConstants
{
    const MODEL_TYPE = -1;

    /**
     * @Message("success!")
     */
    const SUCCESS = 0;

    /**
     * @Message("fail!")
     */
    const FAIL = 1;

    /**
     * @Message("不能添加自己为好友")
     */
    const USER_NOT_SELF_ERROR = 20001;

    /**
     * @Message("当前用户已经是你的好友")
     */
    const FRIEND_IS_ADDED = 20002;
}
