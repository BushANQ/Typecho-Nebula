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
                        <a href="<?php $this->permalink(); ?>" class="post-card-link">
                        <div class="post-list-content">
                            <div class="list-thumbnail">
                                <?php $thumbnail = getPostThumbnail($this); ?>
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
                                        <span class="separator">•</span>
                                        <span class="action-item">
                                            <i class="fas fa-eye"></i>
                                            <?php echo formatViewsNum(getPostViews($this)); ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="list-excerpt">
                                    <?php echo getExcerpt($this->content, 100); ?>
                                </div>
                                
                                <div class="list-footer">
                                    <div class="list-tags">
                                        <?php $this->tags(' ', true, ''); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
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
