<?php
$config = include 'conf-base.php';

return array_merge($config,
    [
        'app.siteName' => \MapasCulturais\i::__('Mapa Cultural de Braganca Paulista'),
        'app.siteDescription' => \MapasCulturais\i::__('Perguntar depois'),

        /* configure e descomente as linhas abaixo para habilitar um tema personalizado */
        'namespaces' => array_merge( $config['namespaces'], ['BaseV1' => THEMES_PATH'BaseV1']),
         'themes.active' => 'BaseV1',

	/* to setup Saas Subsite theme */
'namespaces' => array(
  'MapasCulturais\Themes' => THEMES_PATH,
  'BaseMinc' => THEMES_PATH . '/mapasculturais-baseminc/', // Tema padrão que será utilizado quando não for acessada nenhuma instalação SaaS
  'Subsite' => THEMES_PATH . '/Subsite/', //Tema do SaaS que utilizará as informações cadastradas via entidade SubSite
  $theme_namespace => $theme_path
  ),

        'themes.assetManager' => new \MapasCulturais\AssetManagers\FileSystem([
            'publishPath' => BASE_PATH . 'assets/',

            'mergeScripts' => true,
            'mergeStyles' => true,

            'process.js' => 'uglifyjs {IN} -o {OUT} --source-map {OUT}.map --source-map-include-sources --source-map-url /assets/{FILENAME}.map -b -p ' . substr_count(BASE_PATH, '/'),
            'process.css' => 'uglifycss {IN} > {OUT} ',
            'publishFolderCommand' => 'cp -R {IN} {PUBLISH_PATH}{FILENAME}'
        ]),

        // development, staging, production
        'app.mode' => 'production',

        'doctrine.isDev' => false,
        'slim.debug' => false,
        'maps.includeGoogleLayers' => true,
	 'app.useAssetsUrlCache' => false,

        'app.geoDivisionsHierarchy' => [
            'pais'              => ['name' => \MapasCulturais\i::__('País'),            'showLayer' => true],
            'regiao'            => ['name' => \MapasCulturais\i::__('Região'),          'showLayer' => true],
            'estado'            => ['name' => \MapasCulturais\i::__('Estado'),          'showLayer' => true],
            'mesorregiao'       => ['name' => \MapasCulturais\i::__('Mesorregião'),     'showLayer' => true],
            'microrregiao'      => ['name' => \MapasCulturais\i::__('Microrregião'),    'showLayer' => true],
            'municipio'         => ['name' => \MapasCulturais\i::__('Município'),       'showLayer' => true],
            'zona'              => ['name' => \MapasCulturais\i::__('Zona'),            'showLayer' => true],
            'subprefeitura'     => ['name' => \MapasCulturais\i::__('Subprefeitura'),   'showLayer' => true],
            'distrito'          => ['name' => \MapasCulturais\i::__('Distrito'),        'showLayer' => true],
            'setor_censitario'  => ['name' => \MapasCulturais\i::__('Setor Censitario'),'showLayer' => false]
        ],
        // latitude, longitude
        'maps.center' => [-22.976929, -46.532852],

        // zoom do mapa
        'maps.zoom.default' => 12,

        'plugins.enabled' => array('endereco', 'notifications', 'em-cartaz'),
'plugins' => array(
  'ProjectPhases' => ['namespace' => 'ProjectPhases'],
     'AgendaSingles' => ['namespace' => 'AgendaSingles'],
     'OriginSite' => [
        'namespace' => 'OriginSite',
        'config'    => ['siteId' => 'https://mapaculturalbraganca.sp.gov.br']
     ]
  'SubsiteDomainSufix' => [
    'namespace' => 'SubsiteDomainSufix',
    'config' => [
      'sufix' => function () {
        return 'domain-sufix.sp.gov.br';
      }
    ]
  ]
	'plugins' => [
    // ... outros plugins
    'MultipleLocalAuth' => [
        'namespace' => 'MultipleLocalAuth',
	    'auth.provider' => '\MultipleLocalAuth\Provider',
    ],
],
)	
),
	    
	    'module.CompliantSuggestion' => [
    'compliant' => true,
    'suggestion' => true
],
,
	    
        'auth.provider' => 'Fake',

        // Token da API de Cep
        // Adquirido ao fazer cadastro em http://www.cepaberto.com/
         'cep.token' => '[66a50c5065b209ef5d3aaa1bb57c5668]',

        /* Modelo de configuração para usar o id da cultura */
//        'auth.provider' => 'OpauthOpenId',
//        'auth.config' => [
//            'login_url' => '',
//            'logout_url' => '',
//            'salt' => '',
//            'timeout' => '24 hours'
//        ],

//Modelo de autenticação para Login Cidadão
//        'auth.provider' => 'OpauthLoginCidadao',
//        'auth.config' => array(
//        'client_id' => '',
//        'client_secret' => '',
//        'auth_endpoint' => 'https://[SUA-URL]/openid/connect/authorize',
//        'token_endpoint' => 'https://[SUA-URL]/openid/connect/token',
//        'user_info_endpoint' => 'https://[SUA-URL]/api/v1/person.json'
//        ),

        'doctrine.database' => [
            'dbname'    => 'mapas',
            'user'      => 'mapas',
            'host'      => '',
        ],
    ]
    app.useAssetsUrlCache => true,
);
