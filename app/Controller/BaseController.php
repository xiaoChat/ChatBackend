<?php

declare(strict_types=1);

namespace App\Controller;

use App\Constants\ApiCode;
use App\Constants\ModelCode;
use App\Helper\Common;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface as MessageResponseInterface;

/**
 * @OA\Server(
 *     url="http://127.0.0.1:9501",
 *     description="本地调试"
 * )
 * @OA\Info(
 *     version="1.0",
 *     title="",
 *     description="",
 *     @OA\Contact(
 *         name="Yexk",
 *         email="yexk@yexk.cn"
 *     )
 * )
 * @OA\Schema(
 *     schema="RespModel",
 *     @OA\Property(
 *         property="code",
 *         type="int",
 *         description="响应状态"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         description="响应message"
 *     ),
 *     @OA\Property(
 *         property="data",
 *         type="Object",
 *         description="响应数据结构"
 *     ),
 * )
 */
class BaseController
{
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @Inject
     * @var Common
     */
    protected $common;

    protected function returnJson(int $code = ApiCode::SUCCESS, $data = [], string $msg = ''): MessageResponseInterface
    {
        $data = $this->common->json($code, $data, $msg ?: ApiCode::getMessage($code));
        return $this->response->json($data);
    }

    protected function success($data = null): MessageResponseInterface
    {
        $data = $this->common->json(ApiCode::SUCCESS, $data);

        return $this->response->json($data);
    }

    protected function fail($code = ApiCode::FAIL, $data = null, $type = ApiCode::MODEL_TYPE): MessageResponseInterface
    {
        $message = '';
        if ($type == ModelCode::MODEL_TYPE) {
            $message = ModelCode::getMessage($code);
        }
        $data = $this->common->json($code, $data, $message);

        return $this->response->json($data);
    }
}
