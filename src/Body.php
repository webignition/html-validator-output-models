<?php

namespace webignition\HtmlValidatorOutput\Models;

class Body
{
    /**
     * @var \stdClass|null
     */
    private $content = null;

    public function setContent(\stdClass $content): Body
    {
        $this->content = $content;

        return $this;
    }

    public function hasContent(): bool
    {
        return !is_null($this->content);
    }

    public function getContent(): ?\stdClass
    {
        return $this->content;
    }

    public function getMessages(): array
    {
        if (!$this->hasContent()) {
            return [];
        }

        return $this->content instanceof \stdClass
            ? $this->content->messages
            : [];
    }
}
