<?php
/**
 * 
 * @package Nebula
 * @author BushSEC
 * @version 1.0.0
 * @link https://bushsec.cn
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="main-layout">
    <main class="main-content" id="main" role="main">
        <?php if ($this->have()): ?>
            <div class="posts-container">
                <?php while ($this->next()): ?>
                    <article class="post post-card" itemscope itemtype="http://schema.org/BlogPosting">
                        <!-- 文章头部 -->
                        <div class="post-header">
                            <?php $thumbnail = getPostThumbnail($this); ?>
                            <?php if ($thumbnail): ?>
                                <div class="post-featured-image">
                                    <img src="<?php echo $thumbnail; ?>" 
                                         alt="<?php $this->title(); ?>" 
                                         loading="lazy"
                                         itemprop="image">
                                    <div class="image-overlay"></div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-header-content">
                                <div class="post-categories">
                                    <?php $this->category(',', false, ''); ?>
                                </div>
                                
                                <h2 class="post-title" itemprop="name headline">
                                    <a itemprop="url" href="<?php $this->permalink() ?>">
                                        <?php $this->title() ?>
                                    </a>
                                </h2>
                                
                                <div class="post-excerpt">
                                    <?php 
                                    $excerpt = getExcerpt($this->content, 150);
                                    echo $excerpt;
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 文章元数据 -->
                        <div class="post-meta-wrapper">
                            <div class="post-meta">
                                <div class="meta-item author-meta" itemprop="author" itemscope itemtype="http://schema.org/Person">
                                    <img src="<?php echo Typecho_Common::gravatarUrl($this->author->mail, 32, 'X', 'mm', $this->request->isSecure()); ?>" 
                                         alt="<?php $this->author(); ?>" class="author-avatar">
                                    <div class="author-info">
                                        <a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author" class="author-name">
                                            <?php $this->author(); ?>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="meta-item time-meta">
                                    <i class="fas fa-clock"></i>
                                    <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished">
                                        <?php echo formatTime($this->created); ?>
                                    </time>
                                </div>
                                
                                <div class="meta-item reading-time">
                                    <i class="fas fa-book-open"></i>
                                    <span><?php echo getReadingTime($this->content); ?> 分钟阅读</span>
                                </div>
                                
                                <div class="meta-item comments-meta" itemprop="interactionCount">
                                    <i class="fas fa-comments"></i>
                                    <a href="<?php $this->permalink() ?>#comments" itemprop="discussionUrl">
                                        <?php $this->commentsNum('0', '1', '%d'); ?>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="post-actions">
                                <a href="<?php $this->permalink() ?>" class="read-more-btn">
                                    <span>阅读全文</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        
                        <!-- 文章标签 -->
                        <?php if ($this->tags): ?>
                            <div class="post-tags-preview">
                                <?php $this->tags(' ', true, ''); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- 文章统计 -->
                        <div class="post-stats">
                            <div class="stat-item">
                                <i class="fas fa-comments"></i>
                                <span><?php $this->commentsNum('0', '1', '%d'); ?></span>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <!-- 分页导航 -->
            <div class="pagination-wrapper">
                <?php $this->pageNav('← 上一页', '下一页 →', 3, '...', [
                    'wrapTag' => 'nav',
                    'wrapClass' => 'pagination-nav',
                    'itemTag' => '',
                    'textTag' => 'a',
                    'currentClass' => 'current',
                    'prevClass' => 'prev',
                    'nextClass' => 'next'
                ]); ?>
            </div>
            
        <?php else: ?>
            <div class="no-posts">
                <div class="no-posts-content">
                    <i class="fas fa-inbox"></i>
                    <h2>暂无文章</h2>
                    <p>这里还没有发布任何文章</p>
                </div>
            </div>
        <?php endif; ?>
    </main>
    <?php $this->need('sidebar.php'); ?>
</div>
<?php $this->need('footer.php'); ?>

<style>
/* 主内容区域 */
.main-content {
    padding: 2rem 0;
}

.posts-container {
    display: grid;
    gap: 2rem;
}

/* 文章卡片样式 */
.post-card {
    background: var(--bg-primary);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all var(--transition-medium) ease;
    position: relative;
    box-shadow: 0 4px 20px var(--shadow-light);
}

.post-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
    opacity: 0;
    transition: opacity var(--transition-fast) ease;
}

.post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px var(--shadow-medium);
}

.post-card:hover::before {
    opacity: 1;
}

/* 文章头部 */
.post-header {
    position: relative;
}

.post-featured-image {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: var(--bg-secondary);
}

.post-featured-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow) ease;
}

.post-card:hover .post-featured-image img {
    transform: scale(1.05);
}

.image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.3) 100%);
    opacity: 0;
    transition: opacity var(--transition-fast) ease;
}

.post-card:hover .image-overlay {
    opacity: 1;
}

.post-header-content {
    padding: 1.5rem;
}

.post-categories {
    margin-bottom: 1rem;
}

.post-categories a {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    background: var(--accent-primary);
    color: white;
    border-radius: var(--radius-sm);
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    margin-right: 0.5rem;
    transition: all var(--transition-fast) ease;
}

.post-categories a::after {
    display: none;
}

.post-categories a:hover {
    background: var(--accent-secondary);
    transform: translateY(-1px);
}

.post-title {
    margin: 0 0 1rem;
    font-size: 1.5rem;
    line-height: 1.3;
    font-weight: 700;
}

.post-title a {
    color: var(--text-primary);
    text-decoration: none;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    transition: all var(--transition-fast) ease;
}

.post-title a::after {
    display: none;
}

.post-title a:hover {
    background: var(--gradient-secondary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.post-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

/* 文章元数据 */
.post-meta-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border-color);
    background: var(--bg-secondary);
}

.post-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-muted);
    font-size: 0.85rem;
}

.meta-item i {
    color: var(--accent-primary);
    font-size: 0.8rem;
}

.author-meta {
    gap: 0.75rem;
}

.author-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid var(--accent-primary);
    transition: all var(--transition-fast) ease;
}

.author-meta:hover .author-avatar {
    transform: scale(1.1);
    border-color: var(--accent-secondary);
}

.author-name {
    color: var(--text-primary);
    font-weight: 600;
    text-decoration: none;
    transition: color var(--transition-fast) ease;
}

.author-name::after {
    display: none;
}

.author-name:hover {
    color: var(--accent-primary);
}

.meta-item a {
    color: inherit;
    text-decoration: none;
    transition: color var(--transition-fast) ease;
}

.meta-item a::after {
    display: none;
}

.meta-item a:hover {
    color: var(--accent-primary);
}

/* 阅读更多按钮 */
.read-more-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    background: var(--accent-primary);
    color: white;
    border-radius: var(--radius-md);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all var(--transition-fast) ease;
    position: relative;
    overflow: hidden;
}

.read-more-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--accent-secondary);
    transition: left var(--transition-medium) ease;
    z-index: 0;
}

.read-more-btn span,
.read-more-btn i {
    position: relative;
    z-index: 1;
}

.read-more-btn::after {
    display: none;
}

.read-more-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px var(--shadow-medium);
}

.read-more-btn:hover::before {
    left: 0;
}

.read-more-btn:hover i {
    transform: translateX(3px);
}

/* 文章标签预览 */
.post-tags-preview {
    padding: 0 1.5rem 1rem;
}

.post-tags-preview a {
    display: inline-block;
    padding: 0.3rem 0.6rem;
    background: var(--bg-tertiary);
    color: var(--text-muted);
    border-radius: var(--radius-sm);
    font-size: 0.75rem;
    text-decoration: none;
    margin: 0.25rem 0.5rem 0.25rem 0;
    transition: all var(--transition-fast) ease;
    border: 1px solid var(--border-color);
}

.post-tags-preview a::after {
    display: none;
}

.post-tags-preview a:hover {
    background: var(--accent-primary);
    color: white;
    border-color: var(--accent-primary);
    transform: translateY(-1px);
}

/* 文章统计 */
.post-stats {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    gap: 0.75rem;
    opacity: 0;
    transition: all var(--transition-fast) ease;
}

.post-card:hover .post-stats {
    opacity: 1;
}

.post-stats .stat-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.4rem 0.6rem;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: var(--radius-md);
    font-size: 0.75rem;
    color: var(--text-secondary);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

[data-theme="dark"] .post-stats .stat-item {
    background: rgba(0, 0, 0, 0.7);
    border-color: rgba(255, 255, 255, 0.1);
    color: var(--text-primary);
}

.post-stats .stat-item i {
    color: var(--accent-primary);
    font-size: 0.7rem;
}

/* 分页导航 */
.pagination-wrapper {
    margin-top: 3rem;
    display: flex;
    justify-content: center;
}

.pagination-nav {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--bg-primary);
    border-radius: var(--radius-xl);
    padding: 1rem;
    box-shadow: 0 4px 20px var(--shadow-light);
    border: 1px solid var(--border-color);
}

.pagination-nav a,
.pagination-nav span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 1rem;
    border-radius: var(--radius-md);
    color: var(--text-secondary);
    text-decoration: none;
    transition: all var(--transition-fast) ease;
    font-weight: 500;
}

.pagination-nav a::after {
    display: none;
}

.pagination-nav a:hover {
    background: var(--accent-primary);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px var(--shadow-medium);
}

.pagination-nav .current {
    background: var(--accent-primary);
    color: white;
}

.pagination-nav .prev,
.pagination-nav .next {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
}

.pagination-nav .prev:hover,
.pagination-nav .next:hover {
    background: var(--accent-primary);
    border-color: var(--accent-primary);
}

/* 无文章状态 */
.no-posts {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
}

.no-posts-content {
    text-align: center;
    background: var(--bg-secondary);
    padding: 3rem;
    border-radius: var(--radius-xl);
    border: 1px solid var(--border-color);
    max-width: 400px;
}

.no-posts-content i {
    font-size: 4rem;
    color: var(--text-muted);
    margin-bottom: 1.5rem;
}

.no-posts-content h2 {
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.no-posts-content p {
    color: var(--text-secondary);
    margin: 0;
}

/* 响应式设计 */
@media (max-width: 991px) {
    .main-content {
        padding: 1rem 0;
    }
    
    .posts-container {
        gap: 1.5rem;
    }
    
    .post-card {
        border-radius: var(--radius-lg);
    }
    
    .post-meta-wrapper {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .post-meta {
        gap: 0.75rem;
    }
    
    .post-stats {
        position: static;
        opacity: 1;
        padding: 0 1.5rem 1rem;
        justify-content: center;
    }
}

@media (max-width: 767px) {
    .post-header-content {
        padding: 1rem;
    }
    
    .post-meta-wrapper {
        padding: 1rem;
    }
    
    .post-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
        width: 100%;
    }
    
    .meta-item {
        font-size: 0.8rem;
    }
    
    .post-title {
        font-size: 1.3rem;
    }
    
    .read-more-btn {
        width: 100%;
        justify-content: center;
    }
    
    .pagination-nav {
        flex-wrap: wrap;
        gap: 0.25rem;
    }
    
    .pagination-nav a,
    .pagination-nav span {
        min-width: 36px;
        height: 36px;
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .post-featured-image {
        height: 150px;
    }
    
    .no-posts-content {
        padding: 2rem;
    }
    
    .no-posts-content i {
        font-size: 3rem;
    }
}

/* 文章卡片动画增强 */
@keyframes cardEnter {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.post-card {
    animation: cardEnter 0.6s ease forwards;
}

.post-card:nth-child(even) {
    animation-delay: 0.1s;
}

.post-card:nth-child(3n) {
    animation-delay: 0.2s;
}

/* 加载状态 */
.posts-loading {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
}

.posts-loading .spinner {
    width: 40px;
    height: 40px;
    border: 4px solid var(--border-color);
    border-top: 4px solid var(--accent-primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 文章卡片动画
    const postCards = document.querySelectorAll('.post-card');
    
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
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        postCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    }
    
    // 阅读更多按钮增强
    const readMoreBtns = document.querySelectorAll('.read-more-btn');
    readMoreBtns.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.querySelector('i').style.transform = 'translateX(3px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.querySelector('i').style.transform = 'translateX(0)';
        });
    });
});
</script>
