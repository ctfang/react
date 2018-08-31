这是对workermen封装、规范、友好化的项目，对所有功能组件化，不重复造轮子，所有组件全部使用已存在的、热门的composer包
。

<p align="">
<a href="https://packagist.org/packages/ctfang/Universe"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/ctfang/Universe"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## 主要特性

- [ ] 注解加载，服务、路由、命令等等，自定义注解也友好
- [ ] 严格遵循`psr`规范
- [ ] 单一入口，控制台使用最入门的`symfony/console`
- [ ] 异常捕捉，`whoops`使错误更漂亮的显示
- [ ] 方便调试，可以使用`xdebug`调试程序
- [ ] 内置定时任务解析器
- [ ] 内置异步`task`

## 开发计划

因为开发资源有限，开发计划暂定如下：

1. 定时任务，更好的定时测试，提供界面改时间触发定时任务
2. 支持多种session启动，文件，redis等
3. 异步task封装

git安装
~~~~
git clone https://github.com/ctfang/react.git
cd react
composer install
~~~~
查看帮助命令
~~~~php
php bin/server
~~~~

启动http服务，如果需要使用80端口，加上 sudo
~~~~php
// 守护模式
php bin/server http:start --domain
// 非守护模式
php bin/server http:start
// 关闭
php bin/server http:stop
~~~~
