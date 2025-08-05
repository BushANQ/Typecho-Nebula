<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 
 * 
 * @package Nebula
 * @author BushSEC
 * @version 1.0.1
 * @link https://bushsec.cn
 */
 
function themeConfig($form)
{
    // 基础设置
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'logoUrl',
        null,
        null,
        _t('站点 LOGO 地址'),
        _t('在这里填入一个图片 URL 地址, 以在网站标题前加上一个 LOGO')
    );
    $form->addInput($logoUrl);

    $favicon = new Typecho_Widget_Helper_Form_Element_Text(
        'favicon',
        null,
        null,
        _t('网站图标地址'),
        _t('在这里填入一个图片 URL 地址, 作为网站的 favicon')
    );
    $form->addInput($favicon);

    // 网站成立日期
    $birthDay = new Typecho_Widget_Helper_Form_Element_Text(
        'birthDay',
        null,
        null,
        _t('网站成立日期（非必填）'),
        _t('用于显示当前站点已经运行了多少时间。格式：2021/1/1 00:00:00')
    );
    $form->addInput($birthDay);

    // 网页标题切换
    $documentTitle = new Typecho_Widget_Helper_Form_Element_Text(
        'documentTitle',
        null,
        null,
        _t('网页被隐藏时显示的标题'),
        _t('在PC端切换网页标签时，网站标题显示的内容。如果不填写，则默认不开启')
    );
    $form->addInput($documentTitle);

    // 自定义字体
    $customFont = new Typecho_Widget_Helper_Form_Element_Text(
        'customFont',
        null,
        null,
        _t('自定义网站字体（非必填）'),
        _t('用于修改全站字体，填写字体URL链接（推荐使用woff格式的字体）')
    );
    $form->addInput($customFont);

    // 自定义头像源
    $customAvatarSource = new Typecho_Widget_Helper_Form_Element_Text(
        'customAvatarSource',
        null,
        'https://gravatar.helingqi.com/wavatar/',
        _t('自定义头像源（非必填）'),
        _t('用于修改全站头像源地址，填写时务必保证最后有一个/字符')
    );
    $form->addInput($customAvatarSource);

    // 动画效果
    $listAnimate = new Typecho_Widget_Helper_Form_Element_Select(
        'listAnimate',
        array(
            'off' => '关闭（默认）',
            'fadeIn' => 'fadeIn',
            'fadeInUp' => 'fadeInUp',
            'fadeInDown' => 'fadeInDown',
            'fadeInLeft' => 'fadeInLeft',
            'fadeInRight' => 'fadeInRight',
            'bounceIn' => 'bounceIn',
            'bounceInUp' => 'bounceInUp',
            'bounceInDown' => 'bounceInDown',
            'slideInUp' => 'slideInUp',
            'slideInDown' => 'slideInDown',
            'zoomIn' => 'zoomIn',
            'rotateIn' => 'rotateIn'
        ),
        'off',
        _t('选择一款炫酷的列表动画'),
        _t('开启后，列表将会显示所选择的炫酷动画')
    );
    $form->addInput($listAnimate);

    // 鼠标特效
    $cursorEffects = new Typecho_Widget_Helper_Form_Element_Select(
        'cursorEffects',
        array(
            'off' => '关闭（默认）',
            'cursor1' => '彩色粒子',
            'cursor2' => '爱心',
            'cursor3' => '星星',
            'cursor4' => '烟花',
            'cursor5' => '气泡',
            'cursor6' => '雪花',
            'cursor7' => '彩虹',
            'cursor8' => '文字'
        ),
        'off',
        _t('选择鼠标特效'),
        _t('用于开启炫酷的鼠标特效')
    );
    $form->addInput($cursorEffects);

    // 背景设置
    $dynamicBackground = new Typecho_Widget_Helper_Form_Element_Select(
        'dynamicBackground',
        array(
            'off' => '关闭（默认）',
            'particles' => '粒子效果',
            'waves' => '波浪效果',
            'geometric' => '几何图形',
            'stars' => '星空效果',
            'matrix' => '矩阵效果',
            'bubbles' => '气泡效果'
        ),
        'off',
        _t('是否开启动态背景图（仅限PC）'),
        _t('用于设置PC端动态背景，如果您填写了下方PC端静态壁纸，将优先展示静态壁纸')
    );
    $form->addInput($dynamicBackground);

    $wallpaperPC = new Typecho_Widget_Helper_Form_Element_Textarea(
        'wallpaperPC',
        null,
        null,
        _t('PC端网站背景图片（非必填）'),
        _t('PC端网站的背景图片，不填写时显示默认的灰色。格式：图片URL地址 或 随机图片api')
    );
    $form->addInput($wallpaperPC);

    $wallpaperMobile = new Typecho_Widget_Helper_Form_Element_Textarea(
        'wallpaperMobile',
        null,
        null,
        _t('移动端网站背景图片（非必填）'),
        _t('移动端网站的背景图片，不填写时显示默认的灰色。格式：图片URL地址 或 随机图片api')
    );
    $form->addInput($wallpaperMobile);

    // 首页轮播图
    $indexCarousel = new Typecho_Widget_Helper_Form_Element_Textarea(
        'indexCarousel',
        null,
        null,
        _t('首页轮播图'),
        _t('用于显示首页轮播图。格式：图片地址 || 跳转链接 || 标题 （中间使用两个竖杠分隔），一行一个')
    );
    $form->addInput($indexCarousel);

    // 首页推荐文章
    $indexRecommend = new Typecho_Widget_Helper_Form_Element_Text(
        'indexRecommend',
        null,
        null,
        _t('首页推荐文章（非必填）'),
        _t('用于显示推荐文章。格式：文章的id || 文章的id （中间使用两个竖杠分隔）')
    );
    $form->addInput($indexRecommend);

    // 首页置顶文章
    $indexSticky = new Typecho_Widget_Helper_Form_Element_Text(
        'indexSticky',
        null,
        null,
        _t('首页置顶文章（非必填）'),
        _t('格式：文章的ID || 文章的ID || 文章的ID （中间使用两个竖杠分隔）')
    );
    $form->addInput($indexSticky);

    // 首页热门文章
    $indexHot = new Typecho_Widget_Helper_Form_Element_Radio(
        'indexHot',
        array('off' => '关闭（默认）', 'on' => '开启'),
        'off',
        _t('是否开启首页热门文章'),
        _t('开启后，网站首页将会显示浏览量最多的4篇热门文章')
    );
    $form->addInput($indexHot);

    // 自定义缩略图
    $thumbnail = new Typecho_Widget_Helper_Form_Element_Textarea(
        'thumbnail',
        null,
        null,
        _t('自定义缩略图'),
        _t('用于修改主题默认缩略图，图片地址，一行一个。不填写时，则使用主题内置的默认缩略图')
    );
    $form->addInput($thumbnail);

    // 懒加载图
    $lazyload = new Typecho_Widget_Helper_Form_Element_Text(
        'lazyload',
        null,
        null,
        _t('自定义懒加载图'),
        _t('用于修改主题默认懒加载图，格式：图片地址')
    );
    $form->addInput($lazyload);

    // 底部栏设置
    $footerLeft = new Typecho_Widget_Helper_Form_Element_Textarea(
        'footerLeft',
        null,
        '© 2024 Nebula8 Theme',
        _t('自定义底部栏左侧内容（非必填）'),
        _t('用于修改全站底部左侧内容（移动端上方）')
    );
    $form->addInput($footerLeft);

    $footerRight = new Typecho_Widget_Helper_Form_Element_Textarea(
        'footerRight',
        null,
        '<a href="/feed/" target="_blank">RSS</a> <a href="/sitemap.xml" target="_blank" style="margin-left: 15px">MAP</a>',
        _t('自定义底部栏右侧内容（非必填）'),
        _t('用于修改全站底部右侧内容（移动端下方）')
    );
    $form->addInput($footerRight);

    $customCSS = new Typecho_Widget_Helper_Form_Element_Textarea(
        'customCSS',
        null,
        null,
        _t('自定义CSS'),
        _t('在这里添加自定义的CSS代码，无需填写style标签')
    );
    $form->addInput($customCSS);

    $customJS = new Typecho_Widget_Helper_Form_Element_Textarea(
        'customJS',
        null,
        null,
        _t('自定义JavaScript'),
        _t('在这里添加自定义的JavaScript代码，无需填写script标签')
    );
    $form->addInput($customJS);

    $customHeadEnd = new Typecho_Widget_Helper_Form_Element_Textarea(
        'customHeadEnd',
        null,
        null,
        _t('自定义增加&lt;head&gt;&lt;/head&gt;里内容（非必填）'),
        _t('此处用于在&lt;head&gt;&lt;/head&gt;标签里增加自定义内容，例如：可以填写引入第三方css、js等等')
    );
    $form->addInput($customHeadEnd);

    $customBodyEnd = new Typecho_Widget_Helper_Form_Element_Textarea(
        'customBodyEnd',
        null,
        null,
        _t('自定义&lt;body&gt;&lt;/body&gt;末尾位置内容（非必填）'),
        _t('此处用于填写在&lt;body&gt;&lt;/body&gt;标签末尾位置的内容，例如：可以填写引入第三方js脚本等等')
    );
    $form->addInput($customBodyEnd);

    $socialLinks = new Typecho_Widget_Helper_Form_Element_Textarea(
        'socialLinks',
        null,
        '微博|https://weibo.com/yourname|fab fa-weibo
GitHub|https://github.com/yourname|fab fa-github
邮箱|mailto:your@email.com|fas fa-envelope',
        _t('社交链接'),
        _t('每行一个链接，格式：名称|链接|图标类名')
    );
    $form->addInput($socialLinks);

    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'sidebarBlock',
        [
            'ShowRecentPosts'    => _t('显示最新文章'),
            'ShowRecentComments' => _t('显示最近回复'),
            'ShowCategory'       => _t('显示分类'),
            'ShowArchive'        => _t('显示归档'),
            'ShowOther'          => _t('显示其它杂项'),
            'ShowSocialLinks'    => _t('显示社交链接')
        ],
        ['ShowRecentPosts', 'ShowRecentComments', 'ShowCategory', 'ShowArchive', 'ShowOther'],
        _t('侧边栏显示')
    );
    $form->addInput($sidebarBlock->multiMode());

    // 侧边栏热门文章
    $asideHotNum = new Typecho_Widget_Helper_Form_Element_Select(
        'asideHotNum',
        array(
            'off' => '关闭（默认）',
            '3' => '显示3条',
            '4' => '显示4条',
            '5' => '显示5条',
            '6' => '显示6条',
            '7' => '显示7条',
            '8' => '显示8条'
        ),
        'off',
        _t('是否开启热门文章栏'),
        _t('用于控制是否开启热门文章栏')
    );
    $form->addInput($asideHotNum);

    // 侧边栏广告
    $asideAd = new Typecho_Widget_Helper_Form_Element_Textarea(
        'asideAd',
        null,
        null,
        _t('侧边栏广告'),
        _t('用于设置侧边栏广告。格式：广告图片 || 跳转链接 （中间使用两个竖杠分隔）')
    );
    $form->addInput($asideAd);

    // 自定义侧边栏模块
    $customAside = new Typecho_Widget_Helper_Form_Element_Textarea(
        'customAside',
        null,
        null,
        _t('自定义侧边栏模块'),
        _t('用于自定义侧边栏模块，请填写前端代码')
    );
    $form->addInput($customAside);

    // 代码高亮样式设置
    $prismTheme = new Typecho_Widget_Helper_Form_Element_Select(
        'prismTheme',
        array(
            '//npm.elemecdn.com/prismjs@1.29.0/themes/prism.min.css' => 'prism（默认）',
            '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-dark.min.css' => 'prism-dark',
            '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-okaidia.min.css' => 'prism-okaidia',
            '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-solarizedlight.min.css' => 'prism-solarizedlight',
            '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-tomorrow.min.css' => 'prism-tomorrow',
            '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-twilight.min.css' => 'prism-twilight',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-a11y-dark.min.css' => 'prism-a11y-dark',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-atom-dark.min.css' => 'prism-atom-dark',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-base16-ateliersulphurpool.light.min.css' => 'prism-base16-ateliersulphurpool.light',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-cb.min.css' => 'prism-cb',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-coldark-cold.min.css' => 'prism-coldark-cold',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-coldark-dark.min.css' => 'prism-coldark-dark',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-darcula.min.css' => 'prism-darcula',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-dracula.min.css' => 'prism-dracula',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-dark.min.css' => 'prism-duotone-dark',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-earth.min.css' => 'prism-duotone-earth',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-forest.min.css' => 'prism-duotone-forest',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-light.min.css' => 'prism-duotone-light',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-sea.min.css' => 'prism-duotone-sea',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-space.min.css' => 'prism-duotone-space',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-ghcolors.min.css' => 'prism-ghcolors',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-gruvbox-dark.min.css' => 'prism-gruvbox-dark',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-hopscotch.min.css' => 'prism-hopscotch',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-lucario.min.css' => 'prism-lucario',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-material-dark.min.css' => 'prism-material-dark',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-material-light.min.css' => 'prism-material-light',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-material-oceanic.min.css' => 'prism-material-oceanic',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-night-owl.min.css' => 'prism-night-owl',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-nord.min.css' => 'prism-nord',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-pojoaque.min.css' => 'prism-pojoaque',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-shades-of-purple.min.css' => 'prism-shades-of-purple',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-synthwave84.min.css' => 'prism-synthwave84',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-vs.min.css' => 'prism-vs',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-vsc-dark-plus.min.css' => 'prism-vsc-dark-plus',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-xonokai.min.css' => 'prism-xonokai',
            '//npm.elemecdn.com/prism-theme-one-light-dark@1.0.4/prism-onelight.min.css' => 'prism-onelight',
            '//npm.elemecdn.com/prism-theme-one-light-dark@1.0.4/prism-onedark.min.css' => 'prism-onedark',
            '//npm.elemecdn.com/prism-theme-one-dark@1.0.0/prism-onedark.min.css' => 'prism-onedark2'
        ),
        '//npm.elemecdn.com/prismjs@1.29.0/themes/prism.min.css',
        _t('代码高亮样式'),
        _t('选择一款您喜欢的代码高亮样式')
    );
    $form->addInput($prismTheme);

    $analytics = new Typecho_Widget_Helper_Form_Element_Textarea(
        'analytics',
        null,
        null,
        _t('统计代码'),
        _t('在这里添加Google Analytics或其他统计代码')
    );
    $form->addInput($analytics);
}

// 主题初始化
function themeInit($archive) {
    // 添加自定义字段支持
    if ($archive->is('single')) {
        $archive->content = parseContent($archive->content);
    }
}

// 解析内容，支持特殊语法
function parseContent($content) {
    // 解析提示框
    $content = preg_replace('/\[tip\](.*?)\[\/tip\]/s', '<div class="tip-box tip-info"><i class="fas fa-info-circle"></i>$1</div>', $content);
    $content = preg_replace('/\[warning\](.*?)\[\/warning\]/s', '<div class="tip-box tip-warning"><i class="fas fa-exclamation-triangle"></i>$1</div>', $content);
    $content = preg_replace('/\[error\](.*?)\[\/error\]/s', '<div class="tip-box tip-error"><i class="fas fa-times-circle"></i>$1</div>', $content);
    $content = preg_replace('/\[success\](.*?)\[\/success\]/s', '<div class="tip-box tip-success"><i class="fas fa-check-circle"></i>$1</div>', $content);
    
    return $content;
}

// 时间格式化
function formatTime($time) {
    $now = time();
    $diff = $now - $time;
    
    if ($diff < 60) {
        return '刚刚';
    } elseif ($diff < 3600) {
        return floor($diff / 60) . ' 分钟前';
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . ' 小时前';
    } elseif ($diff < 2592000) {
        return floor($diff / 86400) . ' 天前';
    } else {
        return date('Y-m-d', $time);
    }
}

// 获取文章缩略图
function getPostThumbnail($widget) {
    $content = $widget->content;
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
    
    if (preg_match($pattern, $content, $matches)) {
        return $matches[1];
    }
    
    return null;
}

// 获取阅读时间预估
function getReadingTime($content) {
    $wordsPerMinute = 200; // 每分钟阅读字数
    $wordCount = mb_strlen(strip_tags($content), 'UTF-8');
    $readingTime = ceil($wordCount / $wordsPerMinute);
    
    return $readingTime;
}

// 获取文章摘要
function getExcerpt($content, $length = 200) {
    $content = strip_tags($content);
    $content = preg_replace('/\s+/', ' ', $content);
    
    if (mb_strlen($content, 'UTF-8') <= $length) {
        return $content;
    }
    
    return mb_substr($content, 0, $length, 'UTF-8') . '...';
}

// 文章浏览量统计函数
function getPostViews($archive) {
    $cid = $archive->cid;
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    
    // 从数据库中获取浏览量字段
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        // 如果表中没有views字段，则创建一个
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
    }
    
    // 获取浏览量
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    $views = intval($row['views']);
    
    // 如果是文章页面，则更新浏览量
    if ($archive->is('single')) {
        $views = $views + 1;
        $db->query($db->update('table.contents')->rows(array('views' => $views))->where('cid = ?', $cid));
    }
    
    return $views;
}

// 格式化浏览量数字
function formatViewsNum($views) {
    if ($views >= 1000000) {
        return round($views / 1000000, 1) . 'M';
    } elseif ($views >= 1000) {
        return round($views / 1000, 1) . 'K';
    } else {
        return $views;
    }
}

// 获取分类下所有文章的浏览量总和
function getCategoryViews($categoryId) {
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    
    // 确保views字段存在
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
    }
    
    // 查询分类下所有文章的浏览量总和
    $result = $db->fetchRow($db->select(array('SUM(views)' => 'sumviews'))
        ->from('table.contents', 'table.contents.cid = table.relationships.cid')
        ->join('table.relationships', 'table.contents.cid = table.relationships.cid')
        ->where('table.relationships.mid = ?', $categoryId)
        ->where('table.contents.status = ?', 'publish'));
    
    return intval($result['sumviews']);
}
