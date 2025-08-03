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
        <!-- 阅读进度条 -->
        <div class="reading-progress-bar" id="readingProgress"></div>
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
                           title="首页" style="--item-index: 0;">
                            <i class="fas fa-home"></i>
                            <span><?php _e('首页'); ?></span>
                        </a>
                        
                        <?php Typecho_Widget::widget('Widget_Contents_Page_List')->to($pages); ?>
                        <?php $index = 1; ?>
                        <?php while ($pages->next()): ?>
                            <a href="<?php $pages->permalink(); ?>" 
                               class="nav-link <?php if ($this->is('page', $pages->slug)): ?>current<?php endif; ?>"
                               title="<?php $pages->title(); ?>" style="--item-index: <?php echo $index; ?>">
                                <i class="fas fa-file-alt"></i>
                                <span><?php $pages->title(); ?></span>
                            </a>
                            <?php $index++; ?>
                        <?php endwhile; ?>
                        
                        <!-- 归档链接 -->
                        <a href="<?php $this->options->siteUrl(); ?>archives/" class="nav-link" title="归档" style="--item-index: <?php echo $index; ?>">
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


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 主题切换功能
        const themeToggle = document.getElementById('themeToggle');
        const currentTheme = localStorage.getItem('theme') || 'light';
        
        // 设置初始主题
        document.documentElement.setAttribute('data-theme', currentTheme);
        
        // 添加过渡类，防止初始加载时出现闪烁
        setTimeout(() => {
            document.body.classList.add('theme-transition-enabled');
        }, 300);
        
        themeToggle.addEventListener('click', function() {
            const theme = document.documentElement.getAttribute('data-theme');
            const newTheme = theme === 'dark' ? 'light' : 'dark';
            
            // 添加过渡动画类
            document.body.classList.add('theme-changing');
            
            // 设置新主题
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // 动画完成后移除过渡类
            setTimeout(() => {
                document.body.classList.remove('theme-changing');
            }, 500);
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
        const body = document.body;
        
        // 检查屏幕宽度，如果是移动设备，默认折叠菜单
        function checkScreenSize() {
            if (window.innerWidth <= 991) {
                mainNav.classList.remove('show');
                mobileMenuToggle.classList.remove('active');
                body.classList.remove('menu-open');
            }
        }
        
        // 初始检查
        checkScreenSize();
        
        // 窗口大小改变时重新检查
        window.addEventListener('resize', checkScreenSize);
        
        mobileMenuToggle.addEventListener('click', function() {
            // 先移除所有类，确保状态重置
            if (mainNav.classList.contains('show')) {
                this.classList.remove('active');
                mainNav.classList.remove('show');
                body.classList.remove('menu-open');
            } else {
                this.classList.add('active');
                mainNav.classList.add('show');
                body.classList.add('menu-open');
            }
        });
        
        // 点击菜单项后自动关闭菜单
        const navLinks = mainNav.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 991) {
                    mobileMenuToggle.classList.remove('active');
                    mainNav.classList.remove('show');
                    body.classList.remove('menu-open');
                }
            });
        });
        
        // 点击菜单外区域关闭菜单
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 991 && 
                !mainNav.contains(event.target) && 
                !mobileMenuToggle.contains(event.target) && 
                mainNav.classList.contains('show')) {
                mobileMenuToggle.classList.remove('active');
                mainNav.classList.remove('show');
                body.classList.remove('menu-open');
            }
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
                behavior: 'auto'
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
        
        // 搜索框增强
        const searchInput = document.getElementById('s');
        const searchContainer = searchInput.parentElement;
        let searchTimeout;
        let selectedIndex = -1;
        let suggestions = [];
        
        // 创建搜索建议容器
        const suggestionsContainer = document.createElement('div');
        suggestionsContainer.className = 'search-suggestions';
        searchContainer.appendChild(suggestionsContainer);
        
        // 搜索框焦点事件
        searchInput.addEventListener('focus', function() {
            this.parentElement.classList.add('focus');
            if (this.value.length >= 2) {
                showSuggestions();
            }
        });
        
        // 搜索框失去焦点事件
        searchInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('focus');
            // 延迟隐藏建议，以便可以点击建议项
            setTimeout(() => {
                suggestionsContainer.classList.remove('active');
            }, 200);
        });
        
        // 搜索框输入事件
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            // 清除之前的超时
            clearTimeout(searchTimeout);
            
            if (query.length >= 2) {
                // 设置新的超时，延迟300ms执行搜索
                searchTimeout = setTimeout(() => {
                    fetchSuggestions(query);
                }, 300);
            } else {
                suggestionsContainer.classList.remove('active');
            }
        });
        
        // 键盘导航
        searchInput.addEventListener('keydown', function(e) {
            if (!suggestionsContainer.classList.contains('active')) return;
            
            const items = suggestionsContainer.querySelectorAll('.suggestion-item');
            
            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    selectedIndex = (selectedIndex + 1) % items.length;
                    highlightItem(items, selectedIndex);
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    selectedIndex = (selectedIndex - 1 + items.length) % items.length;
                    highlightItem(items, selectedIndex);
                    break;
                case 'Enter':
                    if (selectedIndex >= 0 && selectedIndex < items.length) {
                        e.preventDefault();
                        items[selectedIndex].click();
                    }
                    break;
                case 'Escape':
                    suggestionsContainer.classList.remove('active');
                    break;
            }
        });
        
        // 高亮选中项
        function highlightItem(items, index) {
            items.forEach(item => item.classList.remove('selected'));
            if (index >= 0) {
                items[index].classList.add('selected');
                items[index].scrollIntoView({ block: 'nearest' });
            }
        }
        
        // 获取搜索建议
        function fetchSuggestions(query) {
            // 显示加载状态
            suggestionsContainer.innerHTML = `
                <div class="search-loading">
                    <div class="search-loading-spinner"></div>
                    <span>正在搜索...</span>
                </div>
            `;
            suggestionsContainer.classList.add('active');
            
            // 模拟API请求延迟
            setTimeout(() => {
                // 这里应该是实际的API请求，但由于我们没有实际的后端API，所以使用模拟数据
                // 在实际项目中，这里应该是一个fetch或ajax请求
                const mockResults = [
                    {
                        title: '如何优化网站性能',
                        excerpt: '本文将介绍提升网站性能的几种方法，包括代码优化、图片压缩等技巧...',
                        category: '技术',
                        url: '#post-1'
                    },
                    {
                        title: 'CSS动画实践指南',
                        excerpt: '学习如何使用CSS创建流畅的动画效果，提升用户体验...',
                        category: '前端',
                        url: '#post-2'
                    },
                    {
                        title: '响应式设计最佳实践',
                        excerpt: '探讨如何设计适应不同设备屏幕的网站布局...',
                        category: '设计',
                        url: '#post-3'
                    }
                ];
                
                // 过滤结果
                suggestions = mockResults.filter(item => 
                    item.title.toLowerCase().includes(query.toLowerCase()) ||
                    item.excerpt.toLowerCase().includes(query.toLowerCase()) ||
                    item.category.toLowerCase().includes(query.toLowerCase())
                );
                
                renderSuggestions(suggestions, query);
            }, 500);
        }
        
        // 渲染搜索建议
        function renderSuggestions(items, query) {
            if (items.length === 0) {
                suggestionsContainer.innerHTML = `
                    <div class="search-no-results">
                        <i class="fas fa-search"></i>
                        <p>没有找到与 "${query}" 相关的内容</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            
            // 添加建议项
            items.forEach(item => {
                html += `
                    <div class="suggestion-item" data-url="${item.url}">
                        <div class="suggestion-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="suggestion-content">
                            <div class="suggestion-title">${item.title}</div>
                            <div class="suggestion-excerpt">${item.excerpt}</div>
                        </div>
                        <div class="suggestion-category">${item.category}</div>
                    </div>
                `;
            });
            
            // 添加页脚
            html += `
                <div class="search-footer">
                    <div class="search-footer-info">
                        <i class="fas fa-info-circle"></i>
                        <span>找到 ${items.length} 个结果</span>
                    </div>
                    <div class="search-footer-action" id="viewAllResults">查看全部结果</div>
                </div>
            `;
            
            suggestionsContainer.innerHTML = html;
            selectedIndex = -1;
            
            // 绑定点击事件
            suggestionsContainer.querySelectorAll('.suggestion-item').forEach(item => {
                item.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    if (url.startsWith('#')) {
                        // 这里是模拟数据，实际应该跳转到文章页面
                        searchInput.value = this.querySelector('.suggestion-title').textContent;
                        suggestionsContainer.classList.remove('active');
                    } else {
                        window.location.href = url;
                    }
                });
            });
            
            // 绑定查看全部结果事件
            document.getElementById('viewAllResults').addEventListener('click', function() {
                document.getElementById('search').submit();
            });
        }
        
        // 显示建议
        function showSuggestions() {
            const query = searchInput.value.trim();
            if (query.length >= 2 && suggestions.length > 0) {
                renderSuggestions(suggestions, query);
                suggestionsContainer.classList.add('active');
            }
        }
    });
    </script>
