<?php

/**
 * 站点元信息管理类
 * 用于存储和生成站点描述文本
 */
class SiteMetaManager
{
    /**
     * 站点配置数据
     *
     * @var array
     */
    private array $config;

    /**
     * 构造函数，初始化站点元信息
     *
     * @param string $siteUrl 站点 URL
     * @param string $siteName 站点名称
     * @param string $keywords 关键词
     */
    public function __construct(
        string $siteUrl = 'https://cnpage-leyu.com.cn',
        string $siteName = '乐鱼体育',
        string $keywords = '乐鱼体育'
    ) {
        $this->config = [
            'url'         => $siteUrl,
            'name'        => $siteName,
            'keywords'    => $keywords,
            'description' => '',
            'author'      => '',
            'version'     => '1.0.0',
        ];
    }

    /**
     * 设置站点描述
     *
     * @param string $description 描述文本
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->config['description'] = $description;
        return $this;
    }

    /**
     * 设置站点作者
     *
     * @param string $author 作者名称
     * @return self
     */
    public function setAuthor(string $author): self
    {
        $this->config['author'] = $author;
        return $this;
    }

    /**
     * 获取站点名称
     *
     * @return string
     */
    public function getSiteName(): string
    {
        return $this->config['name'];
    }

    /**
     * 获取站点 URL
     *
     * @return string
     */
    public function getSiteUrl(): string
    {
        return $this->config['url'];
    }

    /**
     * 生成站点简短描述文本
     *
     * 根据当前配置生成一段简短的描述，用于页面标题、摘要等场景。
     *
     * @param bool $includeUrl 是否包含站点 URL
     * @return string 生成的描述文本
     */
    public function generateShortDescription(bool $includeUrl = false): string
    {
        $parts = [];

        $parts[] = $this->config['name'];

        if (!empty($this->config['keywords'])) {
            $parts[] = $this->config['keywords'];
        }

        if (!empty($this->config['description'])) {
            $parts[] = $this->config['description'];
        }

        $description = implode(' - ', $parts);

        if ($includeUrl && !empty($this->config['url'])) {
            $description .= ' | ' . $this->config['url'];
        }

        return htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    }

    /**
     * 生成完整的元信息数组
     *
     * @return array
     */
    public function getMetaArray(): array
    {
        return [
            'title'       => $this->generateShortDescription(),
            'description' => $this->generateShortDescription(true),
            'keywords'    => $this->config['keywords'],
            'author'      => $this->config['author'],
            'url'         => $this->config['url'],
        ];
    }

    /**
     * 以 JSON 格式输出元信息
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->getMetaArray(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

// 示例用法
$manager = new SiteMetaManager();

$manager->setDescription('提供最新体育资讯与赛事报道')
        ->setAuthor('乐鱼体育团队');

$meta = $manager->getMetaArray();

echo "站点名称: " . $manager->getSiteName() . "\n";
echo "站点URL: " . $manager->getSiteUrl() . "\n";
echo "简短描述: " . $manager->generateShortDescription() . "\n";
echo "完整描述: " . $manager->generateShortDescription(true) . "\n";
echo "JSON输出:\n" . $manager->toJson() . "\n";