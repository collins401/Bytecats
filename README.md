##wordpress企业站基础模板

>此主题模板根据[html5blank](https://github.com/toddmotto/html5blank)修改而成的适合中文版企业站的基础模板。不需要其他多余的插件也能完成一个功能齐全的企业网站。网站样式[演示地址](http://wp.bytecats.com/)

###关于html5blank
html5blank是一套高度优化过的博客主题。方便快速而又灵活定制属于自己的主题样式。

##内容类型及指定模板

###新闻模型(默认posts) 

###产品模型(custon post type+taxonomy)
post-type=product <br />
taxonomy=location

产品频道模板(archive-product.php)

产品分类模板(taxonomy-location.php)

产品详情模板(single-product.php)
###招聘模型(custon post type)
post-type=jobs

招聘频道模板(archive-jobs.php)

招聘详情模板(single-jobs.php)
###两套搜索结果模板
新闻搜索与产品搜索分别实现不同的模板呈现结果。
##functions.php
根据企业站需求，完全去了掉评论功能以及评论模板。

- 使用代码去掉URL中`category`
- 主题缩略图基于[timthumb.php](http://www.binarymoon.co.uk/projects/timthumb/)
- 后台禁用Google Open Sans字体加载
- 面包屑导航，支持自定义文章类型
- 文章点击量统计post_views();
- 后台菜单导航精简
- 精简head内多余标签输出。
- 一个全局主题字段管理面板，如电话，QQ，统计代码等。
- 一个幻灯图片管理面板


##关于作者
Q  Q：373345619 <br />
网站：[www.bytecats.com](http://www.bytecats.com)
