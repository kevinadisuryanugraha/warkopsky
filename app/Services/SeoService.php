<?php

namespace App\Services;

class SeoService
{
    protected string $title;
    protected string $description;
    protected string $url;
    protected string $image;
    protected string $type;

    public function __construct()
    {
        $this->title       = config('app.seo_title', config('app.name'));
        $this->description = config('app.seo_description', '');
        $this->url         = url()->current();
        $this->image       = asset('images/og-default.jpg');
        $this->type        = 'website';
    }

    public function set(array $data): static
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    public function toArray(): array
    {
        return [
            'title'       => $this->title . ' | Warkop Sky',
            'description' => $this->description,
            'url'         => $this->url,
            'image'       => $this->image,
            'type'        => $this->type,
        ];
    }
}
