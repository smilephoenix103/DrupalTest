<?php

namespace Drupal\first_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use \GuzzleHttp\Client;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Hello block"),
 *   category = @Translation("Hello World"),
 * )
 */
class HelloBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $url = 'http://api.weatherapi.com/v1/current.json?key=b1199e3b8c6e4fbd8f5152109221207&q=Lublin&aqi=no';
    $client = new Client();
    $res = json_decode($client->request('GET', $url)->getBody());
    return [
      "#markup"=> $this->t($res->location->country.":".$res->current->temp_c."'C"),
    ];
  }

}
