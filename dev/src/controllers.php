<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage')
;

//$app->get('/connexion', function () use ($app) {
//    return $app['twig']->render('connexion.html.twig', array());
//})
//->bind('connexion')
//;

//$app->get('/compte/collecteur', function () use ($app) {
//    return $app['twig']->render('comptecollecteur.html.twig', array());
//})
//->bind('comptecollecteur')
//;

//chemins pour la page compte admin
$app
    ->match('/compte/admin','lieutraitement.controller:listAction') 
    ->bind('compteadmin')
;
//Routes des actions
$app
   ->match('/compte/client', 'client.controller:listAction')
   ->bind('compteclient')
;

$app
    ->match('/formulaire/ajout/collecteur/{id}','collector.controller:registerAction')
    ->value('id', null)
    ->bind('registercollector')
;

$app
    ->match('/formulaire/ajout/client/{id}','client.controller:registerAction')
    ->value('id', null)
    ->bind('registerclient')
;

$app
    ->match('/formulaire/ajout/lieutraitement/{id}','lieutraitement.controller:registerAction')
    ->value('id', null)
    ->bind('registerlieutraitement')
;

$app
    ->match('/formulaire/ajout/traitementcollecteur','traitementcollector.controller:registerAction')
    ->value('id', null)
    ->bind('registertraitementcollector')
;

$app
    ->match('/formulaire/ajout/lieucollecte/{id}','lieucollecte.controller:registerAction')
    ->value('id', null)
    ->bind('registerlieucollecte')
;

$app
    ->match('/formulaire/collecte','collecte.controller:registerAction')
    ->value('id', null)
    ->bind('registercollecte')
;

$app
    ->match('/formulaire/sortiecompost','outputcompost.controller:registerAction')
    ->value('id', null)
    ->bind('registeroutputcompost')
;

$app
    ->match('/connexion','connexion.controller:loginAction')
    ->bind('connexion')
;

$app
    ->match('/deconnexion','connexion.controller:logoutAction') 
    ->bind('deconnexion')
;

$app
    ->match('/compte/collecteur','collector.controller:listAction') 
    ->bind('comptecollecteur')
;


$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
