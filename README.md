# 介绍

# [HyperfPlus](https://github.com/G-YDG/hyperf-plus)

📦 集成 Hyperf 框架开发过程中的常用代码，减少重复开发，提高开发效率。

## 目录说明

```text
./src                                       
└── Abstracts                               # 抽象类
    ├── AbstractController.php              # 控制器抽象类
    ├── AbstractMapper.php                  # 数据映射抽象类
    ├── AbstractService.php                 # 服务层抽象类
└── Annotation                              # 注解类
    ├── DependProxy.php                     # 依赖代理
    ├── DependProxyCollector.php            # 依赖代理收集器
    ├── Transaction.php                     # 数据库事务注解
└── Aspect                                  # 切面类
    ├── TransactionAspect.php               # 数据库事务切面类
└── Command                                 # 命令
    ├── Generator                           # 代码生成
        ├── MapperCommand.php               # 生成数据映射类
        ├── MigrationCommand.php            # 生成数据迁移类
        ├── ModelCommand.php                # 生成模型类
        ├── ServiceCommand.php              # 生成服务类
        ├── TemplateCommand.php             # 生成模板代码（Mapper、Model、Service）
    ├── Module                              # 业务模块
        ├── InitCommand.php                 # 业务模块初始化
└── Exception                               # 异常类
└── Helper                                  # 助手函数
└── Middlewares                             # 中间件
└── Traits                                  # 特征类
└── Collection.php                          # 集合类
└── FormRequest.php                         # 请求验证类
└── Model.php                               # 模型类
└── Request.php                             # 请求类
└── Response.php                            # 响应类
...

```

# 安装

```bash
composer require ydg/hyperf-plus
```

## 配置

发布配置

```bash
php bin/hyperf.php vendor:publish ydg/hyperf-plus
```

config/container.php

```
<?php

declare(strict_types=1);

use Hyperf\Context\ApplicationContext;
use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSourceFactory;
use HyperfPlus\Annotation\DependProxyCollector;
use Psr\Container\ContainerInterface;

$container = new Container((new DefinitionSourceFactory())());

DependProxyCollector::walk([$container, 'define']);

if (!$container instanceof ContainerInterface) {
    throw new RuntimeException('The dependency injection container is invalid.');
}

return ApplicationContext::setContainer($container);

```

# 快捷开发

## 业务模块初始化

以 System 作为示例

```
php bin/hyperf.php plus-module:init system
```

#### 目录说明

```text
./System                                    # 系统模块
└── Controller                              # 控制器（对请求参数进行基本验证以及响应数据的简单封装，具体业务应在Service实现）
└── Database                                # 数据库
    ├── Migrations                          # 数据迁移
    ├── Seeders                             # 数据填充
└── Dictionary                              # 字典
└── Mapper                                  # 字典
└── Helper                                  # 助手函数
└── Model                                   # 模型
└── Request                                 # 请求验证器（请求参数验证以及处理）
└── Service                                 # 服务层（主要业务逻辑）
...

```

## 生成模板代码

以 system_config 表作为示例

```
php bin/hyperf.php plus-gen:tpl system_config --module system
```