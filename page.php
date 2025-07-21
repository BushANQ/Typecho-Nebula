<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="main-layout">
    <main class="main-content" id="main" role="main">
        <article class="page single-page" itemscope itemtype="http://schema.org/WebPage">
            <!-- 页面头部 -->
            <header class="page-header">
                <?php $thumbnail = getPostThumbnail($this); ?>
                <?php if ($thumbnail): ?>
                    <div class="page-featured-image">
                        <img src="<?php echo $thumbnail; ?>" 
                             alt="<?php $this->title(); ?>" 
                             itemprop="image"
                             class="featured-img">
                        <div class="image-overlay"></div>
                    </div>
                <?php endif; ?>
                
                <div class="page-header-content">
                    <!-- 面包屑导航 -->
                    <nav class="breadcrumb" aria-label="面包屑导航">
                        <a href="<?php $this->options->siteUrl(); ?>" class="breadcrumb-item">
                            <i class="fas fa-home"></i>
                            <span>首页</span>
                        </a>
                        <span class="breadcrumb-separator">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                        <span class="breadcrumb-current"><?php $this->title(); ?></span>
                    </nav>
                    
                    <!-- 页面图标 -->
                    <?php if ($this->fields->icon): ?>
                        <div class="page-icon">
                            <i class="<?php echo $this->fields->icon; ?>"></i>
                        </div>
                    <?php endif; ?>
                    
                    <h1 class="page-title" itemprop="name headline"><?php $this->title(); ?></h1>
                    <?php if ($this->fields->description): ?>
                        <div class="page-description"><?php echo $this->fields->description; ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- 页面元信息 -->
                <div class="page-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished">
                            <?php echo formatTime($this->created); ?>
                        </time>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-eye"></i>
                        <span class="view-count" data-post-id="<?php $this->cid(); ?>">-</span>
                    </div>
                </div>
            </header>
            
            <!-- 页面内容 -->
            <div class="page-content-wrapper">
                <?php if ($this->slug == 'archives'): ?>
                    <div class="archive-section">
                        <h3 class="section-title"><i class="fas fa-archive"></i> 全站归档</h3>
                        <div class="archive-timeline">
                            <?php
                            Typecho_Widget::widget('Widget_Contents_Post_Date', 'type=month&format=Y年m月')->to($archives);
                            while ($archives->next()):
                            ?>
                                <div class="timeline-year">
                                    <div class="year-header">
                                        <span class="year-number"><?php $archives->date(); ?></span>
                                        <span class="year-count">(<?php echo $archives->count(); ?> 篇)</span>
                                    </div>
                                    <ul class="month-posts">
                                        <?php
                                        Typecho_Widget::widget('Widget_Archive@' . $archives->date('Ym'), 'pageSize=100&type=month&date=' . $archives->date('Ym'))->to($posts);
                                        while ($posts->next()):
                                        ?>
                                            <li>
                                                <span class="post-date"><?php $posts->date('m-d'); ?></span>
                                                <a href="<?php $posts->permalink(); ?>"><?php $posts->title(); ?></a>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="page-content" itemprop="articleBody">
                        <?php $this->content(); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- 页面底部 -->
            <footer class="page-footer">
                <div class="page-info">
                    <div class="info-item">
                        <i class="fas fa-user"></i>
                        <span><?php $this->author(); ?></span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-folder-open"></i>
                        <span><?php $this->category(','); ?></span>
                    </div>
                </div>
                <div class="page-actions">
                    <a href="javascript:window.history.back();" class="action-btn"><i class="fas fa-arrow-left"></i> 返回</a>
                </div>
            </footer>
            
            <?php if ($this->allow('comment')): ?>
                <?php $this->need('comments.php'); ?>
            <?php endif; ?>
        </article>
    </main>
    <?php $this->need('sidebar.php'); ?>
</div>

<style>
/* 单页面样式 */
.single-page {
    background: var(--bg-primary);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border-color);
    overflow: hidden;
    box-shadow: 0 4px 20px var(--shadow-light);
    margin-bottom: 2rem;
}

/* 页面头部 */
.page-header {
    position: relative;
}

.page-featured-image {
    position: relative;
    height: 250px;
    overflow: hidden;
    background: var(--gradient-primary);
}

.featured-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.4) 100%);
}

.page-header-content {
    padding: 2rem;
    text-align: center;
}

/* 页面图标 */
.page-icon {
    margin: 1rem 0;
}

.page-icon i {
    font-size: 3rem;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* 页面标题 */
.page-title {
    font-size: 2.5rem;
    line-height: 1.3;
    margin: 1rem 0;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
}

/* 页面描述 */
.page-description {
    font-size: 1.1rem;
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 1rem 0;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* 页面元信息 */
.page-meta {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.page-meta .meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.page-meta .meta-item i {
    color: var(--accent-primary);
}

/* 页面内容 */
.page-content-wrapper {
    position: relative;
    padding: 2rem;
}

.page-content {
    line-height: 1.8;
    color: var(--text-primary);
    font-size: 1.05rem;
}

.page-content h1,
.page-content h2,
.page-content h3,
.page-content h4,
.page-content h5,
.page-content h6 {
    margin: 2rem 0 1rem;
    position: relative;
}

.page-content h2::before {
    content: '';
    position: absolute;
    left: -1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 1.5em;
    background: var(--gradient-primary);
    border-radius: 2px;
}

.page-content p {
    margin-bottom: 1.5rem;
}

.page-content img {
    max-width: 100%;
    height: auto;
    border-radius: var(--radius-md);
    box-shadow: 0 4px 15px var(--shadow-light);
    margin: 1.5rem 0;
}

/* 页面底部 */
.page-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: var(--bg-secondary);
    border-top: 1px solid var(--border-color);
}

.page-info {
    display: flex;
    gap: 2rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    font-size: 0.85rem;
}

.info-item i {
    color: var(--accent-primary);
    font-size: 0.8rem;
}

.page-actions {
    display: flex;
    gap: 1rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    background: var(--accent-primary);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all var(--transition-fast) ease;
}

.action-btn::after {
    display: none;
}

.action-btn:hover {
    background: var(--accent-secondary);
    transform: translateY(-1px);
    box-shadow: 0 4px 10px var(--shadow-medium);
}

/* 友情链接样式 */
.links-section {
    background: var(--bg-primary);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border-color);
    padding: 2rem;
    margin: 2rem 0;
    box-shadow: 0 4px 20px var(--shadow-light);
}

.section-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    margin-bottom: 2rem;
    font-size: 1.5rem;
    color: var(--text-primary);
}

.section-title i {
    color: var(--accent-primary);
}

.links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.link-item {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    transition: all var(--transition-fast) ease;
}

.link-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px var(--shadow-medium);
}

.link-avatar {
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
    background: var(--gradient-primary);
    display: flex;
    align-items: center;
    justify-content: center;
}

.link-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.link-avatar i {
    color: white;
    font-size: 1.5rem;
}

.link-info {
    flex: 1;
}

.link-name {
    margin: 0 0 0.5rem;
    font-size: 1.1rem;
}

.link-name a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color var(--transition-fast) ease;
}

.link-name a::after {
    display: none;
}

.link-name a:hover {
    color: var(--accent-primary);
}

.link-description {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
}

/* 归档页面样式 */
.archive-section {
    background: var(--bg-primary);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border-color);
    padding: 2rem;
    margin: 2rem 0;
    box-shadow: 0 4px 20px var(--shadow-light);
}

.archive-timeline {
    position: relative;
}

.timeline-year {
    margin-bottom: 2rem;
    position: relative;
    padding-left: 2rem;
}

.timeline-year::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 2px;
    height: 100%;
    background: var(--gradient-primary);
    border-radius: 1px;
}

.year-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    position: relative;
}

.year-header::before {
    content: '';
    position: absolute;
    left: -1.5rem;
    top: 50%;
    transform: translateY(-50%);
    width: 12px;
    height: 12px;
    background: var(--accent-primary);
    border-radius: 50%;
    border: 3px solid var(--bg-primary);
}

.year-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
}

.year-count {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.month-group {
    margin: 1rem 0;
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    padding: 1rem;
    border: 1px solid var(--border-color);
}

.month-title {
    margin: 0 0 1rem;
    font-size: 1.1rem;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.month-count {
    color: var(--text-muted);
    font-size: 0.8rem;
    font-weight: normal;
}

.month-posts {
    list-style: none;
    margin: 0;
    padding: 0;
}

.archive-post {
    display: flex;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border-color);
}

.archive-post:last-child {
    border-bottom: none;
}

.post-date {
    font-size: 0.8rem;
    color: var(--text-muted);
    width: 60px;
    flex-shrink: 0;
    font-family: 'Consolas', monospace;
}

.post-title {
    color: var(--text-secondary);
    text-decoration: none;
    transition: color var(--transition-fast) ease;
    font-size: 0.9rem;
}

.archive-post .post-title::after {
    display: none;
}

.post-title:hover {
    color: var(--accent-primary);
}

/* 响应式设计 */
@media (max-width: 991px) {
    .page-header-content {
        padding: 1.5rem;
    }
    
    .page-content-wrapper {
        padding: 1.5rem;
    }
    
    .page-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .page-info {
        gap: 1rem;
    }
    
    .links-grid {
        grid-template-columns: 1fr;
    }
    
    .timeline-year {
        padding-left: 1rem;
    }
}

@media (max-width: 767px) {
    .page-featured-image {
        height: 200px;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .page-meta {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .page-info {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .page-actions {
        width: 100%;
        justify-content: center;
    }
    
    .link-item {
        flex-direction: column;
        text-align: center;
    }
    
    .link-avatar {
        align-self: center;
    }
    
    .archive-post {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .post-date {
        width: auto;
        font-size: 0.75rem;
    }
}

@media (max-width: 480px) {
    .page-icon i {
        font-size: 2rem;
    }
    
    .year-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .month-title {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 如果页面内容包含标题，生成目录
    generatePageTOC();
    
    // 页面分享功能
    window.sharePageContent = function() {
        if (navigator.share) {
            navigator.share({
                title: document.title,
                url: window.location.href
            });
        } else {
            // 回退到复制链接
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('页面链接已复制到剪贴板');
            });
        }
    };
    
    // 友情链接卡片动画
    animateLinkCards();
    
    // 归档时间线动画
    animateArchiveTimeline();
});

function generatePageTOC() {
    const content = document.querySelector('.page-content');
    const tocContainer = document.getElementById('pageToc');
    const tocContent = document.getElementById('tocContent');
    
    if (!content || !tocContainer || !tocContent) return;
    
    const headings = content.querySelectorAll('h1, h2, h3, h4, h5, h6');
    
    if (headings.length === 0) return;
    
    tocContainer.style.display = 'block';
    
    let tocHTML = '<ul>';
    let currentLevel = 0;
    
    headings.forEach((heading, index) => {
        const level = parseInt(heading.tagName.charAt(1));
        const text = heading.textContent;
        const id = `page-heading-${index}`;
        
        heading.id = id;
        
        if (level > currentLevel) {
            tocHTML += '<ul>'.repeat(level - currentLevel);
        } else if (level < currentLevel) {
            tocHTML += '</ul>'.repeat(currentLevel - level);
        }
        
        tocHTML += `<li><a href="#${id}" class="toc-link">${text}</a></li>`;
        currentLevel = level;
    });
    
    tocHTML += '</ul>'.repeat(currentLevel) + '</ul>';
    tocContent.innerHTML = tocHTML;
    
    // 目录点击事件
    tocContent.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

function animateLinkCards() {
    const linkItems = document.querySelectorAll('.link-item');
    
    if (window.IntersectionObserver) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                }
            });
        });
        
        linkItems.forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(item);
        });
    }
}

function animateArchiveTimeline() {
    const timelineItems = document.querySelectorAll('.timeline-year');
    
    if (window.IntersectionObserver) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        });
        
        timelineItems.forEach(item => {
            observer.observe(item);
        });
    }
}
</script>

<?php $this->need('footer.php'); ?>
