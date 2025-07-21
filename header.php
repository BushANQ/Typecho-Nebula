<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="theme-color" content="#007bff">
    <title><?php $this->archiveTitle([
            'category' => _t('分类 %s 下的文章'),
            'search'   => _t('包含关键字 %s 的文章'),
            'tag'      => _t('标签 %s 下的文章'),
            'author'   => _t('%s 发布的文章')
        ], '', ' - '); ?><?php $this->options->title(); ?></title>

    <!-- CSS文件 -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('normalize.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('grid.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

    <?php $this->header(); ?>
</head>
<body>
    <!-- 页面加载动画 -->
    <div id="page-loader" class="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="site-name col-mb-12 col-6">
                    <?php if ($this->options->logoUrl): ?>
                        <a id="logo" href="<?php $this->options->siteUrl(); ?>" class="logo-link">
                            <img src="<?php $this->options->logoUrl() ?>" alt="<?php $this->options->title() ?>" class="logo-img"/>
                            <span class="logo-text"><?php $this->options->title() ?></span>
                        </a>
                    <?php else: ?>
                        <a id="logo" href="<?php $this->options->siteUrl(); ?>" class="logo-link">
                            <i class="fas fa-blog logo-icon"></i>
                            <?php $this->options->title() ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($this->options->description()): ?>
                        <p class="description">
                            <i class="fas fa-quote-left"></i>
                            <?php $this->options->description() ?>
                        </p>
                    <?php endif; ?>
                </div>
                
                <!-- 头部右侧工具 -->
                <div class="header-tools col-mb-12 col-6">
                    <!-- 主题切换 -->
                    <div class="theme-toggle-container">
                        <button class="theme-toggle" id="themeToggle" title="切换主题">
                            <i class="fas fa-sun light-icon"></i>
                            <i class="fas fa-moon dark-icon"></i>
                        </button>
                    </div>
                    
                    <!-- 搜索框 -->
                    <div class="site-search col-12 col-tb-6">
                        <form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
                            <div class="search-container">
                                <label for="s" class="sr-only"><?php _e('搜索关键字'); ?></label>
                                <input type="text" id="s" name="s" class="search-input" placeholder="<?php _e('输入关键字搜索...'); ?>" autocomplete="off"/>
                                <button type="submit" class="search-btn" title="搜索">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- 导航菜单 -->
                <div class="col-mb-12">
                    <nav id="nav-menu" class="main-nav" role="navigation">
                        <a href="<?php $this->options->siteUrl(); ?>" 
                           class="nav-link <?php if ($this->is('index')): ?>current<?php endif; ?>"
                           title="首页">
                            <i class="fas fa-home"></i>
                            <span><?php _e('首页'); ?></span>
                        </a>
                        
                        <?php Typecho_Widget::widget('Widget_Contents_Page_List')->to($pages); ?>
                        <?php while ($pages->next()): ?>
                            <a href="<?php $pages->permalink(); ?>" 
                               class="nav-link <?php if ($this->is('page', $pages->slug)): ?>current<?php endif; ?>"
                               title="<?php $pages->title(); ?>">
                                <i class="fas fa-file-alt"></i>
                                <span><?php $pages->title(); ?></span>
                            </a>
                        <?php endwhile; ?>
                        
                        <!-- 归档链接 -->
                        <a href="<?php $this->options->siteUrl(); ?>archives/" class="nav-link" title="归档">
                            <i class="fas fa-archive"></i>
                            <span>归档</span>
                        </a>
                    </nav>
                    
                    <!-- 移动端菜单按钮 -->
                    <button class="mobile-menu-toggle" id="mobileMenuToggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- 返回顶部按钮 -->
    <button id="backToTop" class="back-to-top" title="返回顶部">
        <i class="fas fa-chevron-up"></i>
    </button>

    <main id="body" class="main-content">
        <div class="container">
            <div class="row">

    <style>
    /* 页面加载动画 */
    .page-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--bg-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }
    
    .page-loader.hidden {
        opacity: 0;
        visibility: hidden;
    }
    
    .loader-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid var(--border-color);
        border-top: 4px solid var(--accent-primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* 头部增强样式 */
    .header-tools {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 1rem;
    }
    
    .theme-toggle-container {
        position: relative;
    }
    
    .theme-toggle {
        width: 50px;
        height: 26px;
        background: var(--border-color);
        border: none;
        border-radius: 26px;
        position: relative;
        cursor: pointer;
        transition: all var(--transition-fast) ease;
        overflow: hidden;
    }
    
    .theme-toggle i {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12px;
        transition: all var(--transition-fast) ease;
    }
    
    .light-icon {
        right: 6px;
        color: #ffa500;
    }
    
    .dark-icon {
        left: 6px;
        color: #4dabf7;
        opacity: 0;
    }
    
    [data-theme="dark"] .theme-toggle {
        background: var(--accent-primary);
    }
    
    [data-theme="dark"] .light-icon {
        opacity: 0;
    }
    
    [data-theme="dark"] .dark-icon {
        opacity: 1;
    }
    
    .theme-toggle::before {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 22px;
        height: 22px;
        background: white;
        border-radius: 50%;
        transition: all var(--transition-fast) ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    [data-theme="dark"] .theme-toggle::before {
        transform: translateX(24px);
    }
    
    /* 搜索框增强 */
    .search-container {
        position: relative;
        max-width: 300px;
    }
    
    .search-input {
        padding-right: 3rem;
        border-radius: 25px;
        border: 2px solid var(--border-color);
        background: var(--bg-secondary);
        transition: all var(--transition-fast) ease;
    }
    
    .search-input:focus {
        border-color: var(--accent-primary);
        background: var(--bg-primary);
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }
    
    .search-btn {
        position: absolute;
        right: 2px;
        top: 2px;
        width: 36px;
        height: 36px;
        border: none;
        border-radius: 50%;
        background: var(--accent-primary);
        color: white;
        cursor: pointer;
        transition: all var(--transition-fast) ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .search-btn:hover {
        background: var(--accent-secondary);
        transform: scale(1.05);
    }
    
    /* 导航菜单增强 */
    .main-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }
    
    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: var(--bg-secondary);
        border-radius: var(--radius-md);
        color: var(--text-secondary);
        transition: all var(--transition-fast) ease;
        position: relative;
        overflow: hidden;
    }
    
    .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: var(--gradient-primary);
        transition: left var(--transition-medium) ease;
        z-index: -1;
    }
    
    .nav-link:hover::before,
    .nav-link.current::before {
        left: 0;
    }
    
    .nav-link:hover,
    .nav-link.current {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px var(--shadow-medium);
    }
    
    .nav-link::after {
        display: none;
    }
    
    .nav-link i {
        font-size: 0.9rem;
    }
    
    /* 移动端菜单 */
    .mobile-menu-toggle {
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 30px;
        height: 30px;
        background: none;
        border: none;
        cursor: pointer;
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 1001;
    }
    
    .mobile-menu-toggle span {
        display: block;
        width: 20px;
        height: 2px;
        background: var(--text-primary);
        margin: 3px 0;
        transition: all 0.3s ease;
    }
    
    .mobile-menu-toggle.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }
    
    .mobile-menu-toggle.active span:nth-child(2) {
        opacity: 0;
    }
    
    .mobile-menu-toggle.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
    }
    
    /* 返回顶部按钮 */
    .back-to-top {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 50px;
        height: 50px;
        background: var(--accent-primary);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px var(--shadow-medium);
        transition: all var(--transition-fast) ease;
        opacity: 0;
        visibility: hidden;
        z-index: 999;
    }
    
    .back-to-top.show {
        opacity: 1;
        visibility: visible;
    }
    
    .back-to-top:hover {
        background: var(--accent-secondary);
        transform: translateY(-3px);
        box-shadow: 0 6px 20px var(--shadow-strong);
    }
    
    /* Logo增强 */
    .logo-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .logo-icon {
        font-size: 1.8rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .logo-img {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        transition: all var(--transition-fast) ease;
    }
    
    .logo-link:hover .logo-img {
        transform: scale(1.1) rotate(5deg);
    }
    
    .logo-text {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* 响应式 */
    @media (max-width: 991px) {
        .header-tools {
            justify-content: center;
            margin: 1rem 0;
        }
        
        .search-container {
            max-width: 100%;
        }
        
        .main-nav {
            justify-content: center;
        }
        
        .mobile-menu-toggle {
            display: flex;
        }
        
        .main-nav {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: var(--bg-primary);
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .main-nav.show {
            display: flex;
        }
        
        .nav-link {
            margin: 0.5rem 0;
            width: 200px;
            justify-content: center;
        }
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 主题切换功能
        const themeToggle = document.getElementById('themeToggle');
        const currentTheme = localStorage.getItem('theme') || 'light';
        
        document.documentElement.setAttribute('data-theme', currentTheme);
        
        themeToggle.addEventListener('click', function() {
            const theme = document.documentElement.getAttribute('data-theme');
            const newTheme = theme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
        
        // 页面加载动画
        const pageLoader = document.getElementById('page-loader');
        window.addEventListener('load', function() {
            setTimeout(() => {
                pageLoader.classList.add('hidden');
                setTimeout(() => {
                    pageLoader.style.display = 'none';
                }, 500);
            }, 300);
        });
        
        // 移动端菜单
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mainNav = document.getElementById('nav-menu');
        
        mobileMenuToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            mainNav.classList.toggle('show');
        });
        
        // 返回顶部
        const backToTop = document.getElementById('backToTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // 头部滚动效果
        const header = document.getElementById('header');
        let lastScrollTop = 0;
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset;
            
            if (scrollTop > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            lastScrollTop = scrollTop;
        });
        
        // 搜索框
        const searchInput = document.getElementById('s');
        
        searchInput.addEventListener('focus', function() {
            this.parentElement.classList.add('focus');
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('focus');
        });
    });
    </script>
