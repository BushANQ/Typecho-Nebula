# Nebula for Typecho
## 施工阶段。目前还有许多未完善的部分

Nebula 是一款为 Typecho 博客系统的现代化响应式主题。适合个人博客、技术分享、生活记录等多种场景。

---
效果图
![1](./1.png)
![2](./2.png)

## 目录结构

```
Nebula/
├── 404.php                # 404 页面模板
├── archive.php            # 归档页面模板
├── comments.php           # 评论模板
├── footer.php             # 页脚模板
├── functions.php          # 主题函数与扩展
├── grid.css               # 栅格系统样式
├── header.php             # 页头模板
├── img/                   # 图片资源
│   ├── icon-search.png
│   └── icon-search@2x.png
├── index.php              # 首页模板
├── normalize.css          # CSS 重置
├── page.php               # 单页模板
├── post.php               # 文章页模板
├── screenshot.png         # 主题预览图
├── sidebar.php            # 侧边栏模板及样式
├── style.css              # 主题主样式
```


## 自定义开发

- **样式自定义**：主要样式在 `style.css` 和 `grid.css`，可根据需求调整配色、圆角、阴影等。
- **模板扩展**：各页面模板结构清晰，便于添加自定义内容。
- **小组件开发**：可参考 `sidebar.php`，按需添加或修改侧边栏小工具。
- **变量与函数**：主题内大量使用 Typecho 原生 API，便于与插件协作。

---

## 常见问题

1. **主题激活后页面样式错乱？**
   - 请确保 `style.css`、`grid.css`、`normalize.css` 等样式文件已完整上传。
   - 检查浏览器控制台是否有 404 或跨域错误。

2. **社交图标不显示？**
   - 请确认 Font Awesome 已正确引入（主题已内置或通过 CDN）。
   - 图标类名需符合 Font Awesome 规范，如 `fab fa-github`。

3. **如何添加自定义小组件？**
   - 可在 `sidebar.php` 中仿照现有结构添加自定义 PHP 代码或 HTML。

4. **标签云颜色如何自定义？**
   - 可在 `sidebar.php` 的 `<script>` 部分修改 `colors` 数组，添加或替换颜色值。

---


## 许可协议

本主题遵循 GPL-3.0 License，允许自由使用、修改和分发，但请保留原作者信息。

---

## 致谢

- [Typecho](https://typecho.org/) 博客系统
- [Font Awesome](https://fontawesome.com/) 图标库
- 以及所有开源社区的贡献者
