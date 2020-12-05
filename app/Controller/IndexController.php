<?php

declare(strict_types=1);

namespace App\Controller;

use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface;

class IndexController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/",
     *     tags={"Test"},
     *     description="测试",
     *     @OA\Parameter(description="传入user，测试", in="query", name="user", required=false, @OA\Schema(type="string"), example="Yexk test"),
     *     @OA\Parameter(description="测试data参数", in="query", name="data", required=false, @OA\Schema(type="string"), example="测试啊！！！"),
     *     @OA\Response(
     *         response="default",
     *         description="successful"
     *     ),
     * )
     */
    public function index(): ResponseInterface
    {
        $user = [
            'user' => $this->request->input('user', 'yexk'),
            'data' => $this->request->input('data'),
            'method' => $this->request->getMethod(),
        ];

        return $this->success($user);
    }
}
