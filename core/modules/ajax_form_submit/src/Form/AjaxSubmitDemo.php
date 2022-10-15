<?php

namespace Drupal\ajax_form_submit\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use \GuzzleHttp\Client;

/**
 * Implementing a ajax form.
 */
class AjaxSubmitDemo extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ajax_submit_demo';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['message'] = [
      '#type' => 'markup',
      '#markup' => '<div class="result_message"></div>',
    ];

    $form['number_1'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Region'),
    ];

    // $form['number_2'] = [
    //   '#type' => 'textfield',
    //   '#title' => $this->t('Number 2'),
    // ];

    $form['actions'] = [
      '#type' => 'button',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::setMessage',
      ],
    ];

    return $form;
  }

  /**
   * Setting the message in our form.
   */
  public function setMessage(array $form, FormStateInterface $form_state) {

    $url = 'http://api.weatherapi.com/v1/current.json?key=b1199e3b8c6e4fbd8f5152109221207&q='.$form_state->getValue('number_1').'&aqi=no';
    $client = new Client();
    $res = json_decode($client->request('GET', $url)->getBody());

      $response = new AjaxResponse();
      $response->addCommand(
        new HtmlCommand(
          '.result_message',
          '<div class="my_top_message">'
          .'<div><span style="font-weight:bold">'.$res->error->message.'</span></div>'
          .'<div>Time : <span style="font-weight:bold">'.$res->location->localtime.'</span></div>'
          .'<div>Country : <span style="font-weight:bold">'.$res->location->country.'</span></div>'
          .'<div>Region : <span style="font-weight:bold">'.$res->location->name.'</span></div>'
          .'<div style="display:flex; align-items: center"><span style="font-size: 1.875em; font-weight:bold">'.$res->current->condition->text.'</span><span><img src="https:'.$res->current->condition->icon.'" alt="icon" width="200px" height="200px"></span></div>'
          .'<div>Temperature(`C) : <span style="font-weight:bold">'.$res->current->temp_c.' `C</span> </div>'
          .'<div>Temperature(`F) : <span style="font-weight:bold">'.$res->current->temp_f.' `F</span></div>'
          .'<div>Humidity : <span>'.$res->current->humidity.'</span></div>'
          .'<div>'
        )
      );
      return $response;
  }

  /**
   * Submitting the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

}
