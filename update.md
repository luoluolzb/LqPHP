
# 更新记录
2018/1/7
创建项目

2018/3/1
验证器类 增加验证码验证
模型类   增加数据合并一个数组数据
控制器类 返回上级页面，刷新(可选)
json类   jsonp返回问题需要研究一下
助手库   增加模型加载类
模型类   增加使用id快速获取
删除源码中@file行
修改xml生成函数(索引数组)
分页类改名为pager, 分页类css美化
修改cookie和session类，可以直接使用静态函数操作
增加cookie和session助手函数
修复bug:单模块模式下，路由参数获取不到
文件上传类 增加自动创建保存目录功能

2018/3/3
增加config目录，修改配置文件加载方式

2018/3/4
删除cookie和session名称前缀功能
增加session配置参数
修复Error类bug，修改错误处理方式
增加助手函数：数组多维数组快速访问
增加简单的日志记录功能
修改错误页面位置

2018/3/5
增加助手函数：字符串加密和解密
增加返回数据自动编码功能
增加应用加密KEY
修改文件上传类，增加图片压缩功能，增加配置功能
修改FileMime类，修改文件类型获取方法
新增File类，FileMime功能加入File类，删除FileMime
自动加载改为psr-4，修改lqphp目录结构
增加应用自定义文件app\handler.php
Line: 4000

2018/3/6
增加Hook功能及配置
修改配置文件目录结构和加载方式
修改错误处理，修改404和500页面
修改路由类，增加路由规则动态绑定（待完善）
Line: 4332

2018/3/7
完善路由规则动态绑定
增加系统hook
Line: 4179

2018/3/11
修改lqphp\data\View为lqphp\View
增加data类接口
Line: 4304

2018/3/12
修改pathinfo解析方法，修改Request类
修改Request->pathinfo为Request->path
Line: 4268

2018/3/19
修改Hook类，增加Hook行为接口并修改行为执行方式
修改lqphp目录结构:增加core目录，component->com
增加助手函数库加载配置
Line: 4283

2018/3/21
修复加密类Authcode，降低耦合
Line: 4301

2018/3/24
修改部分代码格式
切分测试控制器
Line: 4299

2018/3/25
修改目录价名 lqphp\com -> lqphp\comp
修改类名 lqphp\ActionInterface -> lqphp\Action
修改类名 lqphp\library\Loader -> lqphp\library\AutoLoader
修改类名 lqphp\Database -> lqphp\Db
新建类   Loader 继承自 AutoLoader
修改钩子名 database_init -> db_init
Line: 4337

2018/4/2
lqphp\Log -> lqphp\Logger 遵循Psr-3日志接口规范
lqphp\library -> lqphp\lib
Line: 4311

2018/4/3
部分 控制器方法 移到 响应类
增加助手函数
Line: 4324

2018/4/4
增加 lqphp\comp\AbstratComp
优化目录结构
增加日志配置，修改 lqphp\Logger
Line: 4261

2018/4/10
修改 Cookie 和 Session操作类
Line: 4239

2018/4/10
修改 lqphp\comp\AbstractComp
增加接口，组件配置参数可以通过arraycess方式访问
优化 lqphp\Route 代码
优化 lqphp\Request 代码
修改 helper.php
Line: 4218

2018/7/16
修复 Cookie设置有效期无效问题
修改代码中用四个空格缩进改为tab缩进
Line: 4197

2018/7/19
修改 captcha配置文件中键命名问题(fontSize->font_size,background->background_color)
Line: 4197

2019/1/10
修改启动文件 public\index.php
修改 lqphp\lib 为 lqphp\library
修改日志设置为单独文件，修改 lqphp\Logger.php 日志类
增加助手函数 logger()
修改 lqphytyp\App 类
Line: 4266

2019/1/11
修改 config/app.php 文件中部分名称
修改部分代码中的注释格式
Line: 4300

2019/1/12
将 runtime/tpl 目录移动到 lqphp/tpl 并修改 Response 类相应代码
Line: 4300

2019/4/8
修正部分注释

2019/4/11
修改前端库文件位置及相关demo
修复repage()函数bug

