<?php

/**
 * Plugin Name: SuperHeroes
 * Description: Plugin that gives you information about superheros
 * Version: 1.0.0
 * Author: Cristian Botache
 * Text Domain: superheroes
 */

function superheroes($atts)
{
  extract(shortcode_atts(array("id" => ''), $atts));
  if($id==NULL){
    return '<p>Ingrese el id</p>';
  }else{
    $cu = curl_init();
    curl_setopt($cu, CURLOPT_URL, "https://www.superheroapi.com/api.php/4773278086090723/" . $id);
    curl_setopt($cu, CURLOPT_RETURNTRANSFER, TRUE);
    $res = curl_exec($cu);
    if($res){
      curl_close($cu);
      $resultado = json_decode($res, TRUE);
      $card = '
          <head>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
          </head>
          <body>
            <div class="container">
              <div class="col-12">
                <div class="card border-dark mb-3" style="width: 18rem;">
                    <img class="card-img-top" src="'.$resultado['image']['url'].'" alt="Card image cap">
                    <div class="card-body">
                      <h3 class="card-title text-center">'.$resultado['name'].'</h3>
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item text-danger">Power: '.$resultado['powerstats']['power'].'</li>
                      <li class="list-group-item text-warning">Speed: '.$resultado['powerstats']['speed'].'</li>
                      <li class="list-group-item text-info">Combat: '.$resultado['powerstats']['combat'].'</li>
                    </ul>
                    <div class="card-body">
                      <p class="card-text">'.$resultado['biography']['full-name'].'</p>
                      <p class="card-text">'.$resultado['work']['occupation'].'</p>
                      <p class="card-text">'.$resultado['connections']['group-affiliation'].'</p>
                      <p class="card-text">'.$resultado['biography']['publisher'].'</p>
                    </div>
                </div>
              </div>
            </div>
          </body> 
        ';
      return $card;

      }else{
        return '<p>Ocurrió un error</p>';
      }
    }
}

add_shortcode('hero', 'superheroes');
