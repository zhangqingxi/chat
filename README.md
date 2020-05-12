## Chat
This Is A H5 Chat;

## 版本
laravel 7.10.3
PHP 7.4.5
Swoole 4.4.16 
LaravelS 3.7.0

## 拓展包
- [LaravelS](https://github.com/hhxsv5/laravel-s).
- [Passport](https://github.com/laravel/passport).
- [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper).


## LaravelS 讲解
1. http服务器配置
    下列代码放置server上面
    `upstream swoole {
        # Connect IP:Port
        server 127.0.0.1:9501 weight=5 max_fails=3 fail_timeout=30s;
        keepalive 16;
    }`
    伪静态
    `location / {
         try_files $uri @laravels;
     }`
    server内用下列代码替换fastcgi
    `location @laravels {
        # proxy_connect_timeout 60s;
        # proxy_send_timeout 60s;
        # proxy_read_timeout 60s;
        proxy_http_version 1.1;
        proxy_set_header Connection "";
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Real-PORT $remote_port;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Host $http_host;
        proxy_set_header Scheme $scheme;
        proxy_set_header Server-Protocol $server_protocol;
        proxy_set_header Server-Name $server_name;
        proxy_set_header Server-Addr $server_addr;
        proxy_set_header Server-Port $server_port;
        proxy_pass https://swoole;
    }`
2. websocket服务器
    下列代码放置server上面
    `map $http_upgrade $connection_upgrade {
        default upgrade;
        ''      close;
    }`
    server内新增下列代码
    `location =/ws {
        # proxy_connect_timeout 60s;
        # proxy_send_timeout 60s;
        # proxy_read_timeout：如果60秒内被代理的服务器没有响应数据给Nginx，那么Nginx会关闭当前连接；同时，Swoole的心跳设置也会影响连接的关闭
        # proxy_read_timeout 60s;
        proxy_http_version 1.1;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Real-PORT $remote_port;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Host $http_host;
        proxy_set_header Scheme $scheme;
        proxy_set_header Server-Protocol $server_protocol;
        proxy_set_header Server-Name $server_name;
        proxy_set_header Server-Addr $server_addr;
        proxy_set_header Server-Port $server_port;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection $connection_upgrade;
        proxy_pass https://swoole;
    }`
    
    [proxy_pass => http或https根据实际情况]
    
3. 生成laravelS配置文件 

    `php artisan laravels publish`
    
4. .env 补充代码

    `LARAVELS_LISTEN_IP=127.0.0.1
    LARAVELS_DAEMONIZE=true`
    
5. laravelS命令 项目根目录下运行
    
    `php bin/laravels start|restart|stop|reload|info|help`
    
    [修改了laravels配置文件 需要执行restart 其他执行reload即可]
    
## Passport 讲解
1. 安装passport扩展包
    
    `composer require laravel/passport`
    
2. 创建用于存放客户端和访问令牌的数据表
    
    `php artisan migrate:fresh`
    
3. 创建生成安全访问令牌（token）所需的加密键

    `php artisan passport:install --force`
    
4. 编辑app/Provides/AuthServiceProvider.php
    
    `use Laravel\Passport\Passport`;
    
    boot方法 新增代码
    
    `Passport::routes();`
    `Passport::tokensExpireIn(now()->addDays(1));//token一天后失效`
    `Passport::refreshTokensExpireIn(now()->addDays(2));//refreshToken两天后失效`

5. 编辑config/auth.php
    
    `guards/api/driver=>passport`
    
6. 再[User]模型引入[HasApiTokens]
    
    `use HasApiTokens` 
    
    `$user->createToken()`
    
7. 自定义的字段名进行授权 默认是[email] 在User模型新增以下代码

    `public function findForPassport(string $username)
    {
        return $this->where('username', $username)->first();
    }`

    
    
    
    
    
    
    
    
