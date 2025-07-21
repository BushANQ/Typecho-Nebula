<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div id="comments" class="comments-section">
    <?php $this->comments()->to($comments); ?>
    
    <?php if ($comments->have()): ?>
        <div class="comments-header">
            <h3 class="comments-title">
                <i class="fas fa-comments"></i>
                <?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?>
            </h3>
            <div class="comments-stats">
                <span class="comment-count"><?php echo $comments->total; ?> 条评论</span>
            </div>
        </div>

        <div class="comment-list-wrapper">
            <?php $comments->listComments(); ?>
        </div>

        <div class="comments-pagination">
            <?php $comments->pageNav('← 较早评论', '较新评论 →', 3, '...', [
                'wrapTag' => 'ol',
                'wrapClass' => 'page-navigator comment-nav',
                'itemTag' => 'li',
                'textTag' => 'a',
                'currentClass' => 'current',
                'prevClass' => 'prev',
                'nextClass' => 'next'
            ]); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->allow('comment')): ?>
        <div id="<?php $this->respondId(); ?>" class="respond comment-form-container">
            <div class="cancel-comment-reply">
                <?php $comments->cancelReply('取消回复'); ?>
            </div>

            <div class="comment-form-header">
                <h3 id="response" class="comment-form-title">
                    <i class="fas fa-edit"></i>
                    <?php _e('发表评论'); ?>
                </h3>
                <p class="comment-notes">
                    <i class="fas fa-info-circle"></i>
                    您的邮箱地址不会被公开，必填项已用 <span class="required">*</span> 标注
                </p>
            </div>

            <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form" class="comment-form">
                <?php if ($this->user->hasLogin()): ?>
                    <div class="comment-user-info logged-in">
                        <div class="user-avatar">
                            <img src="<?php echo Typecho_Common::gravatarUrl($this->user->mail, 40, 'X', 'mm', $this->request->isSecure()); ?>" 
                                 alt="<?php $this->user->screenName(); ?>" class="avatar">
                        </div>
                        <div class="user-details">
                            <p class="user-greeting">
                                <i class="fas fa-user-circle"></i>
                                欢迎回来，<strong><?php $this->user->screenName(); ?></strong>
                            </p>
                            <p class="user-actions">
                                <a href="<?php $this->options->profileUrl(); ?>" class="user-profile">
                                    <i class="fas fa-cog"></i> 个人设置
                                </a>
                                <a href="<?php $this->options->logoutUrl(); ?>" class="user-logout">
                                    <i class="fas fa-sign-out-alt"></i> 退出登录
                                </a>
                            </p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="comment-form-fields">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="author" class="form-label required">
                                    <i class="fas fa-user"></i> 昵称
                                </label>
                                <input type="text" name="author" id="author" class="form-input" 
                                       value="<?php $this->remember('author'); ?>" 
                                       placeholder="请输入您的昵称" required autocomplete="name"/>
                            </div>
                            <div class="form-group">
                                <label for="mail" class="form-label<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?>">
                                    <i class="fas fa-envelope"></i> 邮箱
                                </label>
                                <input type="email" name="mail" id="mail" class="form-input" 
                                       value="<?php $this->remember('mail'); ?>" 
                                       placeholder="your@email.com"
                                       <?php if ($this->options->commentsRequireMail): ?>required<?php endif; ?> 
                                       autocomplete="email"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url" class="form-label<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?>">
                                <i class="fas fa-globe"></i> 网站
                            </label>
                            <input type="url" name="url" id="url" class="form-input" 
                                   placeholder="https://yoursite.com" 
                                   value="<?php $this->remember('url'); ?>"
                                   <?php if ($this->options->commentsRequireURL): ?>required<?php endif; ?> 
                                   autocomplete="url"/>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="form-group comment-content-group">
                    <label for="textarea" class="form-label required">
                        <i class="fas fa-comment"></i> 评论内容
                    </label>
                    <div class="comment-editor">
                        <div class="comment-toolbar">
                            <button type="button" class="toolbar-btn" data-tag="strong" title="粗体">
                                <i class="fas fa-bold"></i>
                            </button>
                            <button type="button" class="toolbar-btn" data-tag="em" title="斜体">
                                <i class="fas fa-italic"></i>
                            </button>
                            <button type="button" class="toolbar-btn" data-tag="code" title="代码">
                                <i class="fas fa-code"></i>
                            </button>
                            <button type="button" class="toolbar-btn" data-action="link" title="链接">
                                <i class="fas fa-link"></i>
                            </button>
                            <button type="button" class="toolbar-btn" data-action="emoji" title="表情">
                                <i class="fas fa-smile"></i>
                            </button>
                            <span class="toolbar-divider"></span>
                            <span class="char-count">
                                <span id="current-count">0</span>/<span>1000</span>
                            </span>
                        </div>
                        <textarea rows="6" cols="50" name="text" id="textarea" class="form-textarea" 
                                  placeholder="写下你的评论..." required maxlength="1000"><?php $this->remember('text'); ?></textarea>
                        <div class="emoji-panel" id="emojiPanel" style="display: none;">
                            <div class="emoji-list">
                                <span class="emoji-item">😀</span><span class="emoji-item">😃</span>
                                <span class="emoji-item">😄</span><span class="emoji-item">😁</span>
                                <span class="emoji-item">😆</span><span class="emoji-item">😅</span>
                                <span class="emoji-item">😂</span><span class="emoji-item">🤣</span>
                                <span class="emoji-item">😊</span><span class="emoji-item">😇</span>
                                <span class="emoji-item">🙂</span><span class="emoji-item">🙃</span>
                                <span class="emoji-item">😉</span><span class="emoji-item">😌</span>
                                <span class="emoji-item">😍</span><span class="emoji-item">🥰</span>
                                <span class="emoji-item">😘</span><span class="emoji-item">😗</span>
                                <span class="emoji-item">😙</span><span class="emoji-item">😚</span>
                                <span class="emoji-item">😋</span><span class="emoji-item">😛</span>
                                <span class="emoji-item">😝</span><span class="emoji-item">😜</span>
                                <span class="emoji-item">🤪</span><span class="emoji-item">🤨</span>
                                <span class="emoji-item">🧐</span><span class="emoji-item">🤓</span>
                                <span class="emoji-item">😎</span><span class="emoji-item">🤩</span>
                                <span class="emoji-item">🥳</span><span class="emoji-item">😏</span>
                                <span class="emoji-item">😒</span><span class="emoji-item">😞</span>
                                <span class="emoji-item">😔</span><span class="emoji-item">😟</span>
                                <span class="emoji-item">😕</span><span class="emoji-item">🙁</span>
                                <span class="emoji-item">☹️</span><span class="emoji-item">😣</span>
                                <span class="emoji-item">😖</span><span class="emoji-item">😫</span>
                                <span class="emoji-item">😩</span><span class="emoji-item">🥺</span>
                                <span class="emoji-item">😢</span><span class="emoji-item">😭</span>
                                <span class="emoji-item">😤</span><span class="emoji-item">😠</span>
                                <span class="emoji-item">😡</span><span class="emoji-item">🤬</span>
                                <span class="emoji-item">🤯</span><span class="emoji-item">😳</span>
                                <span class="emoji-item">🥵</span><span class="emoji-item">🥶</span>
                                <span class="emoji-item">😱</span><span class="emoji-item">😨</span>
                                <span class="emoji-item">😰</span><span class="emoji-item">😥</span>
                                <span class="emoji-item">😓</span><span class="emoji-item">🤗</span>
                                <span class="emoji-item">🤔</span><span class="emoji-item">🤭</span>
                                <span class="emoji-item">🤫</span><span class="emoji-item">🤥</span>
                                <span class="emoji-item">😶</span><span class="emoji-item">😐</span>
                                <span class="emoji-item">😑</span><span class="emoji-item">😬</span>
                                <span class="emoji-item">🙄</span><span class="emoji-item">😯</span>
                                <span class="emoji-item">😦</span><span class="emoji-item">😧</span>
                                <span class="emoji-item">😮</span><span class="emoji-item">😲</span>
                                <span class="emoji-item">🥱</span><span class="emoji-item">😴</span>
                                <span class="emoji-item">🤤</span><span class="emoji-item">😪</span>
                                <span class="emoji-item">😵</span><span class="emoji-item">🤐</span>
                                <span class="emoji-item">🥴</span><span class="emoji-item">🤢</span>
                                <span class="emoji-item">🤮</span><span class="emoji-item">🤧</span>
                                <span class="emoji-item">😷</span><span class="emoji-item">🤒</span>
                                <span class="emoji-item">🤕</span><span class="emoji-item">🤑</span>
                                <span class="emoji-item">🤠</span><span class="emoji-item">😈</span>
                                <span class="emoji-item">👿</span><span class="emoji-item">👹</span>
                                <span class="emoji-item">👺</span><span class="emoji-item">🤡</span>
                                <span class="emoji-item">💩</span><span class="emoji-item">👻</span>
                                <span class="emoji-item">💀</span><span class="emoji-item">☠️</span>
                                <span class="emoji-item">👽</span><span class="emoji-item">👾</span>
                                <span class="emoji-item">🤖</span><span class="emoji-item">🎃</span>
                                <span class="emoji-item">😺</span><span class="emoji-item">😸</span>
                                <span class="emoji-item">😹</span><span class="emoji-item">😻</span>
                                <span class="emoji-item">😼</span><span class="emoji-item">😽</span>
                                <span class="emoji-item">🙀</span><span class="emoji-item">😿</span>
                                <span class="emoji-item">😾</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <div class="comment-tips">
                        <i class="fas fa-lightbulb"></i>
                        <span>支持 Markdown 语法</span>
                    </div>
                    <button type="submit" class="submit-btn" id="submitBtn">
                        <i class="fas fa-paper-plane"></i>
                        <span>发表评论</span>
                        <div class="loading-spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="comments-closed">
            <div class="comments-closed-content">
                <i class="fas fa-lock"></i>
                <h3><?php _e('评论已关闭'); ?></h3>
                <p>该文章的评论功能已被关闭</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
/* 评论区域样式 */
.comments-section {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 2px solid var(--border-color);
}

.comments-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.comments-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0;
    color: var(--text-primary);
    font-size: 1.5rem;
}

.comments-title i {
    color: var(--accent-primary);
}

.comments-stats {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.comment-count {
    background: var(--bg-secondary);
    padding: 0.5rem 1rem;
    border-radius: var(--radius-lg);
}

/* 评论列表 */
.comment-list-wrapper {
    margin-bottom: 2rem;
}

.comment-list, 
.comment-list ol {
    list-style: none;
    margin: 0;
    padding: 0;
}

.comment-list li {
    background: var(--bg-secondary);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    margin: 1rem 0;
    border-left: 4px solid var(--accent-primary);
    transition: all var(--transition-fast) ease;
    position: relative;
}

.comment-list li:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 20px var(--shadow-light);
}

.comment-list li.comment-level-odd {
    background: var(--bg-secondary);
}

.comment-list li.comment-level-even {
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
}

.comment-list li.comment-by-author {
    background: linear-gradient(135deg, rgba(0, 123, 255, 0.1), rgba(102, 16, 242, 0.1));
    border-left-color: var(--accent-secondary);
}

.comment-list li.comment-by-author::before {
    content: '作者';
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: var(--accent-secondary);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: var(--radius-sm);
    font-size: 0.75rem;
    font-weight: 600;
}

/* 子评论 */
.comment-list .comment-children {
    margin-top: 1rem;
    padding-left: 2rem;
    border-left: 2px solid var(--border-color);
}

.comment-author {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.comment-author .avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid var(--accent-primary);
    padding: 2px;
    transition: all var(--transition-fast) ease;
}

.comment-author .avatar:hover {
    transform: scale(1.1);
    border-color: var(--accent-secondary);
}

.comment-author cite {
    font-style: normal;
    color: var(--accent-primary);
}

.comment-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-bottom: 1rem;
}

.comment-meta a {
    color: inherit;
    text-decoration: none;
}

.comment-meta a:hover {
    color: var(--accent-primary);
}

.comment-meta::after {
    display: none;
}

.comment-content {
    line-height: 1.6;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.comment-content p {
    margin-bottom: 0.75rem;
}

.comment-content p:last-child {
    margin-bottom: 0;
}

.comment-reply {
    text-align: right;
}

.comment-reply a {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--accent-primary);
    color: white;
    border-radius: var(--radius-md);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all var(--transition-fast) ease;
}

.comment-reply a::after {
    display: none;
}

.comment-reply a:hover {
    background: var(--accent-secondary);
    transform: translateY(-1px);
    box-shadow: 0 4px 10px var(--shadow-medium);
}

/* 评论表单 */
.comment-form-container {
    background: var(--bg-primary);
    border-radius: var(--radius-xl);
    padding: 2rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 20px var(--shadow-light);
    margin-top: 2rem;
}

.comment-form-header {
    margin-bottom: 2rem;
    text-align: center;
}

.comment-form-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
    font-size: 1.4rem;
}

.comment-form-title i {
    color: var(--accent-primary);
}

.comment-notes {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.comment-notes .required {
    color: #e74c3c;
    font-weight: 600;
}

/* 用户信息 */
.comment-user-info.logged-in {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: var(--radius-lg);
    margin-bottom: 1.5rem;
}

.user-avatar .avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid var(--accent-primary);
}

.user-greeting {
    margin: 0 0 0.5rem;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.user-greeting i {
    color: var(--accent-primary);
}

.user-actions {
    margin: 0;
    display: flex;
    gap: 1rem;
}

.user-actions a {
    color: var(--text-secondary);
    font-size: 0.85rem;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    transition: color var(--transition-fast) ease;
}

.user-actions a::after {
    display: none;
}

.user-actions a:hover {
    color: var(--accent-primary);
}

/* 表单字段 */
.comment-form-fields {
    margin-bottom: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.9rem;
}

.form-label.required::after {
    content: "*";
    color: #e74c3c;
    margin-left: 0.25rem;
}

.form-label i {
    color: var(--accent-primary);
    font-size: 0.8rem;
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-family: inherit;
    font-size: 0.95rem;
    transition: all var(--transition-fast) ease;
    outline: none;
}

.form-input:focus,
.form-textarea:focus {
    border-color: var(--accent-primary);
    background: var(--bg-primary);
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
}

.form-input::placeholder,
.form-textarea::placeholder {
    color: var(--text-muted);
}

/* 评论编辑器 */
.comment-content-group {
    margin-bottom: 1.5rem;
}

.comment-editor {
    position: relative;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    overflow: hidden;
    transition: border-color var(--transition-fast) ease;
}

.comment-editor:focus-within {
    border-color: var(--accent-primary);
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
}

.comment-toolbar {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.75rem;
    background: var(--bg-tertiary);
    border-bottom: 1px solid var(--border-color);
}

.toolbar-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border: none;
    border-radius: var(--radius-sm);
    background: transparent;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all var(--transition-fast) ease;
}

.toolbar-btn:hover {
    background: var(--bg-secondary);
    color: var(--accent-primary);
}

.toolbar-divider {
    width: 1px;
    height: 20px;
    background: var(--border-color);
    margin: 0 0.5rem;
}

.char-count {
    margin-left: auto;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.form-textarea {
    border: none;
    border-radius: 0;
    background: var(--bg-primary);
    resize: vertical;
    min-height: 120px;
}

/* 表情面板 */
.emoji-panel {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-top: none;
    border-radius: 0 0 var(--radius-md) var(--radius-md);
    box-shadow: 0 4px 15px var(--shadow-light);
    z-index: 100;
}

.emoji-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(32px, 1fr));
    gap: 0.25rem;
    padding: 1rem;
    max-height: 200px;
    overflow-y: auto;
}

.emoji-item {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: var(--radius-sm);
    cursor: pointer;
    font-size: 1.2rem;
    transition: all var(--transition-fast) ease;
}

.emoji-item:hover {
    background: var(--bg-secondary);
    transform: scale(1.2);
}

/* 表单操作 */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.5rem;
}

.comment-tips {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-muted);
    font-size: 0.85rem;
}

.comment-tips i {
    color: var(--accent-primary);
}

.submit-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 2rem;
    background: var(--gradient-primary);
    border: none;
    border-radius: var(--radius-md);
    color: white;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all var(--transition-fast) ease;
    position: relative;
    overflow: hidden;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px var(--shadow-medium);
}

.submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.loading-spinner {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: inherit;
}

/* 评论关闭 */
.comments-closed {
    text-align: center;
    padding: 3rem 1rem;
}

.comments-closed-content {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
}

.comments-closed i {
    font-size: 3rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
}

.comments-closed h3 {
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.comments-closed p {
    color: var(--text-muted);
    margin: 0;
}

/* 取消回复 */
.cancel-comment-reply {
    text-align: right;
    margin-bottom: 1rem;
}

.cancel-comment-reply a {
    color: var(--text-muted);
    font-size: 0.85rem;
    text-decoration: none;
    padding: 0.5rem 1rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    transition: all var(--transition-fast) ease;
}

.cancel-comment-reply a::after {
    display: none;
}

.cancel-comment-reply a:hover {
    color: var(--accent-primary);
    background: var(--bg-tertiary);
}

/* 响应式 */
@media (max-width: 767px) {
    .comments-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .comment-form-container {
        padding: 1.5rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .submit-btn {
        justify-content: center;
    }
    
    .comment-list li {
        padding: 1rem;
    }
    
    .comment-list .comment-children {
        padding-left: 1rem;
    }
    
    .comment-user-info.logged-in {
        flex-direction: column;
        text-align: center;
    }
    
    .user-actions {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .emoji-list {
        grid-template-columns: repeat(8, 1fr);
    }
    
    .toolbar-btn {
        width: 28px;
        height: 28px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 评论字数统计
    const textarea = document.getElementById('textarea');
    const currentCount = document.getElementById('current-count');
    
    if (textarea && currentCount) {
        textarea.addEventListener('input', function() {
            const count = this.value.length;
            currentCount.textContent = count;
            
            if (count > 800) {
                currentCount.style.color = 'var(--accent-secondary)';
            } else {
                currentCount.style.color = 'var(--text-muted)';
            }
        });
    }
    
    // 工具栏功能
    const toolbarBtns = document.querySelectorAll('.toolbar-btn');
    
    toolbarBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.dataset.action;
            const tag = this.dataset.tag;
            
            if (tag) {
                insertTag(tag);
            } else if (action === 'link') {
                insertLink();
            } else if (action === 'emoji') {
                toggleEmojiPanel();
            }
        });
    });
    
    // 插入标签
    function insertTag(tag) {
        const textarea = document.getElementById('textarea');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selectedText = textarea.value.substring(start, end);
        const beforeText = textarea.value.substring(0, start);
        const afterText = textarea.value.substring(end);
        
        let insertText;
        if (selectedText) {
            insertText = `<${tag}>${selectedText}</${tag}>`;
        } else {
            insertText = `<${tag}></${tag}>`;
        }
        
        textarea.value = beforeText + insertText + afterText;
        
        // 设置光标位置
        const newPos = start + insertText.length - (selectedText ? 0 : `</${tag}>`.length);
        textarea.setSelectionRange(newPos, newPos);
        textarea.focus();
        
        // 触发输入事件更新字数统计
        textarea.dispatchEvent(new Event('input'));
    }
    
    // 插入链接
    function insertLink() {
        const url = prompt('请输入链接地址:');
        if (url) {
            const text = prompt('请输入链接文字:') || url;
            const linkText = `<a href="${url}">${text}</a>`;
            insertTextAtCursor(linkText);
        }
    }
    
    // 在光标位置插入文本
    function insertTextAtCursor(text) {
        const textarea = document.getElementById('textarea');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const beforeText = textarea.value.substring(0, start);
        const afterText = textarea.value.substring(end);
        
        textarea.value = beforeText + text + afterText;
        textarea.setSelectionRange(start + text.length, start + text.length);
        textarea.focus();
        textarea.dispatchEvent(new Event('input'));
    }
    
    // 切换表情面板
    function toggleEmojiPanel() {
        const panel = document.getElementById('emojiPanel');
        if (panel.style.display === 'none' || !panel.style.display) {
            panel.style.display = 'block';
        } else {
            panel.style.display = 'none';
        }
    }
    
    // 表情选择
    const emojiItems = document.querySelectorAll('.emoji-item');
    emojiItems.forEach(item => {
        item.addEventListener('click', function() {
            insertTextAtCursor(this.textContent);
            document.getElementById('emojiPanel').style.display = 'none';
        });
    });
    
    // 点击外部关闭表情面板
    document.addEventListener('click', function(e) {
        const emojiPanel = document.getElementById('emojiPanel');
        const emojiBtn = document.querySelector('[data-action="emoji"]');
        
        if (emojiPanel && !emojiPanel.contains(e.target) && !emojiBtn.contains(e.target)) {
            emojiPanel.style.display = 'none';
        }
    });
    
    // 表单提交增强
    const commentForm = document.getElementById('comment-form');
    const submitBtn = document.getElementById('submitBtn');
    
    if (commentForm && submitBtn) {
        commentForm.addEventListener('submit', function() {
            const btnText = submitBtn.querySelector('span');
            const spinner = submitBtn.querySelector('.loading-spinner');
            
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            spinner.style.display = 'flex';
        });
    }
    
    // 评论回复功能增强
    const replyLinks = document.querySelectorAll('.comment-reply a');
    replyLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // 滚动到评论表单
            setTimeout(() => {
                document.querySelector('.comment-form-container').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }, 100);
        });
    });
});
</script>
