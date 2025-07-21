<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<aside id="secondary" role="complementary">
    
    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
        <section class="widget widget-recent-comments" data-widget="recent-comments">
            <div class="widget-header">
                <h3 class="widget-title">
                    <i class="fas fa-comments"></i>
                    <span><?php _e('最近回复'); ?></span>
                    <div class="widget-icon-bg"></div>
                </h3>
            </div>
            <div class="widget-content">
                <ul class="widget-list recent-comments-list">
                    <?php Typecho_Widget::widget('Widget_Comments_Recent')->to($comments); ?>
                    <?php if ($comments->have()): ?>
                        <?php while ($comments->next()): ?>
                            <li class="recent-comment-item">
                                <div class="comment-avatar">
                                    <img src="<?php echo Typecho_Common::gravatarUrl($comments->mail, 40, 'X', 'mm', $this->request->isSecure()); ?>" 
                                         alt="<?php $comments->author(false); ?>" loading="lazy">
                                </div>
                                <div class="comment-info">
                                    <div class="comment-author">
                                        <strong><?php $comments->author(false); ?></strong>
                                        <span class="comment-time">
                                            <i class="fas fa-clock"></i>
                                            <?php echo formatTime($comments->created); ?>
                                        </span>
                                    </div>
                                    <div class="comment-content">
                                        <a href="<?php $comments->permalink(); ?>" title="查看评论">
                                            <?php $comments->excerpt(50, '...'); ?>
                                        </a>
                                    </div>
                                    <div class="comment-post">
                                        回复：<a href="<?php $comments->permalink(); ?>"><?php $comments->title(); ?></a>
                                    </div>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
        <section class="widget widget-categories" data-widget="categories">
            <div class="widget-header">
                <h3 class="widget-title">
                    <i class="fas fa-folder-open"></i>
                    <span><?php _e('分类目录'); ?></span>
                    <div class="widget-icon-bg"></div>
                </h3>
            </div>
            <div class="widget-content">
                <ul class="widget-list categories-list">
                    <?php Typecho_Widget::widget('Widget_Metas_Category_List')->to($categories); ?>
                    <?php if ($categories->have()): ?>
                        <?php while ($categories->next()): ?>
                            <li class="category-item">
                                <a href="<?php $categories->permalink(); ?>" class="category-link">
                                    <div class="category-icon">
                                        <i class="fas fa-folder"></i>
                                    </div>
                                    <div class="category-info">
                                        <span class="category-name"><?php $categories->name(); ?></span>
                                        <span class="category-count">(<?php $categories->count(); ?>)</span>
                                    </div>
                                </a>
                                <?php if ($categories->description()): ?>
                                    <div class="category-description">
                                        <?php $categories->description(); ?>
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowSocialLinks', $this->options->sidebarBlock) && $this->options->socialLinks): ?>
        <section class="widget widget-social" data-widget="social">
            <div class="widget-header">
                <h3 class="widget-title">
                    <i class="fas fa-share-alt"></i>
                    <span><?php _e('社交链接'); ?></span>
                    <div class="widget-icon-bg"></div>
                </h3>
            </div>
            <div class="widget-content">
                <div class="social-links">
                    <?php 
                    $socialLinks = explode("\n", $this->options->socialLinks);
                    foreach ($socialLinks as $link) {
                        if (trim($link)) {
                            $parts = explode('|', trim($link));
                            if (count($parts) >= 2) {
                                $name = trim($parts[0]);
                                $url = trim($parts[1]);
                                $icon = isset($parts[2]) ? trim($parts[2]) : 'fas fa-link';
                                echo '<a href="' . $url . '" target="_blank" rel="noopener" class="social-link" title="' . $name . '">';
                                echo '<i class="' . $icon . '"></i>';
                                echo '<span>' . $name . '</span>';
                                echo '</a>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowOther', $this->options->sidebarBlock)): ?>
        <section class="widget widget-meta" data-widget="meta">
            <div class="widget-header">
                <h3 class="widget-title">
                    <i class="fas fa-cogs"></i>
                    <span><?php _e('功能菜单'); ?></span>
                    <div class="widget-icon-bg"></div>
                </h3>
            </div>
            <div class="widget-content">
                <ul class="widget-list meta-list">
                    <li class="meta-item">
                        <a href="<?php $this->options->feedUrl(); ?>" class="meta-link feed-link" target="_blank">
                            <div class="meta-icon">
                                <i class="fas fa-rss"></i>
                            </div>
                            <div class="meta-info">
                                <span class="meta-text"><?php _e('RSS 订阅'); ?></span>
                                <span class="meta-desc">文章订阅</span>
                            </div>
                        </a>
                    </li>
                    <li class="meta-item">
                        <a href="<?php $this->options->commentsFeedUrl(); ?>" class="meta-link comments-feed-link" target="_blank">
                            <div class="meta-icon">
                                <i class="fas fa-rss-square"></i>
                            </div>
                            <div class="meta-info">
                                <span class="meta-text"><?php _e('评论订阅'); ?></span>
                                <span class="meta-desc">评论 RSS</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </section>
    <?php endif; ?>

    <!-- 标签云小组件 -->
    <section class="widget widget-tagcloud" data-widget="tagcloud">
        <div class="widget-header">
            <h3 class="widget-title">
                <i class="fas fa-tags"></i>
                <span><?php _e('标签云'); ?></span>
                <div class="widget-icon-bg"></div>
            </h3>
        </div>
        <div class="widget-content">
            <div class="tagcloud">
                <?php Typecho_Widget::widget('Widget_Metas_Tag_Cloud', 'sort=count&ignoreZeroCount=1&desc=1&limit=30')->to($tags); ?>
                <?php if ($tags->have()): ?>
                    <?php while ($tags->next()): ?>
                        <a href="<?php $tags->permalink(); ?>" 
                           class="tag-item"
                           title="<?php echo $tags->count(); ?> 篇文章">
                            <i class="fas fa-tag"></i>
                            <?php $tags->name(); ?>
                        </a>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- 网站统计小组件 -->
    <section class="widget widget-stats" data-widget="stats">
        <div class="widget-header">
            <h3 class="widget-title">
                <i class="fas fa-chart-bar"></i>
                <span><?php _e('网站统计'); ?></span>
                <div class="widget-icon-bg"></div>
            </h3>
        </div>
        <div class="widget-content">
            <div class="stats-grid">
                <?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-number"><?php $stat->publishedPostsNum(); ?></span>
                        <span class="stat-label">文章</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-number"><?php $stat->publishedCommentsNum(); ?></span>
                        <span class="stat-label">评论</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-folder"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-number"><?php echo Typecho_Widget::widget('Widget_Metas_Category_List')->total; ?></span>
                        <span class="stat-label">分类</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-number"><?php echo Typecho_Widget::widget('Widget_Metas_Tag_Cloud')->total; ?></span>
                        <span class="stat-label">标签</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

</aside>

<style>
/* 侧边栏样式 */
#secondary {
    padding-top: 2rem;
    position: sticky;
    top: 2rem;
    height: fit-content;
}

/* Widget 基础样式 */
.widget {
    background: var(--bg-primary);
    border-radius: var(--radius-xl);
    margin-bottom: 2rem;
    overflow: hidden;
    transition: all var(--transition-medium) ease;
    position: relative;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 20px var(--shadow-light);
}

.widget::before {
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

.widget:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px var(--shadow-medium);
}

.widget:hover::before {
    opacity: 1;
}

/* Widget头部 */
.widget-header {
    position: relative;
    overflow: hidden;
}

.widget-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0;
    padding: 1.25rem 1.5rem;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-size: 1.1rem;
    font-weight: 600;
    position: relative;
    border-bottom: 1px solid var(--border-color);
}

.widget-title i {
    color: var(--accent-primary);
    font-size: 1rem;
    z-index: 2;
    position: relative;
}

.widget-title span {
    z-index: 2;
    position: relative;
}

.widget-icon-bg {
    position: absolute;
    top: -20px;
    right: -20px;
    width: 80px;
    height: 80px;
    background: var(--gradient-primary);
    opacity: 0.1;
    border-radius: 50%;
    transform: rotate(15deg);
}

.widget-content {
    padding: 1.5rem;
}

/* Widget列表通用样式 */
.widget-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.widget-list li {
    margin: 0;
    line-height: 1.6;
}

/* 最新文章样式 */
.recent-post-item {
    display: flex;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
    transition: all var(--transition-fast) ease;
}

.recent-post-item:last-child {
    border-bottom: none;
}

.recent-post-item:hover {
    background: var(--bg-secondary);
    margin: 0 -1.5rem;
    padding: 1rem 1.5rem;
    border-radius: var(--radius-md);
}

.post-thumbnail {
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    border-radius: var(--radius-md);
    overflow: hidden;
    background: var(--bg-tertiary);
    position: relative;
}

.post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-fast) ease;
}

.recent-post-item:hover .post-thumbnail img {
    transform: scale(1.1);
}

.post-thumb-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    background: var(--gradient-primary);
}

.post-thumb-placeholder i {
    color: white;
    opacity: 0.8;
}

.post-info {
    flex: 1;
    min-width: 0;
}

.post-info .post-title {
    margin: 0 0 0.5rem;
    font-size: 0.9rem;
    font-weight: 600;
    line-height: 1.3;
}

.post-info .post-title a {
    color: var(--text-primary);
    text-decoration: none;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color var(--transition-fast) ease;
}

.post-info .post-title a::after {
    display: none;
}

.post-info .post-title a:hover {
    color: var(--accent-primary);
}

.post-info .post-meta {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.post-info .post-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.post-info .post-meta i {
    font-size: 0.7rem;
}

.post-excerpt {
    font-size: 0.8rem;
    color: var(--text-secondary);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}

/* 最近评论样式 */
.recent-comment-item {
    display: flex;
    gap: 0.75rem;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
    transition: all var(--transition-fast) ease;
}

.recent-comment-item:last-child {
    border-bottom: none;
}

.recent-comment-item:hover {
    background: var(--bg-secondary);
    margin: 0 -1.5rem;
    padding: 1rem 1.5rem;
    border-radius: var(--radius-md);
}

.comment-avatar {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
}

.comment-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 2px solid var(--accent-primary);
    transition: all var(--transition-fast) ease;
}

.recent-comment-item:hover .comment-avatar img {
    border-color: var(--accent-secondary);
    transform: scale(1.1);
}

.comment-info {
    flex: 1;
    min-width: 0;
}

.comment-author {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
}

.comment-author strong {
    color: var(--accent-primary);
    font-weight: 600;
}

.comment-time {
    color: var(--text-muted);
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.comment-content {
    margin-bottom: 0.5rem;
    font-size: 0.8rem;
    line-height: 1.4;
}

.comment-content a {
    color: var(--text-secondary);
    text-decoration: none;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color var(--transition-fast) ease;
}

.comment-content a::after {
    display: none;
}

.comment-content a:hover {
    color: var(--accent-primary);
}

.comment-post {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.comment-post a {
    color: var(--accent-primary);
    text-decoration: none;
}

.comment-post a::after {
    display: none;
}

/* 分类目录样式 */
.category-item {
    margin-bottom: 0.5rem;
}

.category-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: var(--radius-md);
    color: var(--text-secondary);
    text-decoration: none;
    transition: all var(--transition-fast) ease;
    background: transparent;
}

.category-link::after {
    display: none;
}

.category-link:hover {
    background: var(--bg-secondary);
    color: var(--accent-primary);
    transform: translateX(5px);
}

.category-icon {
    width: 32px;
    height: 32px;
    background: var(--accent-primary);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: all var(--transition-fast) ease;
}

.category-link:hover .category-icon {
    background: var(--accent-secondary);
    transform: scale(1.1);
}

.category-info {
    flex: 1;
}

.category-name {
    font-weight: 500;
    font-size: 0.9rem;
}

.category-count {
    color: var(--text-muted);
    font-size: 0.8rem;
    margin-left: 0.5rem;
}

.category-description {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-top: 0.25rem;
    padding-left: 2.5rem;
    line-height: 1.4;
}

/* 社交链接样式 */
.social-links {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    color: var(--text-secondary);
    text-decoration: none;
    transition: all var(--transition-fast) ease;
    font-size: 0.85rem;
    font-weight: 500;
    position: relative;
    overflow: hidden;
}

.social-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--gradient-primary);
    transition: left var(--transition-medium) ease;
    z-index: 0;
}

.social-link i,
.social-link span {
    position: relative;
    z-index: 1;
}

.social-link::after {
    display: none;
}

.social-link:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px var(--shadow-medium);
}

.social-link:hover::before {
    left: 0;
}

/* 功能菜单样式 */
.meta-item {
    margin-bottom: 0.5rem;
}

.meta-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius-md);
    color: var(--text-secondary);
    text-decoration: none;
    transition: all var(--transition-fast) ease;
    background: transparent;
    border: 1px solid transparent;
}

.meta-link::after {
    display: none;
}

.meta-link:hover {
    background: var(--bg-secondary);
    border-color: var(--border-color);
    color: var(--accent-primary);
    transform: translateX(5px);
}

.meta-icon {
    width: 40px;
    height: 40px;
    background: var(--accent-primary);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: all var(--transition-fast) ease;
}

.meta-link:hover .meta-icon {
    background: var(--accent-secondary);
    transform: scale(1.1);
}

.meta-icon.user-admin {
    background: var(--gradient-primary);
}

.meta-info {
    flex: 1;
}

.meta-text {
    display: block;
    font-weight: 500;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.meta-desc {
    display: block;
    font-size: 0.8rem;
    color: var(--text-muted);
}

/* 标签云样式 */
.tagcloud {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    align-items: center;
}

.tag-item {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.4rem 0.75rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-lg);
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all var(--transition-fast) ease;
    border: 1px solid var(--border-color);
}

.tag-item::after {
    display: none;
}

.tag-item:hover {
    background: var(--accent-primary);
    border-color: var(--accent-primary);
    color: white;
    transform: translateY(-1px) scale(1.05);
    box-shadow: 0 4px 10px var(--shadow-medium);
}

.tag-item i {
    font-size: 0.7rem;
}

/* 网站统计样式 */
.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    transition: all var(--transition-fast) ease;
    border: 1px solid var(--border-color);
}

.stat-item:hover {
    background: var(--bg-tertiary);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px var(--shadow-light);
}

.stat-icon {
    width: 36px;
    height: 36px;
    background: var(--accent-primary);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
}

.stat-number {
    display: block;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
}

.stat-label {
    display: block;
    font-size: 0.8rem;
    color: var(--text-muted);
}

/* 响应式 */
@media (max-width: 991px) {
    #secondary {
        padding-top: 1rem;
        position: static;
    }
    
    .widget {
        margin-bottom: 1.5rem;
    }
    
    .widget-content {
        padding: 1rem;
    }
    
    .social-links {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 767px) {
    .widget-title {
        padding: 1rem;
        font-size: 1rem;
    }
    
    .recent-post-item {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .post-thumbnail {
        width: 100%;
        height: 120px;
    }
    
    .recent-comment-item {
        gap: 0.5rem;
    }
    
    .comment-author {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Widget 动画效果
    const widgets = document.querySelectorAll('.widget');
    
    if (window.IntersectionObserver) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        widgets.forEach(widget => {
            widget.style.opacity = '0';
            widget.style.transform = 'translateY(20px)';
            widget.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(widget);
        });
    }
    
    // 标签云随机颜色
    const tagItems = document.querySelectorAll('.tag-item');
    const colors = [
        'var(--accent-primary)',
        'var(--accent-secondary)', 
        '#28a745',
        '#17a2b8',
        '#ffc107',
        '#dc3545',
        '#e83e8c',
        '#6f42c1'
    ];
    
    tagItems.forEach(tag => {
        const randomColor = colors[Math.floor(Math.random() * colors.length)];
        tag.addEventListener('mouseenter', function() {
            this.style.background = randomColor;
            this.style.borderColor = randomColor;
        });
        
        tag.addEventListener('mouseleave', function() {
            this.style.background = '';
            this.style.borderColor = '';
        });
    });
});
</script>
