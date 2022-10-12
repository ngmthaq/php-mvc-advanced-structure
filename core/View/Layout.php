<?php

namespace Core\View;

final class Layout
{
    public string $name;
    public string $html;
    public array $sections;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->sections = [];
        $this->html = "";
    }

    final public function start()
    {
        ob_start();
    }

    final public function end()
    {
        $__contents = ob_get_contents();
        $__contents = htmlspecialchars($__contents);
        $this->html = $__contents;
        ob_end_clean();

    }

    final public function main()
    {
        $this->sections["main"] = "";
        echo htmlspecialchars("{{%%__ main __%%}}");
    }

    final public function section(string $__sectionName)
    {
        $this->sections[$__sectionName] = "";
        echo htmlspecialchars("{{%%__ $__sectionName __%%}}");
    }

    final public function slot(string $__sectionName, string $__contents = "")
    {
        ob_start();

        if ($__contents !== "") {
            $this->sections[$__sectionName] = htmlspecialchars($__contents);
            ob_end_clean();
        }
    }

    final public function endSlot(string $__sectionName)
    {
        $__contents = ob_get_contents();
        $this->sections[$__sectionName] = htmlspecialchars($__contents);
        ob_end_clean();
    }

    final public function render()
    {
        foreach ($this->sections as $__key => $__value) {
            $this->html = str_replace(htmlspecialchars("{{%%__ $__key __%%}}"), $__value, $this->html);
        }

        echo htmlspecialchars_decode($this->html);
    }

    final public function dump()
    {
        dd($this);
    }
}
