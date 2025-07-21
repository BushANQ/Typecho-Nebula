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
                        <p>&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>. All rights reserved.</p>
                        <p class="power-by">
                            Powered by <a href="https://typecho.org" target="_blank" rel="noopener">Typecho</a> 
                            | Theme by <a href="javascript:void(0)" class="theme-info">Nebula</a>
                        </p>
                    </div>
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

<style>
/* Footer 样式 */
.site-footer {
    background: linear-gradient(135deg, var(--bg-secondary), var(--bg-tertiary));
    border-top: 1px solid var(--border-color);
    margin-top: 4rem;
    position: relative;
    overflow: hidden;
}

.site-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

/* Footer Main */
.footer-main {
    padding: 3rem 0 2rem;
    position: relative;
}

.footer-section {
    margin-bottom: 2rem;
}

/* 网站信息区域 */
.about-section .footer-logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    font-weight: 700;
}

.footer-logo .logo-img {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md);
}

.footer-logo .logo-icon {
    font-size: 2rem;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.footer-logo .logo-text {
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.footer-description {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.footer-description p {
    margin-bottom: 1rem;
}

.site-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    font-size: 0.9rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.stat-item i {
    color: var(--accent-primary);
    font-size: 0.8rem;
}

/* 社交链接 */
.footer-social {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 50%;
    color: var(--text-secondary);
    text-decoration: none;
    transition: all var(--transition-fast) ease;
    position: relative;
    overflow: hidden;
}

.social-link::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--gradient-primary);
    opacity: 0;
    transition: opacity var(--transition-fast) ease;
}

.social-link i {
    position: relative;
    z-index: 1;
    transition: all var(--transition-fast) ease;
}

.social-link::after {
    display: none;
}

.social-link:hover {
    transform: translateY(-2px) scale(1.1);
    box-shadow: 0 4px 15px var(--shadow-medium);
    border-color: transparent;
    color: white;
}

.social-link:hover::before {
    opacity: 1;
}

/* Footer 标题 */
.footer-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    position: relative;
    padding-bottom: 0.5rem;
}

.footer-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 30px;
    height: 2px;
    background: var(--gradient-primary);
    border-radius: 1px;
}

.footer-title i {
    color: var(--accent-primary);
    font-size: 1rem;
}

/* Footer 链接 */
.footer-links {
    list-style: none;
    margin: 0;
    padding: 0;
}

.footer-links li {
    margin-bottom: 0.75rem;
}

.footer-links a {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    text-decoration: none;
    padding: 0.5rem 0;
    transition: all var(--transition-fast) ease;
    border-radius: var(--radius-sm);
}

.footer-links a::after {
    display: none;
}

.footer-links a:hover {
    color: var(--accent-primary);
    background: rgba(0, 123, 255, 0.1);
    transform: translateX(5px);
    padding-left: 0.75rem;
}

.footer-links i {
    font-size: 0.8rem;
    width: 16px;
    text-align: center;
    color: var(--accent-primary);
}

/* 最新文章 */
.footer-recent-posts {
    list-style: none;
    margin: 0;
    padding: 0;
}

.recent-post-item {
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.recent-post-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.recent-post-link {
    display: block;
    text-decoration: none;
    transition: all var(--transition-fast) ease;
}

.recent-post-link::after {
    display: none;
}

.recent-post-link:hover {
    transform: translateX(5px);
}

.recent-post-title {
    display: block;
    color: var(--text-primary);
    font-weight: 500;
    margin-bottom: 0.4rem;
    line-height: 1.4;
    transition: color var(--transition-fast) ease;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.recent-post-link:hover .recent-post-title {
    color: var(--accent-primary);
}

.recent-post-date {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    color: var(--text-muted);
    font-size: 0.8rem;
}

.recent-post-date i {
    font-size: 0.7rem;
    color: var(--accent-primary);
}

/* Footer Bottom */
.footer-bottom {
    background: var(--bg-primary);
    border-top: 1px solid var(--border-color);
    padding: 1.5rem 0;
}

.footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.copyright-text {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
}

.copyright-text p {
    margin: 0;
}

.copyright-text a {
    color: var(--accent-primary);
    text-decoration: none;
    transition: color var(--transition-fast) ease;
}

.copyright-text a::after {
    display: none;
}

.copyright-text a:hover {
    color: var(--accent-secondary);
}

.power-by {
    margin-top: 0.25rem;
    opacity: 0.8;
}

/* Footer 工具 */
.footer-tools {
    display: flex;
    gap: 0.75rem;
}

.back-to-top {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 50%;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all var(--transition-fast) ease;
    position: relative;
    overflow: hidden;
}

.back-to-top::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--gradient-primary);
    opacity: 0;
    transition: opacity var(--transition-fast) ease;
    border-radius: 50%;
}

.back-to-top i {
    position: relative;
    z-index: 1;
    transition: all var(--transition-fast) ease;
}

.back-to-top:hover {
    transform: translateY(-2px) scale(1.1);
    box-shadow: 0 6px 20px var(--shadow-medium);
    color: white;
    border-color: transparent;
}

.back-to-top:hover::before {
    opacity: 1;
}

/* 粒子背景 */
.particles-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: -1;
    opacity: 0.3;
}

#particlesCanvas {
    width: 100%;
    height: 100%;
}

/* 页面加载动画 */
.page-loading-overlay {
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
    transition: all var(--transition-slow) ease;
}

.page-loading-overlay.hidden {
    opacity: 0;
    visibility: hidden;
}

.loading-container {
    text-align: center;
}

.loading-spinner {
    position: relative;
    width: 80px;
    height: 80px;
    margin-bottom: 1rem;
}

.spinner-ring {
    position: absolute;
    width: 100%;
    height: 100%;
    border: 3px solid transparent;
    border-top-color: var(--accent-primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

.spinner-ring:nth-child(2) {
    width: 60%;
    height: 60%;
    top: 20%;
    left: 20%;
    border-top-color: var(--accent-secondary);
    animation-duration: 1.5s;
    animation-direction: reverse;
}

.spinner-ring:nth-child(3) {
    width: 40%;
    height: 40%;
    top: 30%;
    left: 30%;
    border-top-color: #28a745;
    animation-duration: 2s;
}

.loading-text {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 初始化 Footer 功能
    initBackToTop();
    initParticles();
    initPageLoading();
    initScrollEffects();
});

// 回到顶部功能
function initBackToTop() {
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
