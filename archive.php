<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="main-layout">
    <main class="main-content" id="main" role="main">
        <!-- 归档页面头部 -->
        <header class="archive-header">
            <div class="archive-hero">
                <?php if (!$this->is('category')): ?>
                <div class="hero-background">
                    <div class="hero-pattern"></div>
                </div>
                <?php endif; ?>
                <div class="hero-content">
                    <div class="archive-icon">
                        <?php if ($this->is('category')): ?>
                            <i class="fas fa-folder-open"></i>
                        <?php elseif ($this->is('tag')): ?>
                            <i class="fas fa-tags"></i>
                        <?php elseif ($this->is('search')): ?>
                            <i class="fas fa-search"></i>
                        <?php elseif ($this->is('author')): ?>
                            <i class="fas fa-user-circle"></i>
                        <?php else: ?>
                            <i class="fas fa-archive"></i>
                        <?php endif; ?>
                    </div>
                    
                    <h1 class="archive-title">
                        <?php $this->archiveTitle([
                            'category' => _t('分类：%s'),
                            'search'   => _t('搜索：%s'),
                            'tag'      => _t('标签：%s'),
                            'author'   => _t('作者：%s'),
                            'date'     => _t('归档：%s')
                        ], '', ''); ?>
                    </h1>
                    
                    <!-- 归档描述 -->
                    <?php if ($this->is('category') && $this->getArchiveSlug()): ?>
                        <?php Typecho_Widget::widget('Widget_Metas_Category_List')->to($category); ?>
                        <?php while ($category->next()): ?>
                            <?php if ($category->slug == $this->getArchiveSlug() && $category->description): ?>
                                <div class="archive-description">
                                    <?php echo $category->description; ?>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    
                    <!-- 归档统计 -->
                    <div class="archive-stats">
                        <div class="stat-item">
                            <span class="stat-number" id="postCount">-</span>
                            <span class="stat-label">篇文章</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" id="commentCount">-</span>
                            <span class="stat-label">条评论</span>
                        </div>
                        <div class="stat-item">
                            <?php 
                            $viewCount = 0;
                            if ($this->is('category')) {
                                $categoryId = $this->getArchiveSlug();
                                $category = null;
                                Typecho_Widget::widget('Widget_Metas_Category_List')->to($categories);
                                while ($categories->next()) {
                                    if ($categories->slug == $categoryId) {
                                        $viewCount = getCategoryViews($categories->mid);
                                        break;
                                    }
                                }
                            } else {
                                // 对于非分类页面，可以计算所有文章的浏览量
                                $db = Typecho_Db::get();
                                $result = $db->fetchRow($db->select(array('SUM(views)' => 'sumviews'))
                                    ->from('table.contents')
                                    ->where('table.contents.status = ?', 'publish'));
                                $viewCount = intval($result['sumviews']);
                            }
                            ?>
                            <span class="stat-number" id="viewCount" data-views="<?php echo $viewCount; ?>">-</span>
                            <span class="stat-label">次浏览</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- 过滤器和排序 -->
        <div class="archive-filters">
            <div class="filter-group">
                <label class="filter-label">
                    <i class="fas fa-sort"></i>
                    排序方式：
                </label>
                <select id="sortSelect" class="filter-select">
                    <option value="created_desc">发布时间（新到旧）</option>
                    <option value="created_asc">发布时间（旧到新）</option>
                    <option value="modified_desc">更新时间</option>
                    <option value="views_desc">浏览量</option>
                    <option value="comments_desc">评论数</option>
                    <option value="title_asc">标题</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">
                    <i class="fas fa-eye"></i>
                    显示方式：
                </label>
                <div class="view-toggle">
                    <button class="view-btn active" data-view="list" title="列表视图">
                        <i class="fas fa-list"></i>
                    </button>
                    <button class="view-btn" data-view="timeline" title="时间线视图">
                        <i class="fas fa-stream"></i>
                    </button>
                </div>
            </div>
            
            <div class="filter-group">
                <div class="search-box">
                    <input type="text" id="filterSearch" placeholder="在当前结果中搜索..." class="filter-input">
                    <button class="search-btn" id="filterBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- 文章列表 -->
        <div class="archive-content">
            <?php if ($this->have()): ?>
                <div class="posts-container view-list" id="postsContainer">
                    <?php $postCount = 0; ?>
                    <?php $commentTotal = 0; ?>
                    <?php while ($this->next()): ?>
                        <?php $postCount++; ?>
                        <?php $commentTotal += $this->commentsNum; ?>
                        
                        <article class="archive-post-item" 
                                 data-date="<?php $this->date('Y-m-d'); ?>"
                                 data-year="<?php $this->date('Y'); ?>"
                                 data-month="<?php $this->date('m'); ?>"
                                 itemscope itemtype="http://schema.org/BlogPosting">
                            
                            <!-- 网格视图内容 -->
                            <div class="post-grid-content" style="display: none;">
                                <!-- 文章缩略图 -->
                                <div class="post-thumbnail">
                                    <?php $thumbnail = getPostThumbnail($this); ?>
                                    <?php if ($thumbnail): ?>
                                        <img src="<?php echo $thumbnail; ?>" 
                                             alt="<?php $this->title(); ?>" 
                                             loading="lazy"
                                             itemprop="image">
                                    <?php else: ?>
                                        <div class="thumbnail-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- 文章标识 -->
                                    <div class="post-badges">
                                        <?php if ($this->isSticky): ?>
                                            <span class="badge sticky">
                                                <i class="fas fa-thumbtack"></i>
                                                置顶
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if ($this->password): ?>
                                            <span class="badge protected">
                                                <i class="fas fa-lock"></i>
                                                加密
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- 快速操作 -->
                                    <div class="post-quick-actions">
                                        <a href="<?php $this->permalink(); ?>" class="quick-action" title="阅读">
                                            <i class="fas fa-book-open"></i>
                                        </a>
                                        <button class="quick-action like-btn" title="点赞">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                        <button class="quick-action share-btn" title="分享">
                                            <i class="fas fa-share-alt"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- 文章信息 -->
                                <div class="post-info">
                                    <!-- 分类标签 -->
                                    <div class="post-category">
                                        <?php $this->category(','); ?>
                                    </div>
                                    
                                    <!-- 文章标题 -->
                                    <h2 class="post-title" itemprop="name headline">
                                        <a href="<?php $this->permalink(); ?>" itemprop="url">
                                            <?php $this->title(); ?>
                                        </a>
                                    </h2>
                                    
                                    <!-- 文章摘要 -->
                                    <div class="post-excerpt">
                                        <?php echo getExcerpt($this->content, 120); ?>
                                    </div>
                                    
                                    <!-- 文章元数据 -->
                                    <div class="post-meta">
                                        <div class="meta-left">
                                            <span class="meta-item meta-author">
                                                <img src="<?php echo Typecho_Common::gravatarUrl($this->author->mail, 24, 'X', 'mm', $this->request->isSecure()); ?>" 
                                                     alt="<?php $this->author(); ?>" class="author-avatar">
                                                <a href="<?php $this->author->permalink(); ?>">
                                                    <?php $this->author(); ?>
                                                </a>
                                            </span>
                                            
                                            <span class="meta-item meta-date">
                                                <i class="fas fa-calendar-alt"></i>
                                                <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished">
                                                    <?php echo formatTime($this->created); ?>
                                                </time>
                                            </span>
                                        </div>
                                        
                                        <div class="meta-right">
                                            <span class="meta-item meta-reading-time">
                                                <i class="fas fa-clock"></i>
                                                <?php echo getReadingTime($this->content); ?> 分钟
                                            </span>
                                            
                                            <span class="meta-item meta-comments">
                                                <i class="fas fa-comments"></i>
                                                <a href="<?php $this->permalink(); ?>#comments">
                                                    <?php $this->commentsNum('0', '1', '%d'); ?>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- 文章标签 -->
                                    <?php if ($this->tags): ?>
                                        <div class="post-tags">
                                            <?php $this->tags(' ', true, ''); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- 列表视图内容 -->
                            <div class="post-list-content" style="display: none;">
                                <div class="list-thumbnail">
                                    <?php if ($thumbnail): ?>
                                        <img src="<?php echo $thumbnail; ?>" alt="<?php $this->title(); ?>" loading="lazy">
                                    <?php else: ?>
                                        <div class="thumbnail-placeholder">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="list-content">
                                    <div class="list-header">
                                        <h3 class="list-title">
                                            <a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a>
                                        </h3>
                                        <div class="list-meta">
                                            <span><?php $this->category(','); ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="list-excerpt">
                                        <?php echo getExcerpt($this->content, 200); ?>
                                    </div>
                                    
                                    <div class="list-footer">
                                        <div class="list-tags">
                                            <?php $this->tags(' ', true, ''); ?>
                                        </div>
                                        <a href="<?php $this->permalink(); ?>" class="read-more">
                                            阅读全文 <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 时间线视图内容 -->
                            <div class="post-timeline-content" style="display: none;">
                                <div class="timeline-date">
                                    <span class="timeline-month"><?php $this->date('m'); ?></span>
                                    <span class="timeline-day"><?php $this->date('d'); ?></span>
                                </div>
                                
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <h4 class="timeline-title">
                                            <a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a>
                                        </h4>
                                        <div class="timeline-meta">
                                            <?php $this->category(','); ?>
                                            <span class="separator">•</span>
                                            <?php $this->commentsNum('0', '1', '%d'); ?> 条评论
                                        </div>
                                    </div>
                                    
                                    <div class="timeline-excerpt">
                                        <?php echo getExcerpt($this->content, 100); ?>
                                    </div>
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
                <!-- 空状态 -->
                <div class="empty-state">
                    <div class="empty-content">
                        <div class="empty-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="empty-title">没有找到相关内容</h3>
                        <p class="empty-description">
                            <?php if ($this->is('search')): ?>
                                抱歉，没有找到包含 "<span class="search-keyword"><?php $this->archiveTitle('', '', ''); ?></span>" 的文章
                            <?php else: ?>
                                该分类下暂时没有文章
                            <?php endif; ?>
                        </p>
                        
                        <div class="empty-actions">
                            <a href="<?php $this->options->siteUrl(); ?>" class="btn-primary">
                                <i class="fas fa-home"></i>
                                返回首页
                            </a>
                            
                            <?php if ($this->is('search')): ?>
                                <button class="btn-secondary" onclick="document.getElementById('s').focus()">
                                    <i class="fas fa-search"></i>
                                    重新搜索
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- 相关分类/标签推荐 -->
        <?php if ($this->is('category') || $this->is('tag')): ?>
            <aside class="related-section">
                <h3 class="section-title">
                    <i class="fas fa-lightbulb"></i>
                    <span><?php echo $this->is('category') ? '相关分类' : '相关标签'; ?></span>
                </h3>
                
                <div class="related-items">
                    <?php if ($this->is('category')): ?>
                        <?php Typecho_Widget::widget('Widget_Metas_Category_List')->to($categories); ?>
                        <?php while ($categories->next()): ?>
                            <?php if ($categories->slug != $this->getArchiveSlug()): ?>
                                <a href="<?php $categories->permalink(); ?>" class="related-item category-item">
                                    <div class="item-icon">
                                        <i class="fas fa-folder"></i>
                                    </div>
                                    <div class="item-info">
                                        <span class="item-name"><?php $categories->name(); ?></span>
                                        <span class="item-count"><?php $categories->count(); ?> 篇</span>
                                    </div>
                                </a>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <?php Typecho_Widget::widget('Widget_Metas_Tag_Cloud', 'limit=10')->to($tags); ?>
                        <?php while ($tags->next()): ?>
                            <a href="<?php $tags->permalink(); ?>" class="related-item tag-item">
                                <div class="item-icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <div class="item-info">
                                    <span class="item-name"><?php $tags->name(); ?></span>
                                    <span class="item-count"><?php $tags->count(); ?> 篇</span>
                                </div>
                            </a>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </aside>
        <?php endif; ?>
    </main>
    <?php $this->need('sidebar.php'); ?>
</div>
<?php $this->need('footer.php'); ?>

<style>
/* 归档页面样式 */
.main-content {
    padding: 2rem 0;
}

/* 归档头部 */
.archive-header {
    margin-bottom: 2rem;
}

.archive-hero {
    position: relative;
    background: var(--gradient-primary);
    border-radius: var(--radius-xl);
    overflow: hidden;
    color: white;
}

.hero-background {
    position: absolute;
    inset: 0;
    opacity: 0.1;
}

.hero-pattern {
    width: 100%;
    height: 100%;
    background-image: 
        radial-gradient(circle at 20% 80%, rgba(255,255,255,0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255,255,255,0.3) 0%, transparent 50%);
}

.hero-content {
    position: relative;
    padding: 3rem 2rem;
    text-align: center;
}

.archive-icon {
    margin-bottom: 1rem;
}

.archive-icon i {
    font-size: 3.5rem;
    opacity: 0.9;
    animation: pulse 2s ease-in-out infinite;
}

.archive-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 1rem;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    /* 覆盖style.css中的透明文字效果 */
    background: none;
    -webkit-background-clip: initial;
    -webkit-text-fill-color: white;
    background-clip: initial;
    color: white;
}

.archive-description {
    font-size: 1.1rem;
    margin: 1rem 0 2rem;
    opacity: 0.9;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

/* 归档统计 */
.archive-stats {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-top: 2rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* 过滤器 */
.archive-filters {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px var(--shadow-light);
    flex-wrap: wrap;
    gap: 1rem;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.filter-label {
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-label i {
    color: var(--accent-primary);
    font-size: 0.8rem;
}

.filter-select {
    padding: 0.5rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-size: 0.9rem;
    cursor: pointer;
    transition: all var(--transition-fast) ease;
}

.filter-select:focus {
    outline: none;
    border-color: var(--accent-primary);
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
}

/* 视图切换 */
.view-toggle {
    display: flex;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    overflow: hidden;
    background: var(--bg-secondary);
}

.view-btn {
    padding: 0.5rem 0.75rem;
    border: none;
    background: transparent;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all var(--transition-fast) ease;
    font-size: 0.9rem;
}

.view-btn:hover,
.view-btn.active {
    background: var(--accent-primary);
    color: white;
}

/* 搜索框 */
.search-box {
    display: flex;
    position: relative;
}

.filter-input {
    padding: 0.5rem 1rem;
    padding-right: 2.5rem;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-size: 0.9rem;
    width: 200px;
    transition: all var(--transition-fast) ease;
}

.filter-input:focus {
    outline: none;
    border-color: var(--accent-primary);
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
    width: 250px;
}

.search-btn {
    position: absolute;
    right: 0.25rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    padding: 0.25rem;
    transition: color var(--transition-fast) ease;
}

.search-btn:hover {
    color: var(--accent-primary);
}

/* 文章容器 */
.posts-container {
    margin-bottom: 2rem;
}

/* 网格视图 */
.view-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
}

/* 列表视图 */
.view-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.view-list .post-grid-content {
    display: none;
}

.view-list .post-list-content {
    display: flex !important;
}

/* 时间线视图 */
.view-timeline {
    position: relative;
    padding-left: 2rem;
}

.view-timeline::before {
    content: '';
    position: absolute;
    left: 1rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--gradient-primary);
    border-radius: 1px;
}

.view-timeline .post-grid-content,
.view-timeline .post-list-content {
    display: none;
}

.view-timeline .post-timeline-content {
    display: flex !important;
}

.view-timeline .archive-post-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.view-timeline .archive-post-item::before {
    content: '';
    position: absolute;
    left: -1.75rem;
    top: 1rem;
    width: 12px;
    height: 12px;
    background: var(--accent-primary);
    border: 3px solid var(--bg-primary);
    border-radius: 50%;
    z-index: 1;
}

/* 文章项样式 */
.archive-post-item {
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all var(--transition-medium) ease;
    box-shadow: 0 4px 15px var(--shadow-light);
}

.archive-post-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px var(--shadow-medium);
}

/* 网格内容 */
.post-thumbnail {
    position: relative;
    height: 200px;
    background: var(--bg-secondary);
    overflow: hidden;
}

.post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow) ease;
}

.archive-post-item:hover .post-thumbnail img {
    transform: scale(1.05);
}

.thumbnail-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gradient-primary);
    color: white;
    font-size: 2rem;
    opacity: 0.8;
}

/* 文章标识 */
.post-badges {
    position: absolute;
    top: 1rem;
    left: 1rem;
    display: flex;
    gap: 0.5rem;
}

.badge {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.3rem 0.6rem;
    border-radius: var(--radius-sm);
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
}

.badge.sticky {
    background: #e74c3c;
}

.badge.protected {
    background: #f39c12;
}

/* 快速操作 */
.post-quick-actions {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity var(--transition-fast) ease;
}

.archive-post-item:hover .post-quick-actions {
    opacity: 1;
}

.quick-action {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all var(--transition-fast) ease;
    text-decoration: none;
    backdrop-filter: blur(10px);
}

.quick-action:hover {
    background: var(--accent-primary);
    color: white;
    transform: scale(1.1);
}

.quick-action::after {
    display: none;
}

/* 文章信息 */
.post-info {
    padding: 1.5rem;
}

.post-category a {
    display: inline-block;
    padding: 0.3rem 0.6rem;
    background: var(--accent-primary);
    color: white;
    border-radius: var(--radius-sm);
    font-size: 0.75rem;
    font-weight: 500;
    text-decoration: none;
    margin-right: 0.5rem;
    transition: all var(--transition-fast) ease;
    /* 确保不使用透明文字效果 */
    -webkit-background-clip: initial;
    -webkit-text-fill-color: white;
    background-clip: initial;
}

.post-category a::after {
    display: none;
}

.post-category a:hover {
    background: var(--accent-secondary);
    transform: translateY(-1px);
}

.post-title {
    margin: 1rem 0;
    font-size: 1.3rem;
    line-height: 1.3;
    font-weight: 600;
}

.post-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color var(--transition-fast) ease;
    /* 覆盖style.css中的透明文字效果 */
    background: none;
    -webkit-background-clip: initial;
    -webkit-text-fill-color: initial;
    background-clip: initial;
}

.post-title a::after {
    display: none;
}

.post-title a:hover {
    color: var(--accent-primary);
}

.post-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* 文章元数据 */
.post-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 1rem 0;
    font-size: 0.85rem;
    color: var(--text-muted);
}

.meta-left,
.meta-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.meta-item i {
    color: var(--accent-primary);
    font-size: 0.8rem;
}

.author-avatar {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 2px solid var(--accent-primary);
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

/* 文章标签 */
.post-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 1rem;
}

.post-tags a {
    padding: 0.25rem 0.5rem;
    background: var(--bg-secondary);
    color: var(--text-muted);
    border-radius: var(--radius-sm);
    font-size: 0.75rem;
    text-decoration: none;
    transition: all var(--transition-fast) ease;
    border: 1px solid var(--border-color);
}

.post-tags a::after {
    display: none;
}

.post-tags a:hover {
    background: var(--accent-primary);
    color: white;
    border-color: var(--accent-primary);
    transform: translateY(-1px);
}

/* 列表视图样式 */
.post-list-content {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
}

.list-thumbnail {
    flex-shrink: 0;
    width: 120px;
    height: 120px;
    border-radius: var(--radius-md);
    overflow: hidden;
    background: var(--bg-secondary);
}

.list-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.list-content {
    flex: 1;
    min-width: 0;
}

.list-header {
    margin-bottom: 1rem;
}

.list-title {
    margin: 0 0 0.5rem;
    font-size: 1.2rem;
    font-weight: 600;
}

.list-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color var(--transition-fast) ease;
}

.list-title a::after {
    display: none;
}

.list-title a:hover {
    color: var(--accent-primary);
}

.list-meta {
    color: var(--text-muted);
    font-size: 0.85rem;
}

.list-meta a {
    color: inherit;
    text-decoration: none;
    /* 确保不使用透明文字效果 */
    -webkit-background-clip: initial;
    -webkit-text-fill-color: inherit;
    background-clip: initial;
}

.list-meta a::after {
    display: none;
}

.list-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.list-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.list-tags {
    display: flex;
    gap: 0.25rem;
}

.list-tags a {
    padding: 0.2rem 0.4rem;
    background: var(--bg-secondary);
    color: var(--text-muted);
    border-radius: var(--radius-sm);
    font-size: 0.7rem;
    text-decoration: none;
    transition: all var(--transition-fast) ease;
}

.list-tags a::after {
    display: none;
}

.list-tags a:hover {
    background: var(--accent-primary);
    color: white;
}

.read-more {
    color: var(--accent-primary);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all var(--transition-fast) ease;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.read-more::after {
    display: none;
}

.read-more:hover {
    transform: translateX(3px);
}

/* 时间线视图样式 */
.post-timeline-content {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-primary);
    border-radius: var(--radius-md);
    border: 1px solid var(--border-color);
}

.timeline-date {
    flex-shrink: 0;
    text-align: center;
    background: var(--accent-primary);
    color: white;
    border-radius: var(--radius-md);
    padding: 0.75rem;
    min-width: 60px;
}

.timeline-month {
    display: block;
    font-size: 0.8rem;
    opacity: 0.8;
}

.timeline-day {
    display: block;
    font-size: 1.2rem;
    font-weight: 700;
}

.timeline-content {
    flex: 1;
}

.timeline-header {
    margin-bottom: 0.5rem;
}

.timeline-title {
    margin: 0 0 0.25rem;
    font-size: 1.1rem;
    font-weight: 600;
}

.timeline-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color var(--transition-fast) ease;
}

.timeline-title a::after {
    display: none;
}

.timeline-title a:hover {
    color: var(--accent-primary);
}

.timeline-meta {
    color: var(--text-muted);
    font-size: 0.8rem;
}

.timeline-meta a {
    color: inherit;
    text-decoration: none;
    /* 确保不使用透明文字效果 */
    -webkit-background-clip: initial;
    -webkit-text-fill-color: inherit;
    background-clip: initial;
}

.timeline-meta a::after {
    display: none;
}

.separator {
    margin: 0 0.5rem;
}

.timeline-excerpt {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* 空状态 */
.empty-state {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
    text-align: center;
}

.empty-content {
    background: var(--bg-primary);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border-color);
    padding: 3rem;
    max-width: 500px;
    box-shadow: 0 4px 20px var(--shadow-light);
}

.empty-icon i {
    font-size: 4rem;
    color: var(--text-muted);
    margin-bottom: 1.5rem;
}

.empty-title {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.empty-description {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.search-keyword {
    color: var(--accent-primary);
    font-weight: 600;
}

.empty-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.btn-primary,
.btn-secondary {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-md);
    text-decoration: none;
    font-weight: 500;
    transition: all var(--transition-fast) ease;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
}

.btn-primary {
    background: var(--accent-primary);
    color: white;
}

.btn-secondary {
    background: var(--bg-secondary);
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
}

.btn-primary:hover,
.btn-secondary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px var(--shadow-medium);
}

.btn-primary::after,
.btn-secondary::after {
    display: none;
}

/* 相关项目 */
.related-section {
    background: var(--bg-primary);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border-color);
    padding: 2rem;
    margin-top: 2rem;
    box-shadow: 0 4px 20px var(--shadow-light);
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    font-size: 1.3rem;
    color: var(--text-primary);
}

.section-title i {
    color: var(--accent-primary);
}

.related-items {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.related-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    border: 1px solid var(--border-color);
    text-decoration: none;
    transition: all var(--transition-fast) ease;
}

.related-item::after {
    display: none;
}

.related-item:hover {
    background: var(--bg-tertiary);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px var(--shadow-light);
}

.item-icon {
    width: 40px;
    height: 40px;
    background: var(--accent-primary);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.item-name {
    display: block;
    color: var(--text-primary);
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.item-count {
    display: block;
    color: var(--text-muted);
    font-size: 0.8rem;
}

/* 分页样式 */
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
    border-radius: var(--radius-lg);
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

/* 响应式设计 */
@media (max-width: 991px) {
    .archive-filters {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .filter-group {
        justify-content: space-between;
    }
    
    .view-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .filter-input:focus {
        width: 100%;
    }
    
    .archive-stats {
        gap: 1rem;
    }
    
    .related-items {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 767px) {
    .hero-content {
        padding: 2rem 1rem;
    }
    
    .archive-title {
        font-size: 2rem;
    }
    
    .archive-icon i {
        font-size: 2.5rem;
    }
    
    .post-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .meta-left,
    .meta-right {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    /* 优化手机端文章卡片 */
    .post-list-content {
        flex-direction: column;
    }
    
    .list-thumbnail {
        width: 100%;
        height: 100px; /* 减小高度 */
    }
    
    .list-content {
        padding: 0.8rem; /* 减小内边距 */
    }
    
    .list-title {
        font-size: 1.1rem; /* 减小标题字体 */
        margin-bottom: 0.3rem; /* 减小下边距 */
    }
    
    .list-meta {
        font-size: 0.8rem; /* 减小元数据字体 */
    }
    
    .list-excerpt {
        font-size: 0.9rem; /* 减小摘要字体 */
        margin: 0.5rem 0; /* 减小上下边距 */
        line-height: 1.4; /* 减小行高 */
        max-height: 4.2em; /* 限制高度为3行 */
        overflow: hidden;
    }
    
    /* 隐藏手机端不必要的元素 */
    .list-footer .list-actions,
    .list-meta .action-item,
    .list-meta .separator {
        display: none;
    }
    
    .list-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
        margin-top: 0.5rem; /* 减小上边距 */
    }
    
    .archive-post-item {
        margin-bottom: 1rem; /* 减小文章卡片间距 */
    }
    
    /* 时间线视图优化 */
    .view-timeline {
        padding-left: 1rem;
    }
    
    .view-timeline::before {
        left: 0.5rem;
    }
    
    .view-timeline .archive-post-item::before {
        left: -0.25rem;
    }
    
    .post-timeline-content {
        flex-direction: column;
    }
    
    .timeline-date {
        min-width: auto;
        padding: 0.5rem 1rem;
    }
    
    .timeline-content {
        padding: 0.8rem; /* 减小内边距 */
    }
    
    .timeline-title {
        font-size: 1.1rem; /* 减小标题字体 */
    }
    
    .timeline-excerpt {
        font-size: 0.9rem; /* 减小摘要字体 */
        line-height: 1.4; /* 减小行高 */
        max-height: 4.2em; /* 限制高度 */
        overflow: hidden;
    }
    
    .empty-content {
        padding: 2rem 1rem;
    }
    
    .empty-actions {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .archive-stats {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
    
    .post-thumbnail {
        height: 150px;
    }
    
    .post-info {
        padding: 1rem;
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

/* 动画效果 */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.archive-post-item {
    animation: fadeInUp 0.6s ease forwards;
}

.archive-post-item:nth-child(even) {
    animation-delay: 0.1s;
}

.archive-post-item:nth-child(3n) {
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 初始化归档页面功能
    initArchivePage();
    
    // 统计数据动画
    animateStats();
    
    // 视图切换功能
    initViewToggle();
    
    // 排序功能
    initSorting();
    
    // 过滤搜索功能
    initFilterSearch();
    
    // 快速操作
    initQuickActions();
});

function initArchivePage() {
    // 获取文章数量并更新统计
    const postItems = document.querySelectorAll('.archive-post-item');
    const commentCounts = Array.from(postItems).reduce((total, item) => {
        const commentText = item.querySelector('.meta-comments a')?.textContent || '0';
        const count = parseInt(commentText) || 0;
        return total + count;
    }, 0);
    
    // 更新统计显示
    document.getElementById('postCount').textContent = postItems.length;
    document.getElementById('commentCount').textContent = commentCounts;
    
    // 使用PHP传递的真实浏览量数据
    const viewCountElement = document.getElementById('viewCount');
    const viewCount = parseInt(viewCountElement.getAttribute('data-views')) || 0;
    viewCountElement.textContent = viewCount;
}

function animateStats() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    statNumbers.forEach(stat => {
        const target = parseInt(stat.textContent);
        if (!isNaN(target)) {
            let current = 0;
            const increment = target / 30;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                stat.textContent = Math.floor(current);
            }, 50);
        }
    });
}

function initViewToggle() {
    const viewBtns = document.querySelectorAll('.view-btn');
    const postsContainer = document.getElementById('postsContainer');
    const postItems = document.querySelectorAll('.archive-post-item');
    
    // 初始化时隐藏网格视图内容，显示列表视图内容
    postItems.forEach(item => {
        const gridContent = item.querySelector('.post-grid-content');
        const listContent = item.querySelector('.post-list-content');
        
        if (gridContent) gridContent.style.display = 'none';
        if (listContent) listContent.style.display = 'flex';
    });
    
    // 确保列表视图按钮默认处于激活状态
    const listViewBtn = document.querySelector('.view-btn[data-view="list"]');
    if (listViewBtn) {
        listViewBtn.classList.add('active');
    }
    
    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // 更新按钮状态
            viewBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // 获取视图类型
            const viewType = this.dataset.view;
            
            // 更新容器类
            postsContainer.className = `posts-container view-${viewType}`;
            
            // 显示/隐藏对应内容
            postItems.forEach(item => {
                const listContent = item.querySelector('.post-list-content');
                const timelineContent = item.querySelector('.post-timeline-content');
                
                // 隐藏所有内容
                if (listContent) listContent.style.display = 'none';
                if (timelineContent) timelineContent.style.display = 'none';
                
                // 显示对应内容
                switch (viewType) {
                    case 'list':
                        if (listContent) listContent.style.display = 'flex';
                        break;
                    case 'timeline':
                        if (timelineContent) timelineContent.style.display = 'flex';
                        break;
                }
            });
        });
    });
}

function initSorting() {
    const sortSelect = document.getElementById('sortSelect');
    const postsContainer = document.getElementById('postsContainer');
    
    sortSelect.addEventListener('change', function() {
        const sortType = this.value;
        const postItems = Array.from(document.querySelectorAll('.archive-post-item'));
        
        // 排序逻辑
        postItems.sort((a, b) => {
            switch (sortType) {
                case 'created_desc':
                    return new Date(b.dataset.date) - new Date(a.dataset.date);
                case 'created_asc':
                    return new Date(a.dataset.date) - new Date(b.dataset.date);
                case 'title_asc':
                    const titleA = a.querySelector('.post-title a').textContent;
                    const titleB = b.querySelector('.post-title a').textContent;
                    return titleA.localeCompare(titleB);
                case 'comments_desc':
                    const commentsA = parseInt(a.querySelector('.meta-comments a').textContent) || 0;
                    const commentsB = parseInt(b.querySelector('.meta-comments a').textContent) || 0;
                    return commentsB - commentsA;
                default:
                    return 0;
            }
        });
        
        // 重新排列DOM
        postItems.forEach(item => postsContainer.appendChild(item));
        
        // 重新应用动画
        postItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.05}s`;
        });
    });
}

function initFilterSearch() {
    const filterInput = document.getElementById('filterSearch');
    const filterBtn = document.getElementById('filterBtn');
    const postItems = document.querySelectorAll('.archive-post-item');
    
    function performFilter() {
        const searchTerm = filterInput.value.toLowerCase();
        
        postItems.forEach(item => {
            const title = item.querySelector('.post-title a').textContent.toLowerCase();
            const excerpt = item.querySelector('.post-excerpt')?.textContent.toLowerCase() || 
                           item.querySelector('.list-excerpt')?.textContent.toLowerCase() || 
                           item.querySelector('.timeline-excerpt')?.textContent.toLowerCase() || '';
            const category = item.querySelector('.post-category')?.textContent.toLowerCase() || '';
            
            const isVisible = title.includes(searchTerm) || 
                            excerpt.includes(searchTerm) || 
                            category.includes(searchTerm);
            
            if (isVisible) {
                item.style.display = '';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            } else {
                item.style.opacity = '0';
                item.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    item.style.display = 'none';
                }, 300);
            }
        });
    }
    
    filterInput.addEventListener('input', performFilter);
    filterBtn.addEventListener('click', performFilter);
    
    // 清空搜索
    filterInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            performFilter();
        }
    });
}

function initQuickActions() {
    const quickActions = document.querySelectorAll('.quick-action');
    
    quickActions.forEach(action => {
        if (action.classList.contains('like-btn')) {
            action.addEventListener('click', function(e) {
                e.preventDefault();
                
                // 添加点赞效果
                this.style.background = '#e74c3c';
                this.style.color = 'white';
                this.style.transform = 'scale(1.2)';
                
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
            });
        } else if (action.classList.contains('share-btn')) {
            action.addEventListener('click', function(e) {
                e.preventDefault();
                
                const postItem = this.closest('.archive-post-item');
                const postTitle = postItem.querySelector('.post-title a').textContent;
                const postUrl = postItem.querySelector('.post-title a').href;
                
                if (navigator.share) {
                    navigator.share({
                        title: postTitle,
                        url: postUrl
                    });
                } else {
                    navigator.clipboard.writeText(postUrl).then(() => {
                        // 显示提示
                        this.innerHTML = '<i class="fas fa-check"></i>';
                        setTimeout(() => {
                            this.innerHTML = '<i class="fas fa-share-alt"></i>';
                        }, 2000);
                    });
                }
            });
        }
    });
}

// 滚动加载更多（如果需要）
function initInfiniteScroll() {
    let loading = false;
    let page = 1;
    
    window.addEventListener('scroll', () => {
        if (loading) return;
        
        const scrollHeight = document.documentElement.scrollHeight;
        const scrollTop = window.pageYOffset;
        const clientHeight = window.innerHeight;
        
        if (scrollTop + clientHeight >= scrollHeight - 1000) {
            loading = true;
            
            // 这里可以添加AJAX加载更多文章的逻辑
            // loadMorePosts(++page).then(() => {
            //     loading = false;
            // });
        }
    });
}
</script>
