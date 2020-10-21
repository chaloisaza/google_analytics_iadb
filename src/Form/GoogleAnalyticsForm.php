<?php

namespace Drupal\google_analytics_iadb\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure google_analytics_iadb settings for this site.
 */
class GoogleAnalyticsForm extends ConfigFormBase {

  const GOOGLE_ANALYTICS_SETTINGS = 'google_analytics_iadb.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'google_analytics_iadb_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [GOOGLE_ANALYTICS_SETTINGS];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(GOOGLE_ANALYTICS_SETTINGS);

    $form['google_analytics_production_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Google Analytics Production Code'),
      '#description' => $this->t('Add your Google Analytics code for production environment'),
      '#value' => '',
      '#placeholder' => 'UA-'
    ];

    $form['google_analytics_test_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Google Analytics Test Code'),
      '#description' => $this->t('Add your Google Analytics code for non production environments'),
      '#default_value' => $config->get('test'),
      '#placeholder' => 'UA-XXXXXXX-X',
      '#disabled' => 'disabled',
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $config = $this->config(GOOGLE_ANALYTICS_SETTINGS);
    $config
      // Set the submitted configuration setting.
      ->set('production', $form_state->getValue('google_analytics_production_code'))
      ->set('test', $form_state->getValue('google_analytics_test_code'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
