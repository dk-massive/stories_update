<?php

namespace Drupal\stories_layouts\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginFormInterface;
use Drupal\Core\Layout\LayoutDefault;

/**
 * Configurable two column layout plugin class.
 *
 * @internal
 *   Plugin classes are internal.
 */
class LayoutBase extends LayoutDefault implements PluginFormInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $background_colors = array_keys($this->getBackgroundColors());
    $spacing = array_keys($this->getSpacingOptions());
    $rule = array_keys($this->getRuleOptions());
    $column_size = array_keys($this->getColumnOptions());

    return parent::defaultConfiguration() + [
      'background_color' => array_shift($background_colors),
      'spacing' => array_shift($spacing),
      'rule' => array_shift($rule),
      'column_size' => array_shift($column_size),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $stories_layouts_config = \Drupal::config('stories_layouts.settings');
    $layout_options = $stories_layouts_config->get('layout_options');
    $configuration = $this->getConfiguration();

    if($layout_options['background']) {
      $form['background_color'] = [
        '#type' => 'select',
        '#title' => $this->t('Background Color'),
        '#default_value' => $configuration['background_color'],
        '#options' => $this->getBackgroundColors(),
      ];
    }

    if($layout_options['spacing']) {
      $form['spacing'] = [
        '#type' => 'select',
        '#title' => $this->t('Spacing'),
        '#default_value' => $configuration['spacing'],
        '#options' => $this->getSpacingOptions(),
      ];
    }

    if($layout_options['h_rules']) {
      $form['h_rules'] = [
        '#type' => 'select',
        '#title' => $this->t('Horizontal Rule'),
        '#default_value' => $configuration['h_rules'],
        '#options' => $this->getRuleOptions(),
      ];
    }

    $form['column_size'] = [
      '#type' => 'select',
      '#title' => $this->t('Column Size'),
      '#default_value' => $configuration['column_size'],
      '#options' => $this->getColumnOptions(),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);
    $this->configuration['background_color'] = $form_state->getValue('background_color');
    $this->configuration['spacing'] = $form_state->getValue('spacing');
    $this->configuration['rule'] = $form_state->getValue('rule');
    $this->configuration['column_size'] = $form_state->getValue('column_size');
  }

  /**
   * {@inheritdoc}
   */
  protected function getBackgroundColors() {
    return [
      'white' => 'White',
      'glass_brick' => 'Glass Brick'
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function getSpacingOptions() {
    return [
      'normal' => $this->t('Normal'),
      'large' => $this->t('Large'),
      'none' => $this->t('None'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function getColumnOptions() {
    return [
      'normal' => $this->t('Normal'),
      'narrow' => $this->t('Narrow'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function getRuleOptions() {
    return [
      'none' => $this->t('None'),
      'above' => $this->t('Above'),
      'below' => $this->t('Below'),
      'both' => $this->t('Above & Below'),
    ];
  }

}
