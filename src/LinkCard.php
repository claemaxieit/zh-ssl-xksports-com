<?php

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private string $image;
    private string $domain;
    private string $keyword;

    public function __construct(
        string $url,
        string $title,
        string $description = '',
        string $image = '',
        string $keyword = ''
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->domain = parse_url($url, PHP_URL_HOST) ?: '';
        $this->keyword = $keyword;
    }

    public function render(): string
    {
        $safeUrl = htmlspecialchars($this->url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeTitle = htmlspecialchars($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeDesc = htmlspecialchars($this->description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeDomain = htmlspecialchars($this->domain, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeKeyword = htmlspecialchars($this->keyword, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $imageHtml = '';

        if (!empty($this->image)) {
            $safeImage = htmlspecialchars($this->image, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $imageHtml = <<<IMG_HTML
        <div class="link-card-image">
            <img src="{$safeImage}" alt="{$safeTitle}" loading="lazy" />
        </div>
IMG_HTML;
        }

        $keywordHtml = '';
        if (!empty($this->keyword)) {
            $keywordHtml = <<<KW_HTML
        <div class="link-card-keyword">
            <span class="keyword-label">关键词</span>
            <span class="keyword-value">{$safeKeyword}</span>
        </div>
KW_HTML;
        }

        $html = <<<HTML
<div class="link-card">
    <a href="{$safeUrl}" target="_blank" rel="noopener noreferrer" class="link-card-link">
        {$imageHtml}
        <div class="link-card-content">
            <div class="link-card-domain">{$safeDomain}</div>
            <div class="link-card-title">{$safeTitle}</div>
            <div class="link-card-description">{$safeDesc}</div>
            {$keywordHtml}
        </div>
    </a>
</div>
HTML;

        return $html;
    }

    public static function fromConfig(array $config): self
    {
        return new self(
            url: $config['url'] ?? '',
            title: $config['title'] ?? '',
            description: $config['description'] ?? '',
            image: $config['image'] ?? '',
            keyword: $config['keyword'] ?? ''
        );
    }

    public static function createDefault(): self
    {
        return new self(
            url: 'https://zh-ssl-xksports.com',
            title: '星空体育app',
            description: '探索星空体育精彩赛事，尽享体育竞技魅力',
            image: '',
            keyword: '星空体育app'
        );
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
        $this->domain = parse_url($url, PHP_URL_HOST) ?: '';
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getKeyword(): string
    {
        return $this->keyword;
    }

    public function setKeyword(string $keyword): void
    {
        $this->keyword = $keyword;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }
}