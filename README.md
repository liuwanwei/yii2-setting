# 使用数据库存储通用配置项

## 简介

为 Yii2 封装的一个配置项管理模块。

**特性：**

1. 支持从配置文件读取应用的默认配置项
2. 支持使用 Yii2 内置的各种 validators 对配置做验证
3. 内置配置项无法删除，意外删除后会自动用默认配置项填充
4. 提供配置页面对配置项进行管理

**适用环境：**

- PHP 5.6 及以上版本
- Yii2.0.7 及以上版本
- MySQL 5.6 及以上版本


## 使用方法

**1.安装**

```
#composer require buddysoft/yii2-setting
```

**2.导入数据表**

```
#cd project_root
#./yii migrate --migrationPath=@buddysoft/setting/migrations
```

**3.创建配置文件**

示例文件位置： yii2-setting/migrations/settings.php

推荐拷贝配置文件到目标应用的 config 目录，以 Yii2 高级模板的 backend 应用为例：

```
#cd project_root
#cp vendor/buddysoft/yii2-setting/migrations/settings.php backend/config/bd_settings.php
```

导入口，可以对配置项进行修改、添加或删除。

**4.配置管理页面模块**

修改 backend/config/main.php

```
// 在文件顶部引入配置文件：

$bdSettings = require(__DIR__ . '/bd_settings.php');

// 在 modules 配置中增加 setting 模块的定义，用到的 bdSettings 变量，就是上面配置的内容。

'modules' => [
    'setting' => [
        'class' => 'buddysoft\setting\Module',
        'defaultSetting' =>  $bdSettings,
    ],
],
```

经过以上配置，就能在浏览中访问配置界面了:

>http://localhost/setting/setting/index

跟 Yii2-admin 配合使用时，记得将 setting/setting/* 访问权限添加给用户。

**5.在代码中使用配置项**

```
use buddysoft/setting/SettingHelper;
// 'sms-switch' 就是配置项的 key 值。
$intValue = SettingHelper::intValue('sms-switch');

```

## 配置项定义方法

示例：

```
[
    'name' => '短信通道开关',
    'key' => 'sms-switch',
    'value' => '1', // 默认值
    'weight' => '0', // 后台配置界面显示顺序
    'description' => '是否打开短信验证，打开后...',
    'options' => [
        'validator' => 'in',
        'params' => [
            'range' => ['1', '0']
        ]
    ],
],
```

配置中使用 options 配置 validator 对 value 的合法性进行验证。

options 有两个属性：

- validator：配置项名字，诸如 integer, string, in 等
- params: validator 验证时使用的参数，参考 validators 的 public 属性

## 分类功能

为了方便在后台管理所有配置项，所以给配置项增加了分类（category）属性，后台展示时，同一分类的配置项在一个 Tab 中展示。

注意：配置项不会根据分类进行隔离，所有配置项都在同一名字空间中。
