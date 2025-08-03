<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="container">
  <div class="row">
    <div class="main-layout">
      <main class="main-content" id="main" role="main">
        <article class="post single-post" itemscope itemtype="http://schema.org/BlogPosting">
            <!-- 文章头部 -->
            <header class="post-header">
                <?php $thumbnail = getPostThumbnail($this); ?>
                <?php if ($thumbnail): ?>
                    <div class="post-featured-image">
                        <img src="<?php echo $thumbnail; ?>" 
                             alt="<?php $this->title(); ?>" 
                             itemprop="image"
                             class="featured-img">
                        <div class="image-overlay"></div>
                    </div>
                <?php endif; ?>
                
                <div class="post-header-content">
                    <!-- 面包屑导航 -->
                    <nav class="breadcrumb" aria-label="面包屑导航">
                        <a href="<?php $this->options->siteUrl(); ?>" class="breadcrumb-item">
                            <i class="fas fa-home"></i>
                            <span>首页</span>
                        </a>
                        <span class="breadcrumb-separator">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                        <?php $this->category(' / ', false, ''); ?>
                        <span class="breadcrumb-separator">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                        <span class="breadcrumb-current">正文</span>
                    </nav>
                    
                    <!-- 文章分类 -->
                    <div class="post-categories">
                        <?php $this->category(',', false, ''); ?>
                    </div>
                    
                    <!-- 文章标题 -->
                    <h1 class="post-title" itemprop="name headline">
                        <?php $this->title() ?>
                    </h1>
                    
                    <!-- 文章摘要 -->
                    <?php if ($this->fields->excerpt): ?>
                        <div class="post-excerpt">
                            <?php echo $this->fields->excerpt; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- 文章元信息 -->
                    <div class="post-meta">
                        <div class="meta-left">
                            <div class="author-info" itemprop="author" itemscope itemtype="http://schema.org/Person">
                                <img src="<?php echo Typecho_Common::gravatarUrl($this->author->mail, 40, 'X', 'mm', $this->request->isSecure()); ?>" 
                                     alt="<?php $this->author(); ?>" 
                                     class="author-avatar">
                                <div class="author-details">
                                    <a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author" class="author-name">
                                        <?php $this->author(); ?>
                                    </a>
                                    <div class="author-title">作者</div>
                                </div>
                            </div>
                            
                            <div class="meta-items">
                                <div class="meta-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished">
                                        <?php $this->date('Y年m月d日'); ?>
                                    </time>
                                </div>
                                
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    <span><?php echo getReadingTime($this->content); ?> 分钟阅读</span>
                                </div>
                                
                                <div class="meta-item">
                                    <i class="fas fa-eye"></i>
                                    <span class="view-count"><?php echo formatViewsNum(getPostViews($this)); ?> 阅读</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="meta-right">
                            <div class="post-actions">
                                <div class="action-item">
                                    <i class="fas fa-comments"></i>
                                    <span><?php $this->commentsNum('0', '1', '%d'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- 文章内容 -->
            <div class="post-content-wrapper" style="display: flex; align-items: flex-start; gap: 2rem;">
                <!-- 主要内容 -->
                <div class="post-content" itemprop="articleBody" style="flex:1.5; min-width:0;">
                    <?php $parsedContent = parseContent($this->content); ?>
                    <?php echo $parsedContent; ?>
                </div>
                <!-- 文章目录 -->
                <aside class="post-toc" id="postToc" style="position: static; float: none; margin: 0; min-width: 220px; max-width: 260px; flex-shrink: 0;">
                    <div class="toc-header">
                        <h3><i class="fas fa-list"></i> 文章目录</h3>
                        <button class="toc-toggle" id="tocToggle">
                            <i class="fas fa-chevron-up"></i>
                        </button>
                    </div>
                    <div class="toc-content" id="tocContent">
                        <!-- 目录将通过JavaScript动态生成 -->
                    </div>
                </aside>
            </div>
            
            <!-- 版权声明 -->
            <div class="post-copyright">
                <div class="copyright-content">
                    <div class="copyright-icon">
                        <i class="fas fa-copyright"></i>
                    </div>
                    <div class="copyright-text">
                        <p><strong>本文作者：</strong><?php $this->author(); ?></p>
                        <p><strong>本文链接：</strong><a href="<?php $this->permalink(); ?>"><?php $this->permalink(); ?></a></p>
                        <p><strong>版权声明：</strong>本博客所有文章除特别声明外，均采用 <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/" target="_blank" rel="noopener">BY-NC-SA</a> 许可协议。转载请注明出处！</p>
                    </div>
                </div>
            </div>
            
            <!-- 文章标签 -->
            <?php if ($this->tags): ?>
                <div class="post-tags">
                    <div class="tags-header">
                        <i class="fas fa-tags"></i>
                        <span>文章标签</span>
                    </div>
                    <div class="tags-list">
                        <?php $this->tags(' ', true, ''); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- 文章导航 -->
            <nav class="post-navigation">
                <div class="nav-item nav-prev">
                    <?php $this->thePrev(); ?>
                </div>
                <div class="nav-item nav-next">
                    <?php $this->theNext(); ?>
                </div>
            </nav>
        </article>
        
        <!-- 相关文章 -->
        <section class="related-posts">
            <h3 class="section-title">
                <i class="fas fa-newspaper"></i>
                <span>相关文章</span>
            </h3>
            <div class="related-posts-grid">
                <?php
                // 获取相关文章
                // 获取相关文章
                $categoryIds = array();

                // 新版本兼容的获取分类ID方法
                if (method_exists($this, 'categories')) {
                    // 适用于较新版本的Typecho
                    $categoryString = '';
                    $this->category(',', false, function($category) use (&$categoryIds) {
                        $categoryIds[] = $category['mid'];
                    });
                } else {
                    // 备用方法：通过字符串解析
                    ob_start();
                    $this->category(',', false, '');
                    $categoryOutput = ob_get_clean();
        
                    // 如果无法获取分类ID，则使用最新文章作为相关文章
                    if (empty($categoryIds)) {
                        $categoryIds = null;
                    }
                }

                
                if (!empty($categoryIds)) {
                    $relatedPosts = Typecho_Widget::widget('Widget_Contents_Post_Recent', 'pageSize=3&type=category&categoryId=' . implode(',', $categoryIds));
                    if ($relatedPosts->have()):
                        while ($relatedPosts->next()):
                            if ($relatedPosts->cid != $this->cid):
                ?>
                            <article class="related-post-item">
                                <div class="related-post-thumb">
                                    <?php $thumb = getPostThumbnail($relatedPosts); ?>
                                    <?php if ($thumb): ?>
                                        <img src="<?php echo $thumb; ?>" alt="<?php $relatedPosts->title(); ?>" loading="lazy">
                                    <?php else: ?>
                                        <div class="thumb-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="related-post-content">
                                    <h4 class="related-post-title">
                                        <a href="<?php $relatedPosts->permalink(); ?>">
                                            <?php $relatedPosts->title(); ?>
                                        </a>
                                    </h4>
                                    <div class="related-post-meta">
                                        <span class="post-date">
                                            <i class="fas fa-calendar"></i>
                                            <?php echo formatTime($relatedPosts->created); ?>
                                        </span>
                                        <span class="post-comments">
                                            <i class="fas fa-comments"></i>
                                            <?php $relatedPosts->commentsNum('0', '1', '%d'); ?>
                                        </span>
                                    </div>
                                    <div class="related-post-excerpt">
                                        <?php echo getExcerpt($relatedPosts->content, 80); ?>
                                    </div>
                                </div>
                            </article>
                <?php
                            endif;
                        endwhile;
                    endif;
                }
                ?>
            </div>
        </section>
        
        <!-- 评论区域 -->
        <?php $this->need('comments.php'); ?>
      </main>
      <?php $this->need('sidebar.php'); ?>
    </div>
  </div>
</div>

<!-- 文章浮动工具栏 -->
<div class="post-float-tools" id="floatTools">
    <div class="tool-item toc-tool" title="目录">
        <i class="fas fa-list"></i>
    </div>
    <div class="tool-item comment-tool" title="评论">
        <i class="fas fa-comments"></i>
        <span class="tool-count"><?php $this->commentsNum('0', '1', '%d'); ?></span>
    </div>
</div>

<!-- 分享面板 -->
<div class="share-panel" id="sharePanel">
    <div class="share-header">
        <h4>分享到</h4>
        <button class="close-btn" id="closeShare">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="share-buttons">
        <a href="#" class="share-btn weibo" data-share="weibo">
            <i class="fab fa-weibo"></i>
            <span>微博</span>
        </a>
        <a href="#" class="share-btn qq" data-share="qq">
            <i class="fab fa-qq"></i>
            <span>QQ</span>
        </a>
        <a href="#" class="share-btn wechat" data-share="wechat">
            <i class="fab fa-weixin"></i>
            <span>微信</span>
        </a>
        <a href="#" class="share-btn link" data-share="link">
            <i class="fas fa-link"></i>
            <span>复制链接</span>
        </a>
    </div>
</div>

<style>
/* 单篇文章样式 */
.single-post {
    background: var(--bg-primary);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border-color);
    overflow: hidden;
    box-shadow: 0 4px 20px var(--shadow-light);
    margin-bottom: 2rem;
}

/* 文章头部 */
.post-header {
    position: relative;
}

.post-featured-image {
    position: relative;
    height: 300px;
    overflow: hidden;
    background: var(--bg-secondary);
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

.post-header-content {
    padding: 2rem;
}

/* 面包屑导航 */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.85rem;
    color: var(--text-muted);
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: var(--text-muted);
    text-decoration: none;
    transition: color var(--transition-fast) ease;
}

.breadcrumb-item::after {
    display: none;
}

.breadcrumb-item:hover {
    color: var(--accent-primary);
}

.breadcrumb-separator {
    color: var(--text-muted);
    font-size: 0.7rem;
}

.breadcrumb-current {
    color: var(--accent-primary);
    font-weight: 500;
}

/* 文章分类 */
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

/* 文章标题 */
.post-title {
    font-size: 2.2rem;
    line-height: 1.3;
    margin: 0 0 1rem;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
}

/* 文章摘要 */
.post-excerpt {
    font-size: 1.1rem;
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 2rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-left: 4px solid var(--accent-primary);
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
}

/* 文章元信息 */
.post-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-lg);
    margin-top: 1rem;
}

.meta-left {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.author-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.author-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 3px solid var(--accent-primary);
    transition: all var(--transition-fast) ease;
}

.author-info:hover .author-avatar {
    transform: scale(1.1);
    border-color: var(--accent-secondary);
}

.author-name {
    color: var(--text-primary);
    font-weight: 600;
    font-size: 1.1rem;
    text-decoration: none;
    transition: color var(--transition-fast) ease;
}

.author-name::after {
    display: none;
}

.author-name:hover {
    color: var(--accent-primary);
}

.author-title {
    font-size: 0.8rem;
    color: var(--text-muted);
}

.meta-items {
    display: flex;
    gap: 1.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.meta-item i {
    color: var(--accent-primary);
    font-size: 0.8rem;
}

/* 文章操作按钮 */
.post-actions {
    display: flex;
    gap: 0.75rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.6rem 1rem;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    color: var(--text-secondary);
    cursor: pointer;
    transition: all var(--transition-fast) ease;
    font-size: 0.85rem;
}

.action-btn:hover {
    background: var(--accent-primary);
    border-color: var(--accent-primary);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px var(--shadow-medium);
}

.like-btn.liked {
    background: #e74c3c;
    border-color: #e74c3c;
    color: white;
}

/* 文章内容区域 */
.post-content-wrapper {
    position: relative;
    padding: 2rem;
}

/* 文章目录 */
.post-toc {
    position: sticky;
    top: 100px;
    float: right;
    width: 200px;
    margin: 0 0 2rem 2rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    max-height: 400px;
    overflow: hidden;
    transition: all var(--transition-fast) ease;
}

.toc-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--bg-tertiary);
    border-bottom: 1px solid var(--border-color);
}

.toc-header h3 {
    margin: 0;
    font-size: 0.9rem;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.toc-header i {
    color: var(--accent-primary);
}

.toc-toggle {
    background: none;
    border: none;
    color: var(--text-secondary);
    cursor: pointer;
    transition: color var(--transition-fast) ease;
}

.toc-toggle:hover {
    color: var(--accent-primary);
}

.toc-content {
    padding: 1rem;
    max-height: 300px;
    overflow-y: auto;
}

.toc-content ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.toc-content li {
    margin: 0.25rem 0;
}

.toc-content a {
    display: block;
    padding: 0.25rem 0.5rem;
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.85rem;
    border-radius: var(--radius-sm);
    transition: all var(--transition-fast) ease;
}

.toc-content a::after {
    display: none;
}

.toc-content a:hover,
.toc-content a.active {
    background: var(--accent-primary);
    color: white;
}

/* 文章内容 */
.post-content {
    line-height: 1.8;
    color: var(--text-primary);
    font-size: 1.05rem;
}

.post-content h1,
.post-content h2,
.post-content h3,
.post-content h4,
.post-content h5,
.post-content h6 {
    margin: 2rem 0 1rem;
    position: relative;
    scroll-margin-top: 100px;
}

.post-content h1::before,
.post-content h2::before,
.post-content h3::before {
    content: '';
    position: absolute;
    left: -1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 1.2em;
    background: var(--gradient-primary);
    border-radius: 2px;
}

.post-content p {
    margin-bottom: 1.5rem;
    text-align: justify;
}

.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: var(--radius-md);
    box-shadow: 0 4px 15px var(--shadow-light);
    transition: all var(--transition-medium) ease;
    margin: 1rem 0;
}

.post-content img:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 30px var(--shadow-medium);
}

.post-content blockquote {
    margin: 2rem 0;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-left: 4px solid var(--accent-primary);
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
    position: relative;
}

.post-content blockquote::before {
    content: '"';
    font-size: 4rem;
    color: var(--accent-primary);
    position: absolute;
    top: -10px;
    left: 20px;
    opacity: 0.3;
}

/* 提示框样式 */
.tip-box {
    margin: 1.5rem 0;
    padding: 1rem 1rem 1rem 3rem;
    border-radius: var(--radius-md);
    position: relative;
    border-left: 4px solid;
}

.tip-box i {
    position: absolute;
    left: 1rem;
    top: 1rem;
    font-size: 1.2rem;
}

.tip-info {
    background: rgba(52, 152, 219, 0.1);
    border-left-color: #3498db;
    color: var(--text-primary);
}

.tip-info i {
    color: #3498db;
}

.tip-warning {
    background: rgba(243, 156, 18, 0.1);
    border-left-color: #f39c12;
    color: var(--text-primary);
}

.tip-warning i {
    color: #f39c12;
}

.tip-error {
    background: rgba(231, 76, 60, 0.1);
    border-left-color: #e74c3c;
    color: var(--text-primary);
}

.tip-error i {
    color: #e74c3c;
}

.tip-success {
    background: rgba(46, 204, 113, 0.1);
    border-left-color: #2ecc71;
    color: var(--text-primary);
}

.tip-success i {
    color: #2ecc71;
}

/* 版权声明 */
.post-copyright {
    margin: 2rem 0;
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--bg-secondary), var(--bg-tertiary));
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
}

.copyright-content {
    display: flex;
    gap: 1rem;
}

.copyright-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    background: var(--accent-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.copyright-text {
    flex: 1;
}

.copyright-text p {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.copyright-text p:last-child {
    margin-bottom: 0;
}

.copyright-text a {
    color: var(--accent-primary);
    text-decoration: none;
}

.copyright-text a::after {
    display: none;
}

/* 文章标签 */
.post-tags {
    padding: 0 2rem 2rem;
}

.tags-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.tags-header i {
    color: var(--accent-primary);
}

.tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.tags-list a {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1rem;
    background: var(--bg-secondary);
    color: var(--text-secondary);
    border-radius: var(--radius-lg);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all var(--transition-fast) ease;
    border: 1px solid var(--border-color);
}

.tags-list a::before {
    content: '#';
    color: var(--accent-primary);
    font-weight: 700;
}

.tags-list a::after {
    display: none;
}

.tags-list a:hover {
    background: var(--accent-primary);
    border-color: var(--accent-primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px var(--shadow-medium);
}

/* 文章导航 */
.post-navigation {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    padding: 2rem;
    border-top: 1px solid var(--border-color);
    background: var(--bg-secondary);
}

.nav-item {
    position: relative;
}

.nav-item a {
    display: block;
    padding: 1.5rem;
    background: var(--bg-primary);
    border-radius: var(--radius-lg);
    text-decoration: none;
    color: var(--text-secondary);
    transition: all var(--transition-fast) ease;
    border: 1px solid var(--border-color);
    height: 100%;
}

.nav-item a::after {
    display: none;
}

.nav-item a:hover {
    background: var(--bg-tertiary);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px var(--shadow-light);
}

.nav-prev a::before {
    content: '← 上一篇';
    display: block;
    font-size: 0.8rem;
    color: var(--accent-primary);
    margin-bottom: 0.5rem;
}

.nav-next a::before {
    content: '下一篇 →';
    display: block;
    font-size: 0.8rem;
    color: var(--accent-primary);
    margin-bottom: 0.5rem;
    text-align: right;
}

.nav-next a {
    text-align: right;
}

/* 相关文章 */
.related-posts {
    margin: 2rem 0;
    background: var(--bg-primary);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border-color);
    padding: 2rem;
    box-shadow: 0 4px 20px var(--shadow-light);
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    font-size: 1.4rem;
    color: var(--text-primary);
}

.section-title i {
    color: var(--accent-primary);
}

.related-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.related-post-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    transition: all var(--transition-fast) ease;
}

.related-post-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px var(--shadow-light);
}

.related-post-thumb {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    border-radius: var(--radius-md);
    overflow: hidden;
    background: var(--bg-tertiary);
}

.related-post-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-fast) ease;
}

.related-post-item:hover .related-post-thumb img {
    transform: scale(1.1);
}

.thumb-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    background: var(--gradient-primary);
}

.thumb-placeholder i {
    color: white;
    opacity: 0.8;
}

.related-post-content {
    flex: 1;
    min-width: 0;
}

.related-post-title {
    margin: 0 0 0.5rem;
    font-size: 1rem;
    line-height: 1.3;
}

.related-post-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color var(--transition-fast) ease;
}

.related-post-title a::after {
    display: none;
}

.related-post-title a:hover {
    color: var(--accent-primary);
}

.related-post-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 0.5rem;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.related-post-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.related-post-excerpt {
    font-size: 0.85rem;
    color: var(--text-secondary);
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* 浮动工具栏 */
.post-float-tools {
    position: fixed;
    right: 2rem;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    z-index: 100;
    opacity: 0;
    visibility: hidden;
    transition: all var(--transition-fast) ease;
}

.post-float-tools.show {
    opacity: 1;
    visibility: visible;
}

.tool-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 50%;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all var(--transition-fast) ease;
    box-shadow: 0 4px 15px var(--shadow-light);
    position: relative;
}

.tool-item:hover {
    background: var(--accent-primary);
    border-color: var(--accent-primary);
    color: white;
    transform: scale(1.1);
    box-shadow: 0 6px 20px var(--shadow-medium);
}

.tool-count {
    font-size: 0.7rem;
    font-weight: 600;
    margin-top: 0.2rem;
}

/* 分享面板 */
.share-panel {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: var(--bg-primary);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border-color);
    box-shadow: 0 20px 50px var(--shadow-strong);
    z-index: 1000;
    min-width: 300px;
    opacity: 0;
    visibility: hidden;
    transition: all var(--transition-medium) ease;
}

.share-panel.show {
    opacity: 1;
    visibility: visible;
}

.share-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.share-header h4 {
    margin: 0;
    color: var(--text-primary);
}

.close-btn {
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    font-size: 1.2rem;
    transition: color var(--transition-fast) ease;
}

.close-btn:hover {
    color: var(--accent-primary);
}

.share-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    padding: 1.5rem;
}

.share-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all var(--transition-fast) ease;
}

.share-btn::after {
    display: none;
}

.share-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px var(--shadow-light);
}

.share-btn.weibo:hover { background: #e6162d; color: white; }
.share-btn.qq:hover { background: #12b7f5; color: white; }
.share-btn.wechat:hover { background: #2dc100; color: white; }
.share-btn.link:hover { background: var(--accent-primary); color: white; }

/* 响应式设计 */
@media (max-width: 991px) {
    .post-toc {
        display: none;
    }
    
    .post-content-wrapper {
        padding: 1.5rem;
    }
    
    .post-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .meta-left {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .meta-items {
        gap: 1rem;
    }
    
    .post-float-tools {
        display: none;
    }
    
    .related-posts-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 767px) {
    .post-header-content {
        padding: 1.5rem;
    }
    
    .post-title {
        font-size: 1.8rem;
    }
    
    .post-navigation {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    
    .nav-next a::before {
        text-align: left;
    }
    
    .nav-next a {
        text-align: left;
    }
    
    .related-post-item {
        flex-direction: column;
    }
    
    .related-post-thumb {
        width: 100%;
        height: 120px;
    }
    
    .share-buttons {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .post-featured-image {
        height: 200px;
    }
    
    .author-info {
        flex-direction: column;
        text-align: center;
    }
    
    .meta-items {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .post-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .action-btn {
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 生成文章目录
    generateTOC();
    
    // 浮动工具栏显示/隐藏
    handleFloatTools();
    
    // 分享功能
    initShare();
    
    // 目录切换
    initTOC();
    
    // 图片懒加载和放大
    initImageViewer();
    
    // 代码复制功能
    initCodeCopy();
    
    // 阅读进度
    initReadingProgress();
});

// 生成文章目录
function generateTOC() {
    const content = document.querySelector('.post-content');
    const tocContent = document.getElementById('tocContent');
    
    if (!content || !tocContent) return;
    
    const headings = content.querySelectorAll('h1, h2, h3, h4, h5, h6');
    if (headings.length === 0) {
        document.querySelector('.post-toc').style.display = 'none';
        return;
    }
    
    let tocHTML = '<ul>';
    let currentLevel = 0;
    
    headings.forEach((heading, index) => {
        const level = parseInt(heading.tagName.charAt(1));
        const text = heading.textContent;
        const id = `heading-${index}`;
        
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
    
    // 滚动时高亮当前章节
    window.addEventListener('scroll', updateTOCHighlight);
}

// 更新目录高亮
function updateTOCHighlight() {
    const headings = document.querySelectorAll('.post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5, .post-content h6');
    const tocLinks = document.querySelectorAll('.toc-link');
    
    let currentHeading = null;
    
    headings.forEach(heading => {
        const rect = heading.getBoundingClientRect();
        if (rect.top <= 150) {
            currentHeading = heading;
        }
    });
    
    tocLinks.forEach(link => link.classList.remove('active'));
    
    if (currentHeading) {
        const activeLink = document.querySelector(`a[href="#${currentHeading.id}"]`);
        if (activeLink) {
            activeLink.classList.add('active');
        }
    }
}

// 浮动工具栏处理
function handleFloatTools() {
    const floatTools = document.getElementById('floatTools');
    
    window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset;
        const windowHeight = window.innerHeight;
        const docHeight = document.documentElement.scrollHeight;
        
        if (scrollTop > 300 && scrollTop < docHeight - windowHeight - 300) {
            floatTools.classList.add('show');
        } else {
            floatTools.classList.remove('show');
        }
    });
    
    // 工具栏点击事件
    floatTools.addEventListener('click', function(e) {
        const tool = e.target.closest('.tool-item');
        if (!tool) return;
        
        if (tool.classList.contains('toc-tool')) {
            document.querySelector('.post-toc').scrollIntoView({
                behavior: 'smooth'
            });
        } else if (tool.classList.contains('comment-tool')) {
            document.querySelector('#comments').scrollIntoView({
                behavior: 'smooth'
            });
        } else if (tool.classList.contains('share-tool')) {
            document.getElementById('sharePanel').classList.add('show');
        }
    });
}

// 初始化分享功能
function initShare() {
    const sharePanel = document.getElementById('sharePanel');
    const closeBtn = document.getElementById('closeShare');
    const shareButtons = document.querySelectorAll('.share-btn');
    
    // 关闭分享面板
    closeBtn.addEventListener('click', () => {
        sharePanel.classList.remove('show');
    });
    
    // 点击外部关闭
    sharePanel.addEventListener('click', (e) => {
        if (e.target === sharePanel) {
            sharePanel.classList.remove('show');
        }
    });
    
    // 分享按钮点击
    shareButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const type = this.dataset.share;
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            
            switch (type) {
                case 'weibo':
                    window.open(`https://service.weibo.com/share/share.php?url=${url}&title=${title}`, '_blank');
                    break;
                case 'qq':
                    window.open(`https://connect.qq.com/widget/shareqq/index.html?url=${url}&title=${title}`, '_blank');
                    break;
                case 'wechat':
                    // 微信分享需要二维码
                    alert('请复制链接在微信中分享');
                    break;
                case 'link':
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        alert('链接已复制到剪贴板');
                    });
                    break;
            }
            
            sharePanel.classList.remove('show');
        });
    });
}

// 初始化目录功能
function initTOC() {
    const tocToggle = document.getElementById('tocToggle');
    const tocContent = document.getElementById('tocContent');
    
    if (tocToggle && tocContent) {
        tocToggle.addEventListener('click', () => {
            const isOpen = tocContent.style.display !== 'none';
            tocContent.style.display = isOpen ? 'none' : 'block';
            tocToggle.querySelector('i').classList.toggle('fa-chevron-up');
            tocToggle.querySelector('i').classList.toggle('fa-chevron-down');
        });
    }
}

// 初始化图片viewer
function initImageViewer() {
    const images = document.querySelectorAll('.post-content img');
    
    images.forEach(img => {
        img.style.cursor = 'pointer';
        img.addEventListener('click', () => {
            // 简单的图片放大效果
            const overlay = document.createElement('div');
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.8);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
                cursor: pointer;
            `;
            
            const enlargedImg = img.cloneNode();
            enlargedImg.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                object-fit: contain;
                border-radius: 8px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            `;
            
            overlay.appendChild(enlargedImg);
            document.body.appendChild(overlay);
            
            overlay.addEventListener('click', () => {
                document.body.removeChild(overlay);
            });
        });
    });
}

// 代码复制功能
function initCodeCopy() {
    const codeBlocks = document.querySelectorAll('pre code');
    
    codeBlocks.forEach(code => {
        const pre = code.parentElement;
        const copyBtn = document.createElement('button');
        copyBtn.textContent = '复制';
        copyBtn.style.cssText = `
            position: absolute;
            top: 8px;
            right: 8px;
            padding: 4px 8px;
            background: var(--accent-primary);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s;
        `;
        
        pre.style.position = 'relative';
        pre.appendChild(copyBtn);
        
        pre.addEventListener('mouseenter', () => {
            copyBtn.style.opacity = '1';
        });
        
        pre.addEventListener('mouseleave', () => {
            copyBtn.style.opacity = '0';
        });
        
        copyBtn.addEventListener('click', () => {
            navigator.clipboard.writeText(code.textContent).then(() => {
                copyBtn.textContent = '已复制';
                setTimeout(() => {
                    copyBtn.textContent = '复制';
                }, 2000);
            });
        });
    });
}

// 阅读进度
function initReadingProgress() {
    const progressBar = document.getElementById('readingProgress');
    if (!progressBar) return;
    
    window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;
        
        progressBar.style.width = Math.min(scrollPercent, 100) + '%';
    });
}
</script>

<?php $this->need('footer.php'); ?>
