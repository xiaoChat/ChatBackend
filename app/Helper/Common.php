<?php

declare(strict_types=1);

namespace App\Helper;

use App\Constants\ApiCode;

class Common
{
    public function json(int $code = 200, $data = [], string $message = ''): array
    {
        return [
            'code' => $code,
            'data' => $data,
            'message' => $message ?: ApiCode::getMessage($code),
        ];
    }
}
