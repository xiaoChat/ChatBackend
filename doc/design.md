# 项目设计
## 数据库
具体的可以查看 `migrations` 目录下面的字段描述

### 用户相关
1. 用户表(user): 唯一标识，用户名，密码，其他信息...
   - 用户历史记录（user_login_log）
2. 用户资料(profile)：年龄，生日，性别，签名...
### 消息收发
1. 消息表
### 会话相关
1. 会话表
### 群组相关
1. 群组表

## Api
### 用户相关
1. 登录
   - 请求([POST] /user/login)
      | 参数名   | 类型   | 是否必填 | 描述   |
      | -------- | ------ | -------- | ------ |
      | username | string | 是       | 用户名 |
      | password | string | 是       | 密码   |
   - 响应
      | 参数名        | 类型   | 描述           |
      | ------------- | ------ | -------------- |
      | code          | int    | 0成功，1失败， |
      | message       | string | 提示           |
      | data          | Object | 附带数据       |
      | data.token    | string | token          |
      | data.userinfo | Object | 用户信息       |

2. 注册
   - 请求([POST] /user/register)
      | 参数名   | 类型   | 是否必填 | 描述   |
      | -------- | ------ | -------- | ------ |
      | username | string | 是       | 用户名 |
      | password | string | 是       | 密码   |
   - 响应
      | 参数名        | 类型   | 描述           |
      | ------------- | ------ | -------------- |
      | code          | int    | 0成功，1失败， |
      | message       | string | 提示           |
      | data          | Object | 附带数据       |
      | data.token    | string | token          |
      | data.userinfo | Object | 用户信息       |

3. 忘记密码
   - 请求([POST] /user/changePassword)
      | 参数名   | 类型   | 是否必填 | 描述   |
      | -------- | ------ | -------- | ------ |
      | username | string | 是       | 用户名 |
   - 响应
      | 参数名        | 是否必填 | 描述                            |
      | ------------- | -------- | ------------------------------- |
      | code          | int      | 0成功，1失败，                  |
      | message       | string   | 提示                            |
      | data          | Object   | 附带数据                        |
      | data.callback | string   | 修改密码url, 携带信息去重置密码 |

4. 用户资料
   - 请求([GET] /user/info)
      | 参数名 | 类型   | 是否必填 | 描述      |
      | ------ | ------ | -------- | --------- |
      | token  | string | 是       | 用户token |
   - 响应
      | 参数名        | 类型   | 描述           |
      | ------------- | ------ | -------------- |
      | code          | int    | 0成功，1失败， |
      | message       | string | 提示           |
      | data          | Object | 附带数据       |
      | data.userinfo | Object | 用户信息       |

5. 修改用户资料
   - 请求([POST] /user/info)
      | 参数名   | 类型   | 是否必填 | 描述      |
      | -------- | ------ | -------- | --------- |
      | userinfo | Object | 是       | 用户资料  |
      | token    | string | 是       | 用户token |
   - 响应
      | 参数名        | 类型   | 描述           |
      | ------------- | ------ | -------------- |
      | code          | int    | 0成功，1失败， |
      | message       | string | 提示           |
      | data          | Object | 附带数据       |
      | data.userinfo | Object | 用户信息       |

### 消息收发
1. 单聊消息 (文本，图片，视频，文件，等等)
   - createText
   - createIText
2. 群聊消息
### 会话相关
1. 拉取会话列表
2. 显示会话信息
3. 更新会话列表
4. 未读计数
### 群组相关
1. 创建群聊
   - 请求([POST] /group/room/add)
      | 参数名   | 类型   | 是否必填 | 描述      |
      | -------- | ------ | -------- | --------- |
      | userinfo | Object | 是       | 用户资料  |
      | token    | string | 是       | 用户token |
   - 响应
      | 参数名        | 类型   | 描述           |
      | ------------- | ------ | -------------- |
      | code          | int    | 0成功，1失败， |
      | message       | string | 提示           |
      | data          | Object | 附带数据       |
      | data.userinfo | Object | 用户信息       |
2. 加/退群
3. 修改群资料
4. 获取群资料
5. 获取群列表