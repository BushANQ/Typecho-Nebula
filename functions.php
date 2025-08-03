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

    $customCSS = new Typecho_Widget_Helper_Form_Element_Textarea(
        'customCSS',
        null,
        null,
        _t('自定义CSS'),
        _t('在这里添加自定义的CSS代码')
    );
    $form->addInput($customCSS);

    $customJS = new Typecho_Widget_Helper_Form_Element_Textarea(
        'customJS',
        null,
        null,
        _t('自定义JavaScript'),
        _t('在这里添加自定义的JavaScript代码')
    );
    $form->addInput($customJS);

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
