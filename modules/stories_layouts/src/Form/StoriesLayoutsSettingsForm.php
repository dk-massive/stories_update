<?php

namespace Drupal\stories_layouts\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * TODO: class docs.
 */
class StoriesLayoutsSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'stories_layouts_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);

    $config = $this->config('stories_layouts.settings');

    $form['layout_options'] = [
      '#type' => 'checkboxes',
      '#title' => t('Configurable options on Layouts'),
      '#options' => [
        'background' => $this->t('Background'),
        'spacing' => $this->t('Spacing'),
        'h_rules' => $this->t('Horizontal Rules'),
      ],
      '#default_value' => $config->get('layout_options'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $config = $this->config('stories_layouts.settings');

    if ($form_state->hasValue('layout_options')) {
      $config->set('layout_options', $form_state->getValue('layout_options'));
    }

    $config->save();
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['stories_layouts.settings'];
  }

}
