<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace TYPO3\CMS\ContentBlocks\FieldType;

/**
 * @internal Not part of TYPO3's public API.
 */
#[FieldType(name: 'Number', tcaType: 'number')]
final class NumberFieldType extends AbstractFieldType
{
    use WithCommonProperties;
    use WithNullableProperty;
    private bool $readOnly = false;
    private int $size = 0;
    private bool $required = false;
    private string $mode = '';
    private string $placeholder = '';
    private array $valuePicker = [];
    private ?bool $autocomplete = null;
    private array $range = [];
    private array $slider = [];
    private string $format = '';

    public function createFromArray(array $settings): NumberFieldType
    {
        $self = clone $this;
        $self->setCommonProperties($settings);
        $self->format = (string)($settings['format'] ?? $self->format);
        $defaultCastAsType = $self->format === 'decimal' ? 'float' : 'int';
        $self->setNullableAndDefault($settings, $defaultCastAsType);
        $self->readOnly = (bool)($settings['readOnly'] ?? $self->readOnly);
        $self->size = (int)($settings['size'] ?? $self->size);
        $self->required = (bool)($settings['required'] ?? $self->required);
        $self->mode = (string)($settings['mode'] ?? $self->mode);
        $self->placeholder = (string)($settings['placeholder'] ?? $self->placeholder);
        $self->valuePicker = (array)($settings['valuePicker'] ?? $self->valuePicker);
        if (isset($settings['autocomplete'])) {
            $self->autocomplete = (bool)$settings['autocomplete'];
        }
        $self->range = (array)($settings['range'] ?? $self->range);
        $self->slider = (array)($settings['slider'] ?? $self->slider);

        return $self;
    }



    public function getTca(): array
    {
        $tca = $this->toTca();
        $config['type'] = $this->getTcaType();
        if ($this->size !== 0) {
            $config['size'] = $this->size;
        }
        if ($this->default !== '') {
            $config['default'] = $this->default;
        }
        if ($this->readOnly) {
            $config['readOnly'] = true;
        }
        if ($this->nullable) {
            $config['nullable'] = true;
        }
        if ($this->mode !== '') {
            $config['mode'] = $this->mode;
        }
        if ($this->placeholder !== '') {
            $config['placeholder'] = $this->placeholder;
        }
        if ($this->required) {
            $config['required'] = true;
        }
        if (isset($this->autocomplete)) {
            $config['autocomplete'] = $this->autocomplete;
        }
        if (($this->valuePicker['items'] ?? []) !== []) {
            $config['valuePicker'] = $this->valuePicker;
        }
        if ($this->range !== []) {
            $config['range'] = $this->range;
        }
        if ($this->slider !== []) {
            $config['slider'] = $this->slider;
        }
        if ($this->format !== '') {
            $config['format'] = $this->format;
        }
        $tca['config'] = array_replace($tca['config'] ?? [], $config);
        return $tca;
    }
}
