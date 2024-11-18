# wp-shortlink
基于Sink和wordpress插件实现文章短链分享

## 示例
[blog.fz.do](https://blog.fz.do)（可进入任意文章末尾查看）

## 本内容适用情形
1、dns服务商为Cloudflare（其他没测试过）；  
2、一级域名不方便直接添加短链程序，如我的主页托管在CF pages；二级域名展示博客。

## 优点
1、可以将wp文章长链接缩短很多，使得便于分享且美观；  
2、利用现有插件实现分享图标等内容的展示，避免重复造车；且Sink完成程度较高，功能全面，也避免再新写一个程序;  
3、Sink存在同一链接会出现不同的短链，本代码也避免了该问题。

## 使用
1、根据[https://github.com/ccbikai/Sink](https://github.com/ccbikai/Sink)安装Sink，并完成配置；  
2、WP安装插件sassy-social-share，后台在Miscellaneous中设置Url shortener为‘Use shortlinks already installed’；  
3、打开example.com/wp-content/plugins/sassy-social-share/public目录下的class-sassy-social-share-public.php；  
找到函数get_short_url，修改为code.php中的代码；找到同文件中的$horizontal_div，修改为code.php中的代码。并根据sql指令生成表。  
4、进入cloudflare控制面板，进入对应的域名页面，从左侧规则进入重定向规则。  
选择通配符模式，请求URL写为一级域名加“/*”，但是建议写成一级域名+“/s/*”，其中s可以任意替换，但是既然是短链，肯定还是一个字母为好，至于为什么要加一个路径，是为了避免访问主页在请求资源时被重定向；目标URL写为CF为Sink生成的域名+“/${1}”  
这样就完成了请求example.com/s/2333重定向请求233.pages.dev/s/2333，再跳转目标网址，从而实现长链接转短链接。  

## 注意
1、code.php中请求头的部分要把pw替换为自己Sink后台的密码！！！  
2、使用3中的第二步修改会导致统计链接不可用，请自行抉择！如果既想使用统计代码又不想使copy link返回长链接，可以尝试修改$post_url或js文件中获取链接的方式  

## 缺点
1、使用3中的第二步修改会导致统计链接不可用；  
2、小屎山（）
