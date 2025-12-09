GAR API SDK
===========

GAR is a French government SSO mostly used for colleges and high schools.
This SDK provide an abstraction layer for PHP integration.

Current GAR version supported : 6.1 - June 2022

Install
=======

Run 

    composer req ludicat/api-gar

You'll need a PSR-18 http api package, there is an embedded GuzzleAdapter.
If you want to create yours, just extends Ludicat\ApiGar\Adapter\AbstractAbonnementWs

    composer req php-http/guzzle7-adapter

Quick start
===========

We assume you already applied to the GAR service and for a certified pem key.
(remember to provide them with your app "notice")

First, create a client :

    $serviceProvider = new \Ludicat\ApiGar\Model\ServiceProvider(
        '123456789', // Your company siret
        \Ludicat\ApiGar\Model\ServiceProvider::ISNI_NONE, // ISNI number or none constant
        'ark:/12345/myRessource' // Your resource ID
    );
    // Could be another adapter
    $adapter = new \Ludicat\ApiGar\Adapter\GuzzleAdapter(
        __DIR__.'/config/cert/app.pem', // Pem key (certified by government)
        __DIR__.'/config/cert/app.key', // Private key
        __DIR__.'/config/cert/harica.crt', // Harica cert
        'Accordeon' // Private key pass,
        Ludicat\ApiGar\Adapter\AbonnementWsInterface::ENDPOINT_DEV // Default one
        // Ludicat\ApiGar\Adapter\AbonnementWsInterface::ENDPOINT_PROD // Once you're ready for production, please use this constant instead.
    );
    $client = new \Ludicat\ApiGar\Client($adapter, $serviceProvider);
    
Then you can call for any method : 

    // Create / retrieve the Abonnement object, you can pass the $serviceProvider for default values preset (recommanded)
    $abonnement = new \Ludicat\ApiGar\Model\Abonnement($serviceProvider);
    $abonnement
        ->setCommentaireAbonnement('Ceci est un test')
        ->setDebutValidite((new \DateTime())->format('Y-m-d\T00:00:00'))
        ->setAnneeFinValidite(date('Y')  . '-' . (date('Y')+1))
        ->addUaiEtab('0560010G')
        ->setLibelleRessource('Centre de ressources pedagogiques en francais')
        ->setTypeAffectation(\Ludicat\ApiGar\Model\Abonnement::TYPE_INDIV)
        ->setCategorieAffectation(\Ludicat\ApiGar\Model\Abonnement::CATEGORY_TRANSFERABLE)
        ->setNbLicenceGlobale(\Ludicat\ApiGar\Model\Abonnement::UNLIMITED_LICENCE)
        ->setCodeProjetRessource('CODEPRJ001')
    ;
    
    // Optional, you can validate the object here for easier data control
    $validator = new \Ludicat\ApiGar\Validator\AbonnementValidator();
    $validatorResponse = $validator->validate($abonnement);
    if (!$validatorResponse->isValid()) {
        foreach ($validatorResponse->getViolations() as $violation) {
        printf('%s: %s', $violation->getProperty(), $violation->getMessage());
        echo PHP_EOL;
    }
    
    // Send request
    $response = $client->create($abonnement);
    // $response = $client->update($abonnement);
    // $response = $client->delete($abonnement);
    
    // Please note they use 201 (as it should be) for OK create response, not 200
    if (201 === $response->getStatusCode()) {
        // Logic
    }
    // Don't forget to save your idAbonnement somewhere if you used the default generated one

Fetch all Abonnement
====================

    // Create client
    // Then just call this method 
    $result = $client->getAbonnements();

You can filter on specific criteria (as explained in GAR documentation)

    $abonnementFilter = new \Ludicat\ApiGar\Model\AbonnementFilter();
    $abonnementFilter
        ->setTri(\Ludicat\ApiGar\Model\AbonnementFilter::TRI_DSC) // Default sort column to id abonnement
        ->addFiltre((new \Ludicat\ApiGar\Model\Filtre(
            \Ludicat\ApiGar\Model\Filtre::FILTRE_PUBLIC_CIBLE,
            \Ludicat\ApiGar\Model\Abonnement::PUBLIC_CIBLE_ELEVE
        )))
        ->addFiltre((new \Ludicat\ApiGar\Model\Filtre(
            \Ludicat\ApiGar\Model\Filtre::FILTRE_CATEGORY_AFFECTATION,
            \Ludicat\ApiGar\Model\Abonnement::CATEGORY_TRANSFERABLE
        )))
    ;
    
    // A list of Abonnement objects
    $result = $client->getAbonnements($abonnementFilter);

Fetch all Etablissement
=======================

    // A list of Etablissement objects
    $result = $client->getEtablissements();

Run tests
=========

    make tests

