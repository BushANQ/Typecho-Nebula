<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

        </div><!-- end .row -->
    </div>
</div><!-- end #body -->

<!-- 粒子背景 -->
<div class="particles-bg" id="particlesBg">
    <canvas id="particlesCanvas"></canvas>
</div>

<!-- 页面加载动画 -->
<div class="page-loading-overlay" id="pageLoading">
    <div class="loading-container">
        <div class="loading-spinner">
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
        </div>
        <p class="loading-text">正在加载...</p>
    </div>
</div>

<!-- Footer -->
<footer id="footer" class="site-footer" role="contentinfo">
    <!-- Footer Main -->
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <!-- 网站信息 -->
                <div class="col-mb-12 col-6 col-tb-12">
                    <div class="footer-section about-section">
                        <div class="footer-logo">
                            <?php if ($this->options->logoUrl): ?>
                                <img src="<?php $this->options->logoUrl() ?>" alt="<?php $this->options->title() ?>" class="logo-img">
                            <?php else: ?>
                                <i class="fas fa-blog logo-icon"></i>
                            <?php endif; ?>
                            <span class="logo-text"><?php $this->options->title() ?></span>
                        </div>
                        
                        <!--<div class="footer-description">-->
                        <!--    <p><?php $this->options->description() ?></p>-->
                        <!--    <p class="site-stats">-->
                        <!--        <span class="stat-item">-->
                        <!--            <i class="fas fa-file-alt"></i>-->
                        <!--            <span id="footerPostCount">-</span> 篇文章-->
                        <!--        </span>-->
                        <!--        <span class="stat-item">-->
                        <!--            <i class="fas fa-comments"></i>-->
                        <!--            <span id="footerCommentCount">-</span> 条评论-->
                        <!--        </span>-->
                        <!--        <span class="stat-item">-->
                        <!--            <i class="fas fa-eye"></i>-->
                        <!--            <span id="footerViewCount">-</span> 次访问-->
                        <!--        </span>-->
                        <!--    </p>-->
                        <!--</div>-->
                        
                        <!-- 社交链接 -->
                        <?php if ($this->options->socialLinks): ?>
                            <div class="footer-social">
                                <?php 
                                $socialLinks = explode("\n", $this->options->socialLinks);
                                foreach ($socialLinks as $link) {
                                    if (trim($link)) {
                                        $parts = explode('|', trim($link));
                                        if (count($parts) >= 2) {
                                            $name = trim($parts[0]);
                                            $url = trim($parts[1]);
                                            $icon = isset($parts[2]) ? trim($parts[2]) : 'fas fa-link';
                                            echo '<a href="' . $url . '" target="_blank" rel="noopener" class="social-link" title="' . $name . '" aria-label="' . $name . '">';
                                            echo '<i class="' . $icon . '"></i>';
                                            echo '</a>';
                                        }
                                    }
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- 快捷链接 -->
                <div class="col-mb-12 col-3 col-tb-6">
                    <div class="footer-section links-section">
                        <h4 class="footer-title">
                            <i class="fas fa-link"></i>
                            <span>快捷链接</span>
                        </h4>
                        <ul class="footer-links">
                            <li><a href="<?php $this->options->siteUrl(); ?>"><i class="fas fa-home"></i> 首页</a></li>
                            <?php Typecho_Widget::widget('Widget_Contents_Page_List')->to($pages); ?>
                            <?php while ($pages->next()): ?>
                                <li>
                                    <a href="<?php $pages->permalink(); ?>">
                                        <i class="fas fa-file-alt"></i>
                                        <?php $pages->title(); ?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                            <li><a href="<?php $this->options->feedUrl(); ?>" target="_blank"><i class="fas fa-rss"></i> RSS 订阅</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- 最新文章 -->
                <div class="col-mb-12 col-3 col-tb-6">
                    <div class="footer-section recent-section">
                        <h4 class="footer-title">
                            <i class="fas fa-newspaper"></i>
                            <span>最新文章</span>
                        </h4>
                        <ul class="footer-recent-posts">
                            <?php Typecho_Widget::widget('Widget_Contents_Post_Recent', 'pageSize=5')->to($recent); ?>
                            <?php if ($recent->have()): ?>
                                <?php while ($recent->next()): ?>
                                    <li class="recent-post-item">
                                        <a href="<?php $recent->permalink(); ?>" class="recent-post-link">
                                            <span class="recent-post-title"><?php $recent->title(); ?></span>
                                            <span class="recent-post-date">
                                                <i class="fas fa-calendar"></i>
                                                <?php echo formatTime($recent->created); ?>
                                            </span>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <div class="copyright">
                    <div class="copyright-text">
                        <?php if ($this->options->footerLeft): ?>
                            <p><?php $this->options->footerLeft() ?></p>
                        <?php else: ?>
                            <p>&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>. All rights reserved.</p>
                        <?php endif; ?>
                        
                        <?php if ($this->options->birthDay): ?>
                            <p class="site-runtime">
                                <i class="fas fa-heartbeat"></i>
                                网站已运行 <span id="site-runtime">-</span>
                            </p>
                        <?php endif; ?>
                        
                        <p class="power-by">
                            Powered by <a href="https://typecho.org" target="_blank" rel="noopener">Typecho</a> 
                            | Theme by <a href="javascript:void(0)" class="theme-info">Nebula</a>
                        </p>
                    </div>
                </div>
                
                <div class="footer-right-content">
                    <?php if ($this->options->footerRight): ?>
                        <?php $this->options->footerRight() ?>
                    <?php endif; ?>
                </div>
                
                <div class="footer-tools">
                    <!-- 回到顶部 -->
                    <button class="back-to-top" id="backToTop" title="回到顶部" aria-label="回到顶部">
                        <i class="fas fa-chevron-up"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</footer>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // 初始化 Footer 功能
    initBackToTop();
    initParticles();
    initPageLoading();
    initScrollEffects();
    initReadingProgress();
    initImageViewer();
});

// 阅读进度条功能
function initReadingProgress() {
    const progressBar = document.getElementById('readingProgress');
    if (!progressBar) return;
    
    // 只在文章页面显示进度条
    const isPostPage = document.querySelector('.single-post');
    if (!isPostPage) {
        progressBar.style.display = 'none';
        return;
    }
    
    window.addEventListener('scroll', function() {
        // 计算滚动进度
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        
        // 更新进度条宽度
        progressBar.style.width = scrolled + '%';
        
        // 添加动画效果
        if (scrolled > 0) {
            progressBar.classList.add('active');
        } else {
            progressBar.classList.remove('active');
        }
    });
}

// 图片查看器功能
function initImageViewer() {
    // 只在文章页面初始化图片查看器
    const postContent = document.querySelector('.post-content');
    if (!postContent) return;
    
    // 创建图片查看器容器
    const viewer = document.createElement('div');
    viewer.className = 'image-viewer';
    viewer.innerHTML = `
        <div class="image-viewer-overlay"></div>
        <div class="image-viewer-container">
            <img src="" alt="" class="viewer-image">
            <div class="viewer-controls">
                <button class="viewer-prev"><i class="fas fa-chevron-left"></i></button>
                <button class="viewer-next"><i class="fas fa-chevron-right"></i></button>
                <button class="viewer-close"><i class="fas fa-times"></i></button>
                <button class="viewer-zoom-in"><i class="fas fa-search-plus"></i></button>
                <button class="viewer-zoom-out"><i class="fas fa-search-minus"></i></button>
            </div>
        </div>
    `;
    document.body.appendChild(viewer);
    
    // 获取所有文章中的图片
    const images = postContent.querySelectorAll('img');
    let currentIndex = 0;
    let scale = 1;
    
    // 为每个图片添加点击事件
    images.forEach((img, index) => {
        // 添加可点击的样式
        img.style.cursor = 'zoom-in';
        
        img.addEventListener('click', function(e) {
            e.preventDefault();
            currentIndex = index;
            scale = 1;
            openViewer(img.src, img.alt);
        });
    });
    
    // 打开图片查看器
    function openViewer(src, alt) {
        const viewerImage = viewer.querySelector('.viewer-image');
        viewerImage.src = src;
        viewerImage.alt = alt || '';
        viewerImage.style.transform = `scale(${scale})`;
        
        viewer.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    // 关闭图片查看器
    function closeViewer() {
        viewer.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // 查看上一张图片
    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        scale = 1;
        openViewer(images[currentIndex].src, images[currentIndex].alt);
    }
    
    // 查看下一张图片
    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        scale = 1;
        openViewer(images[currentIndex].src, images[currentIndex].alt);
    }
    
    // 放大图片
    function zoomIn() {
        scale = Math.min(scale + 0.2, 3);
        viewer.querySelector('.viewer-image').style.transform = `scale(${scale})`;
    }
    
    // 缩小图片
    function zoomOut() {
        scale = Math.max(scale - 0.2, 0.5);
        viewer.querySelector('.viewer-image').style.transform = `scale(${scale})`;
    }
    
    // 绑定事件
    viewer.querySelector('.viewer-close').addEventListener('click', closeViewer);
    viewer.querySelector('.viewer-prev').addEventListener('click', prevImage);
    viewer.querySelector('.viewer-next').addEventListener('click', nextImage);
    viewer.querySelector('.viewer-zoom-in').addEventListener('click', zoomIn);
    viewer.querySelector('.viewer-zoom-out').addEventListener('click', zoomOut);
    viewer.querySelector('.image-viewer-overlay').addEventListener('click', closeViewer);
    
    // 键盘快捷键
    document.addEventListener('keydown', function(e) {
        if (!viewer.classList.contains('active')) return;
        
        switch(e.key) {
            case 'Escape':
                closeViewer();
                break;
            case 'ArrowLeft':
                prevImage();
                break;
            case 'ArrowRight':
                nextImage();
                break;
            case '+':
                zoomIn();
                break;
            case '-':
                zoomOut();
                break;
        }
    });
}

// 回到顶部功能
function initBackToTop() {
    const backToTop = document.getElementById('backToTop');
    
    if (!backToTop) {
        console.warn('返回顶部按钮未找到');
        return;
    }
    
    let isScrolling = false;
    
    // 监听滚动事件，控制按钮显示/隐藏
    function handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 300) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    }
    
    // 使用节流优化滚动性能
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        if (scrollTimeout) {
            clearTimeout(scrollTimeout);
        }
        scrollTimeout = setTimeout(handleScroll, 10);
    });
    
    // 初始检查
    handleScroll();
    
    // 点击事件 - 平滑滚动到顶部
    backToTop.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (isScrolling) return;
        
        isScrolling = true;
        
        // 添加点击动画效果
        backToTop.classList.add('clicked');
        
        // 使用现代浏览器的平滑滚动
        if ('scrollBehavior' in document.documentElement.style) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
            // 监听滚动结束
            const checkScrollEnd = () => {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                if (scrollTop <= 0) {
                    backToTop.classList.remove('clicked');
                    isScrolling = false;
                } else {
                    requestAnimationFrame(checkScrollEnd);
                }
            };
            requestAnimationFrame(checkScrollEnd);
        } else {
            // 降级方案：自定义平滑滚动
            const scrollToTop = () => {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                if (scrollTop > 0) {
                    window.scrollTo(0, scrollTop - scrollTop / 8);
                    requestAnimationFrame(scrollToTop);
                } else {
                    backToTop.classList.remove('clicked');
                    isScrolling = false;
                }
            };
            requestAnimationFrame(scrollToTop);
        }
    });
}

// 粒子背景效果
function initParticles() {
    const canvas = document.getElementById('particlesCanvas');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    const particles = [];
    const particleCount = 50;
    
    // 设置画布大小
    const resizeCanvas = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };
    
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);
    
    // 创建粒子
    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.vx = (Math.random() - 0.5) * 2;
            this.vy = (Math.random() - 0.5) * 2;
            this.radius = Math.random() * 2 + 1;
            this.opacity = Math.random() * 0.5 + 0.3;
        }
        
        update() {
            this.x += this.vx;
            this.y += this.vy;
            
            if (this.x < 0 || this.x > canvas.width) this.vx = -this.vx;
            if (this.y < 0 || this.y > canvas.height) this.vy = -this.vy;
        }
        
        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(0, 123, 255, ${this.opacity})`;
            ctx.fill();
        }
    }
    
    // 初始化粒子
    for (let i = 0; i < particleCount; i++) {
        particles.push(new Particle());
    }
    
    // 动画循环
    const animate = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        particles.forEach(particle => {
            particle.update();
            particle.draw();
        });
        
        // 连接nearby粒子
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < 100) {
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.strokeStyle = `rgba(0, 123, 255, ${0.1 * (1 - distance / 100)})`;
                    ctx.stroke();
                }
            }
        }
        
        requestAnimationFrame(animate);
    };
    
    animate();
}

// 页面加载动画
function initPageLoading() {
    const loadingOverlay = document.getElementById('pageLoading');
    if (!loadingOverlay) return;
    
    window.addEventListener('load', () => {
        setTimeout(() => {
            loadingOverlay.classList.add('hidden');
            setTimeout(() => {
                loadingOverlay.style.display = 'none';
            }, 500);
        }, 500);
    });
}

// 滚动效果
function initScrollEffects() {
    // 视差效果
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallax = document.querySelector('.particles-bg');
        
        if (parallax) {
            const speed = scrolled * 0.3;
            parallax.style.transform = `translateY(${speed}px)`;
        }
    });
    
    // Footer 进入动画
    if (window.IntersectionObserver) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        }, {
            threshold: 0.1
        });
        
        const footerSections = document.querySelectorAll('.footer-section');
        footerSections.forEach(section => {
            observer.observe(section);
        });
    }
}

// 工具函数
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// 错误处理
window.addEventListener('error', function(e) {
    console.warn('页面出现错误:', e.error);
});
</script>

<!-- 动态背景 -->
<?php if ($this->options->dynamicBackground && $this->options->dynamicBackground != 'off'): ?>
<div id="dynamic-background"></div>
<script>
(function() {
    if (window.innerWidth <= 768) return; // 移动端不显示
    
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const container = document.getElementById('dynamic-background');
    container.appendChild(canvas);
    
    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);
    
    const effect = '<?php $this->options->dynamicBackground() ?>';
    
    if (effect === 'particles') {
        // 粒子效果
        const particles = [];
        for (let i = 0; i < 50; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                vx: (Math.random() - 0.5) * 2,
                vy: (Math.random() - 0.5) * 2,
                size: Math.random() * 3 + 1
            });
        }
        
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = 'rgba(74, 144, 226, 0.6)';
            
            particles.forEach(p => {
                p.x += p.vx;
                p.y += p.vy;
                
                if (p.x < 0 || p.x > canvas.width) p.vx *= -1;
                if (p.y < 0 || p.y > canvas.height) p.vy *= -1;
                
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                ctx.fill();
            });
            
            requestAnimationFrame(animate);
        }
        animate();
    } else if (effect === 'waves') {
        // 波浪效果
        let time = 0;
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = 'rgba(74, 144, 226, 0.1)';
            
            for (let i = 0; i < 3; i++) {
                ctx.beginPath();
                ctx.moveTo(0, canvas.height / 2);
                
                for (let x = 0; x <= canvas.width; x += 10) {
                    const y = canvas.height / 2 + Math.sin((x + time + i * 100) * 0.01) * 50;
                    ctx.lineTo(x, y);
                }
                
                ctx.lineTo(canvas.width, canvas.height);
                ctx.lineTo(0, canvas.height);
                ctx.fill();
            }
            
            time += 2;
            requestAnimationFrame(animate);
        }
        animate();
    }
})();
</script>
<?php endif; ?>

<!-- 鼠标特效 -->
<?php if ($this->options->cursorEffects && $this->options->cursorEffects != 'off'): ?>
<script>
(function() {
    if (window.innerWidth <= 768) return; // 移动端不显示
    
    const effect = '<?php $this->options->cursorEffects() ?>';
    
    if (effect === 'cursor1') {
        // 彩色粒子
        document.addEventListener('mousemove', function(e) {
            const particle = document.createElement('div');
            particle.style.cssText = `
                position: fixed;
                left: ${e.clientX}px;
                top: ${e.clientY}px;
                width: 6px;
                height: 6px;
                background: hsl(${Math.random() * 360}, 70%, 60%);
                border-radius: 50%;
                pointer-events: none;
                z-index: 9999;
                animation: cursorParticle 1s ease-out forwards;
            `;
            document.body.appendChild(particle);
            
            setTimeout(() => particle.remove(), 1000);
        });
        
        const style = document.createElement('style');
        style.textContent = `
            @keyframes cursorParticle {
                0% { transform: scale(1); opacity: 1; }
                100% { transform: scale(0); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    } else if (effect === 'cursor2') {
        // 爱心
        document.addEventListener('click', function(e) {
            const heart = document.createElement('div');
            heart.innerHTML = '❤️';
            heart.style.cssText = `
                position: fixed;
                left: ${e.clientX}px;
                top: ${e.clientY}px;
                font-size: 20px;
                pointer-events: none;
                z-index: 9999;
                animation: cursorHeart 2s ease-out forwards;
            `;
            document.body.appendChild(heart);
            
            setTimeout(() => heart.remove(), 2000);
        });
        
        const style = document.createElement('style');
        style.textContent = `
            @keyframes cursorHeart {
                0% { transform: translateY(0) scale(1); opacity: 1; }
                100% { transform: translateY(-100px) scale(0); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }
})();
</script>
<?php endif; ?>

<!-- 网站运行时间 -->
<?php if ($this->options->birthDay): ?>
<script>
function updateRunTime() {
    const birthDay = new Date('<?php $this->options->birthDay() ?>');
    const now = new Date();
    const diff = now - birthDay;
    
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
    
    const runTimeElement = document.getElementById('site-runtime');
    if (runTimeElement) {
        runTimeElement.innerHTML = `${days}天${hours}小时${minutes}分${seconds}秒`;
    }
}

if (document.getElementById('site-runtime')) {
    updateRunTime();
    setInterval(updateRunTime, 1000);
}
</script>
<?php endif; ?>

<!-- 自定义body末尾内容 -->
<?php if ($this->options->customBodyEnd): ?>
<?php $this->options->customBodyEnd() ?>
<?php endif; ?>

<!-- 自定义统计代码 -->
<?php if ($this->options->analytics): ?>
    <?php echo $this->options->analytics; ?>
<?php endif; ?>

<!-- 自定义 JavaScript -->
<?php if ($this->options->customJS): ?>
    <script>
    <?php echo $this->options->customJS; ?>
    </script>
<?php endif; ?>

<?php $this->footer(); ?>
</body>
</html>
