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
    
    <!-- Favicon -->
    <?php if ($this->options->favicon): ?>
    <link rel="icon" href="<?php $this->options->favicon() ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php $this->options->favicon() ?>" type="image/x-icon">
    <?php endif; ?>
    
    <!-- 自定义字体 -->
    <?php if ($this->options->customFont): ?>
    <style>
        @font-face {
            font-family: 'CustomFont';
            src: url('<?php $this->options->customFont() ?>');
        }
        body {
            font-family: 'CustomFont', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>
    <?php endif; ?>
    
    <!-- 动态背景样式 -->
    <?php if ($this->options->dynamicBackground && $this->options->dynamicBackground != 'off'): ?>
    <style>
        #dynamic-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }
        @media (max-width: 768px) {
            #dynamic-background { display: none; }
        }
    </style>
    <?php endif; ?>
    
    <!-- 背景图片样式 -->
    <?php if ($this->options->wallpaperPC || $this->options->wallpaperMobile): ?>
    <style>
        body {
            <?php if ($this->options->wallpaperPC): ?>
            background-image: url('<?php $this->options->wallpaperPC() ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            <?php endif; ?>
        }
        @media (max-width: 768px) {
            body {
                <?php if ($this->options->wallpaperMobile): ?>
                background-image: url('<?php $this->options->wallpaperMobile() ?>');
                <?php endif; ?>
                background-attachment: scroll;
            }
        }
    </style>
    <?php endif; ?>
    
    <!-- 列表动画样式 -->
    <?php if ($this->options->listAnimate && $this->options->listAnimate != 'off'): ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .post-item {
            animation: <?php $this->options->listAnimate() ?> 0.8s ease-in-out;
        }
        .post-item:nth-child(2) { animation-delay: 0.1s; }
        .post-item:nth-child(3) { animation-delay: 0.2s; }
        .post-item:nth-child(4) { animation-delay: 0.3s; }
        .post-item:nth-child(5) { animation-delay: 0.4s; }
    </style>
    <?php endif; ?>
    
    <!-- 代码高亮样式 -->
    <?php if ($this->options->prismTheme): ?>
    <link rel="stylesheet" href="<?php $this->options->prismTheme() ?>">
    <?php else: ?>
    <link rel="stylesheet" href="//npm.elemecdn.com/prismjs@1.29.0/themes/prism.min.css">
    <?php endif; ?>
    <script src="//npm.elemecdn.com/prismjs@1.29.0/components/prism-core.min.js"></script>
    <script src="//npm.elemecdn.com/prismjs@1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="//npm.elemecdn.com/prismjs@1.29.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
    <script src="//npm.elemecdn.com/prismjs@1.29.0/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
    <link rel="stylesheet" href="//npm.elemecdn.com/prismjs@1.29.0/plugins/line-numbers/prism-line-numbers.min.css">
    <style>
        pre[class*="language-"] {
            position: relative;
            border-radius: 8px;
            margin: 1.5em 0;
            overflow: auto;
        }
        .copy-to-clipboard-button {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .copy-to-clipboard-button:hover {
            background: rgba(255, 255, 255, 1);
        }
        .line-numbers .line-numbers-rows {
            border-right: 1px solid #ddd;
        }
    </style>
    
    <!-- 网页标题切换 -->
    <?php if ($this->options->documentTitle): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var originalTitle = document.title;
            var hiddenTitle = '<?php $this->options->documentTitle() ?>';
            
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    document.title = hiddenTitle;
                } else {
                    document.title = originalTitle;
                }
            });
        });
    </script>
    <?php endif; ?>
    
    <!-- 自定义head内容 -->
    <?php if ($this->options->customHeadEnd): ?>
    <?php $this->options->customHeadEnd() ?>
    <?php endif; ?>
    
    <!-- 自定义CSS -->
    <?php if ($this->options->customCSS): ?>
    <style type="text/css">
        <?php $this->options->customCSS() ?>
    </style>
    <?php endif; ?>

    <?php $this->header(); ?>
    
    <!-- 自定义JavaScript -->
    <?php if ($this->options->customJS): ?>
    <script type="text/javascript">
        <?php $this->options->customJS() ?>
    </script>
    <?php endif; ?>
    
    <!-- 统计代码 -->
    <?php if ($this->options->analytics): ?>
    <?php $this->options->analytics() ?>
    <?php endif; ?>
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
        
        // 移动端菜单增强
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mainNav = document.getElementById('nav-menu');
        const body = document.body;
        
        // 检查是否为移动设备
        function isMobile() {
            return window.innerWidth <= 991;
        }
        
        // 关闭移动端菜单
        function closeMobileMenu() {
            if (mobileMenuToggle && mainNav) {
                mobileMenuToggle.classList.remove('active');
                mainNav.classList.remove('show');
                body.classList.remove('menu-open');
                // 恢复页面滚动
                body.style.position = '';
                body.style.width = '';
                
                // 添加关闭动画
                mainNav.style.opacity = '0';
                mainNav.style.visibility = 'hidden';
                mainNav.style.transform = 'translateY(-20px)';
                
                // 延迟隐藏
                setTimeout(() => {
                    if (!mainNav.classList.contains('show')) {
                        mainNav.style.display = 'none';
                    }
                }, 300);
            }
        }
        
        // 打开移动端菜单
        function openMobileMenu() {
            if (mobileMenuToggle && mainNav) {
                mobileMenuToggle.classList.add('active');
                mainNav.classList.add('show');
                body.classList.add('menu-open');
                // 禁止页面滚动
                body.style.position = 'fixed';
                body.style.width = '100%';
                
                // 确保菜单可见性
                mainNav.style.display = 'flex';
                
                // 添加动画延迟
                requestAnimationFrame(() => {
                    mainNav.style.opacity = '1';
                    mainNav.style.visibility = 'visible';
                    mainNav.style.transform = 'translateY(0)';
                });
            }
        }
        
        // 检查屏幕宽度变化
        function handleResize() {
            if (!isMobile()) {
                closeMobileMenu();
            }
        }
        
        // 初始化
        if (isMobile()) {
            closeMobileMenu();
        }
        
        // 监听窗口大小变化
        window.addEventListener('resize', handleResize);
        
        // 增强的菜单切换处理
        if (mobileMenuToggle && mainNav) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // 防止快速点击
                if (mobileMenuToggle.disabled) return;
                mobileMenuToggle.disabled = true;
                
                setTimeout(() => {
                    mobileMenuToggle.disabled = false;
                }, 300);
                
                if (mainNav.classList.contains('show')) {
                    closeMobileMenu();
                } else {
                    openMobileMenu();
                }
            });
            
            // 触摸事件优化
            mobileMenuToggle.addEventListener('touchstart', function(e) {
                e.preventDefault();
            }, { passive: false });
        }
        
        // 点击菜单项后自动关闭菜单
        if (mainNav) {
            const navLinks = mainNav.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (isMobile() && mainNav.classList.contains('show')) {
                        // 延迟关闭，让用户看到点击效果
                        setTimeout(() => {
                            closeMobileMenu();
                        }, 150);
                    }
                });
            });
        }
        
        // 点击菜单外区域关闭菜单
        document.addEventListener('click', function(event) {
            if (isMobile() && 
                mainNav && 
                mainNav.classList.contains('show') &&
                !mainNav.contains(event.target) && 
                !mobileMenuToggle.contains(event.target)) {
                closeMobileMenu();
            }
        });
        
        // ESC键关闭菜单
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && isMobile() && mainNav && mainNav.classList.contains('show')) {
                closeMobileMenu();
            }
        });
        
        // 防止菜单滚动穿透
        if (mainNav) {
            mainNav.addEventListener('touchmove', function(e) {
                if (isMobile() && mainNav.classList.contains('show')) {
                    e.preventDefault();
                }
            }, { passive: false });
        }
        
        // 窗口大小改变时自动关闭菜单
        window.addEventListener('resize', function() {
            if (!isMobile() && mainNav && mainNav.classList.contains('show')) {
                closeMobileMenu();
            }
        });
        
        // 页面可见性改变时关闭菜单
        document.addEventListener('visibilitychange', function() {
            if (document.hidden && mainNav && mainNav.classList.contains('show')) {
                closeMobileMenu();
            }
        });
        
        // 优化菜单项点击体验
        if (mainNav) {
            const navLinks = mainNav.querySelectorAll('a');
            navLinks.forEach(link => {
                // 添加触摸反馈
                link.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.95)';
                }, { passive: true });
                
                link.addEventListener('touchend', function() {
                    this.style.transform = '';
                }, { passive: true });
                
                link.addEventListener('touchcancel', function() {
                    this.style.transform = '';
                }, { passive: true });
            });
        }
        
        // 返回顶部功能已移至footer.js中统一处理
        
        // 头部滚动效果
        const header = document.getElementById('header');
        let lastScrollTop = 0;
        let ticking = false;
        
        function updateHeader() {
            const scrollTop = window.pageYOffset;
            
            // 基础滚动效果
            if (scrollTop > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            // 移动端滚动隐藏效果
            if (window.innerWidth <= 767) {
                if (scrollTop > lastScrollTop && scrollTop > 200) {
                    // 向下滚动且超过200px时隐藏
                    header.style.transform = 'translateY(-100%)';
                } else if (scrollTop < lastScrollTop || scrollTop <= 100) {
                    // 向上滚动或接近顶部时显示
                    header.style.transform = 'translateY(0)';
                }
            } else {
                // 桌面端重置transform
                header.style.transform = '';
            }
            
            lastScrollTop = scrollTop;
            ticking = false;
        }
        
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateHeader);
                ticking = true;
            }
        });
        
        // 窗口大小改变时重置样式
        window.addEventListener('resize', function() {
            if (window.innerWidth > 767) {
                header.style.transform = '';
            }
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
